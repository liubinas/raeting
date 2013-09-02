<?php

namespace Raeting\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TraderController extends Controller
{
    public function showAction($id)
    {
        $serializer = $this->get('jms_serializer');

        $traderService = $this->get('raetingraeting.service.trader');
        $trader = $traderService->get($id);

        if ('json' === $this->getRequest()->get('_format')){

            return new Response($serializer->serialize($traderList, 'json'));
        } else {

            return new Response($serializer->serialize($traderList, 'xml'));
        }
    }
    public function indexAction()
    {
        $serializer = $this->get('jms_serializer');
        $traderService = $this->get('raetingraeting.service.trader');
        $traders = $traderService->getAll();

        if ('json' === $this->getRequest()->get('_format')){

            return new Response($serializer->serialize($traderList, 'json'));
        } else {

            return new Response($serializer->serialize($traderList, 'xml'));
        }
    }
}