<?php

namespace Raeting\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SignalController extends Controller
{
    public function showAction($id)
    {
        $serializer = $this->get('jms_serializer');
        $signalService = $this->get('raetingraeting.service.signals');
        $signal = $signalService->get($id);
        $signalList = array('uuid'=>$signal->getUuid(),
            'buy'=>$signal->getBuy(),
            'quote'=>$signal->getQuote()->getTitle(),
            'take_profit'=>$signal->getTakeprofit(),
            'stop_loss'=>$signal->getStoploss(),
            'close'=>$signal->getClose(),
            'profit'=>$signal->getProfit(),
            'description'=>$signal->getDescription(),
            'created'=>$signal->getCreated(),
            'opened'=>$signal->getOpened(),
            'open_expire'=>$signal->getOpenExpire(),
            'close'=>$signal->getClosed(),
            'close_expire'=>$signal->getCloseExpire(),
            'user'=> array(
                'id' => $signal->getUser()->getId(),
                'firstname' => $signal->getUser()->getFirstname(),
                'lastname' => $signal->getUser()->getLastname(),
                )
        );

        if ('json' === $this->getRequest()->get('_format')){

            return new Response($serializer->serialize($signalList, 'json'));
        } else {

            return new Response($serializer->serialize($signalList, 'xml'));
        }
    }
    public function indexAction()
    {
        $serializer = $this->get('jms_serializer');
        $signalService = $this->get('raetingraeting.service.signals');
        $signals = $signalService->getAll();
        $signalList = array();

        foreach($signals as $signal) {
            $signalList[] = array('uuid'=>$signal->getUuid(),
                'buy'=>$signal->getBuy(),
                'quote'=>$signal->getQuote()->getTitle(),
                'take_profit'=>$signal->getTakeprofit(),
                'stop_loss'=>$signal->getStoploss(),
                'close'=>$signal->getClose(),
                'profit'=>$signal->getProfit(),
                'description'=>$signal->getDescription(),
                'created'=>$signal->getCreated(),
                'opened'=>$signal->getOpened(),
                'open_expire'=>$signal->getOpenExpire(),
                'close'=>$signal->getClosed(),
                'close_expire'=>$signal->getCloseExpire(),
                'user'=>    array(
                    'id' => $signal->getUser()->getId(),
                    'firstname' => $signal->getUser()->getFirstname(),
                    'lastname' => $signal->getUser()->getLastname(),
                )
            );

        }
        if ('json' === $this->getRequest()->get('_format')){

            return new Response($serializer->serialize($signalList, 'json'));
        } else {

            return new Response($serializer->serialize($signalList, 'xml'));
        }
    }
}