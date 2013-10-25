<?php

namespace Raeting\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

use JMS\SecurityExtraBundle\Annotation\Secure;

use EstinaCMF\UserBundle\Event\UserRegisteredEvent;

use EstinaCMF\UserBundle\Controller\RegistrationController as BaseController;

/**
 * Registration controller
 */
class RegistrationController extends BaseController
{
    /**
     * User registration form.
     *
     * @return Response
     */

    public function registerAction(Request $request)
    {
        $form = $this->get('user.form.registration');
        $userService = $this->get('user.service.user');
        $dispatcher = $this->get('event_dispatcher');

        $form->setData($userService->createUser());
        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $user = $form->getData();
                $user->setSlug($userService->createSlug($user->getFirstname(), $user->getLastname()));
                
                $user = $userService->register($user);
                $dispatcher->dispatch(UserRegisteredEvent::NAME, new UserRegisteredEvent($user));
   
                return $this->redirect($this->generateUrl('estinacmf_user.registration.success'));
            }
        }

        return $this->render('EstinaCMFUserBundle:Registration:register.html.php', array(
            'form' => $form->createView()
        ));
    }
}