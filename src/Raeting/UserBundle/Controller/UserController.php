<?php

namespace Raeting\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller
 */
class UserController extends Controller
{

    /**
     * Partial user information.
     *
     * @return Request
     */
    public function partialAction()
    {
        $token = $this->get('security.context')->getToken();

        return $this->render("RaetingUserBundle:User:partial.html.php", array(
            'user' => $token->getUser(),
            'isAuthenticated' => $token->isAuthenticated()
        ));
    }

    /**
     * User registration form.
     *
     * @return Response
     */
    public function registerAction()
    {
        //If already logged in.
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException;
        }

        $form = $this->get('user.form.register');

        $request = $this->get('request');
        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $userService = $this->get('user.service.user');
                $userId = $userService->register($form->getData());
                $data = $form->getData();
                
                $data['url'] = $this->generateUrl('login', array(), true);
                
                $this->get('core.service.mailer')->sendTemplate(
                    array($form['email']->getData()),
                    'user.register',
                    $data
                );
   
                return $this->redirect($this->generateUrl('user.register_success'));
            }
        }

        return $this->render('RaetingUserBundle:User:register.html.php', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Successful registraction page.
     *
     * @return Response
     */
    public function registerSuccessAction()
    {
        return $this->render('RaetingUserBundle:User:register_success.html.php');
    }

    /**
     * Password recovery.
     *
     * @return Response
     */
    public function recoverAction()
    {
        //If already logged in.
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException;
        }

        $form = $this->get('user.form.recover');
        $request = $this->get('request');

        $isValid = false;

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $isValid = true;
                $userService = $this->get('user.service.user');
                $data = $form->getData();
                $hash = $userService->createUserHash($data['email']);

                $this->sendRecoveryMail($data['email'], $hash);
            }
        }

        return $this->render('RaetingUserBundle:User:recover.html.php', array(
            'posted' => $isValid,
            'form' => $form->createView()
        ));
    }

    /**
     * Send password recovery email to user.
     *
     * @param string $email User email.
     * @param string $hash  Recovery hash.
     *
     * @return bool
     */
    protected function sendRecoveryMail($email, $hash)
    {
        $url = $this->generateUrl('user.recover', array(), true);
        $body = sprintf("Email: %s<br>Hash: <strong>%s</strong><br>Url: <a href='%s'>%s</a>",
            $email, $hash, $url, $url);

        $message = $this->get('core.service.mailer')
            ->newMessage('Password recovery')
            ->setTo(array($email))
            ->setBody($body, 'text/html');
        $result = $this->get('mailer')->send($message);  //TODO: log if failed

        return $result;
    }

    /**
     * Apply recovery hash.
     *
     * @return void
     */
    public function changePasswordAction()
    {
        //If already logged in.
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException;
        }

        $changed = null;
        $form = $this->get('user.form.change_password');
        $request = $this->get('request');

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $userService = $this->get('user.service.user');
                $changed = $userService->changePassword($form->getData());
            }
        }

        return $this->render('RaetingUserBundle:User:change_password.html.php', array(
            'changed' => $changed,
            'posted' => 'POST' === $request->getMethod(),
            'form' => $form->createView()
        ));
    }
    
    /**
     * Change old password.
     *
     * @return void
     */
    public function newPasswordAction(Request $request)
    {
        //If not logged in
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException;
        }

        $form = $this->get('user.form.new_password');
        $userService = $this->get('user.service.user');
        $token = $this->get('security.context')->getToken();

        $id = $token->getUser()->getId();

        $userArray = $userService->getById($id);
        $user['id'] = $userArray['id'];
        
        $form->setData($user);
        
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $return = $userService->updatePassword($form->getData());

                if ($return === false) {
                    $this->get('session')->getFlashBag()->set('error', 'core.failure');

                } else {
                    $this->get('session')->getFlashBag()->set('success', 'core.success');

                    return new RedirectResponse($this->get('router')->generate('user.profile'));
                }

            }
        }
        
        return $this->render('RaetingUserBundle:User:new_password.html.php', array('form' => $form->createView(), 'menuOpen' => 'settings'));
    }

    /**
     * Edit profile form
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Request $request)
    {
        //If not logged in
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException;
        }

        $form = $this->get('user.form.profile');
        $userService = $this->get('user.service.user');
        $token = $this->get('security.context')->getToken();

        $id = $token->getUser()->getId();

        $userArray = $userService->getById($id);
        $user['id'] = $userArray['id'];
        $user['firstname'] = $userArray['firstname'];
        $user['lastname'] = $userArray['lastname'];
        $user['street'] = $userArray['street'];
        $user['state'] = $userArray['state'];
        $user['postal_code'] = $userArray['postal_code'];

        $form->setData($user);
        
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $return = $userService->updateProfile($form->getData());

                if ($return === false) {
                    $this->get('session')->getFlashBag()->set('error', 'merchant.core.failure');

                } else {
                    $this->get('session')->getFlashBag()->set('success', 'merchant.core.success');

                    return new RedirectResponse($this->get('router')->generate('user.profile'));
                }

            }
        }

        return $this->render('RaetingUserBundle:User:profile_edit.html.php', array('form' => $form->createView(), 'menuOpen' => 'profile'));
    }

    /**
     * Profile page
     *
     * @param int $id
     *
     * @return Response
     */
    public function indexAction()
    {
        $userService = $this->get('user.service.user');
        $token = $this->get('security.context')->getToken();
        $user = $userService->getById($token->getUser()->getId());

        return $this->render('RaetingUserBundle:User:profile.html.php', array('user' => $user, 'menuOpen' => 'profile'));
    }
    
    public function simpleLoginAction()
    {
        return $this->render('RaetingUserBundle:User:simple_login.html.php', array('noLoginButton' => true));
    }
}
