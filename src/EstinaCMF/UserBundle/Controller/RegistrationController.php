<?php

namespace EstinaCMF\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

use JMS\SecurityExtraBundle\Annotation\Secure;

use EstinaCMF\UserBundle\Event\UserRegisteredEvent;

/**
 * Registration controller
 */
class RegistrationController extends Controller
{
    /**
     * User registration form.
     *
     * @return Response
     */

    public function registerAction(Request $request)
    {
        $form = $this->get('estinacmf_user.form.registration');
        $userService = $this->get('estinacmf_user.service.user');
        $dispatcher = $this->get('event_dispatcher');

        $form->setData($userService->getNew());

        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                
                $user = $userService->register($form->getData());
                $dispatcher->dispatch(UserRegisteredEvent::NAME, new UserRegisteredEvent($user));
   
                return $this->redirect($this->generateUrl('estinacmf_user.registration.success'));
            }
        }

        return $this->render('EstinaCMFUserBundle:Registration:register.html.php', array(
            'form' => $form->createView()
        ));
    }


    /**
     * Successful registraction page.
     *
     * @return Response
     */
    public function successAction()
    {
        return $this->render('EstinaCMFUserBundle:Registration:success.html.php');
    }
}