<?php

namespace Raeting\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SignalController extends Controller
{
    public function showAction($id)
    {
        $signalService = $this->get('raetingraeting.service.signals');
        $signal = $signalService->get($id);

        if ('json' === $this->getRequest()->get('_format')){

            return new Response(json_encode($signal));
        } else {

            return new Response($this->getRequest()->get('_format').' signal item:here+'.$id);
        }
    }
    public function indexAction()
    {
        $signalService = $this->get('raetingraeting.service.signals');
        $signals = $signalService->getAll();

        if ('json' === $this->getRequest()->get('_format')){

            return new Response(json_encode($signals));
        } else {

            return new Response($this->getRequest()->get('_format').' signals list:here+');
        }
    }
}