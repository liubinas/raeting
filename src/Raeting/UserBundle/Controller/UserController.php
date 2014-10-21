<?php

namespace Raeting\UserBundle\Controller;

use EstinaCMF\UserBundle\Controller\UserController as BaseController;

class UserController extends BaseController
{
    public function connectFacebookWithAccountAction()
    {
        $fbService = $this->get('fos_facebook.user.login');
        //todo: check if service is successfully connected.
        $fbService->connectExistingAccount();
        return $this->redirect($this->generateUrl('fos_user_profile_edit'));
    }

    public function loginFbAction() {
        return $this->redirect($this->generateUrl("home"));
    }

    public function editAction()
    {
        $request = $this->get('request');

        $userService = $this->get('user.service.user');
        //If not logged in
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl("estinacmf_user.security.login"));
        }

        $token = $this->get('security.context')->getToken();

        $entity = $token->getUser();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $form = $this->get('user.form.profile');
        $form->setData($entity);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $userService->updateUser();
                $this->get('session')->getFlashBag()->add(
                    'profile.update.success',
                    'Your profile was successfully updated'
                );
            }
        }

        return $this->render('RaetingUserBundle:User:profile_edit.html.php', array(
            'entity'      => $entity,
            'form'   => $form->createView(),
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

        $url = $this->generateUrl('estinacmf_user.change_password', array(), true);

        $this->get('core.service.mailer')->sendTemplate(
                array($email),
                'user.remind',
                array('email' => $email, 'hash' => $hash, 'url' => $url)
            );

        return true;
    }
}
