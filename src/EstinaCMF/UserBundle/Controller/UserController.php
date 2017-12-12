<?php

namespace EstinaCMF\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

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

        return $this->render("EstinaCMFUserBundle:User:partial.html.php", array(
            'user' => $token->getUser(),
            'isAuthenticated' => $token->isAuthenticated()
        ));
    }

    /**
     * Password recovery.
     *
     * @return Response
     */
    public function recoverAction()
    {
        // @TODO use JMSSecurity annotations 
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException;
        }

        $form = $this->get('estinacmf_user.form.recover');
        $request = $this->get('request');

        $isValid = false;

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $isValid = true;
                $userService = $this->get('estinacmf_user.service.user');
                $data = $form->getData();
                $hash = $userService->createUserHash($data['email']);

                $this->sendRecoveryMail($data['email'], $hash);
            }
        }

        return $this->render('EstinaCMFUserBundle:User:recover.html.php', array(
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
        // @TODO move to events
        $url = $this->generateUrl('estinacmf_user.change_password', array(), true);
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
        // @TODO use JMSSecurity annotations 
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException;
        }

        $changed = null;
        $form = $this->get('estinacmf_user.form.change_password');
        $request = $this->get('request');

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $userService = $this->get('estinacmf_user.service.user');
                $changed = $userService->changePassword($form->getData());
            }
        }

        return $this->render('EstinaCMFUserBundle:User:change_password.html.php', array(
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
        // @TODO use JMSSecurity annotations 
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException;
        }

        $form = $this->get('estinacmf_user.form.new_password');
        $userService = $this->get('estinacmf_user.service.user');
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

                    return new RedirectResponse($this->get('router')->generate('estinacmf_user.profile'));
                }

            }
        }
        
        return $this->render('EstinaCMFUserBundle:User:new_password.html.php', array('form' => $form->createView(), 'menuOpen' => 'settings'));
    }
}