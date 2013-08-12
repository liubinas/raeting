<?php

namespace Raeting\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TraderController extends Controller
{
    public function showAction($id)
    {
        return new Response($this->getRequest()->get('_format').' trader item:here+'.$id);
    }
    public function indexAction()
    {
        return new Response($this->getRequest()->get('_format').' trader list:here+');
    }
}