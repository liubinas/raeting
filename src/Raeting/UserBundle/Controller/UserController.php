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
}
