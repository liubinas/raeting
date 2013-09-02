<?php

namespace Raeting\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SignalController extends Controller
{
    public function showAction($id)
    {
        $signalService = $this->get('raetingraeting.service.signals');
        $signal = $signalService->getByUuid($id);
        
        $query = '';
        if($this->getRequest()->getQueryString()){
            $query = '?'.$this->getRequest()->getQueryString();
        }
        
        if ('json' === $this->getRequest()->get('_format')){

            $response = array(
                'signal' => array(
                    'uuid'=>$signal->getUuid(),
                    'type'=>$signal->getBuyValue(),
                    'symbol'=>$signal->getQuote()->getTitle(),
                    'open'=>$signal->getOpen(),
                    'takeProfit'=>$signal->getTakeprofit(),
                    'stopLoss'=>$signal->getStoploss(),
                    'closed'=>$signal->getClose(),
                    'profit'=>$signal->getProfit(),
                    'description'=>$signal->getDescription(),
                    'status'=>$signal->getStatus(),
                    'dateCreated'=>$signal->getCreated(),
                    'dateOpened'=>$signal->getOpened(),
                    'dateClosed'=>$signal->getClosed(),
                    'trader'=>    array(
                        'slug'=>$signal->getUser()->getSlug(),
                        'firstName'=>$signal->getUser()->getFirstname(),
                        'lastName'=>$signal->getUser()->getLastname(),
                        //'company'=>$signal->getUser()->getCompany(),
                        //'about'=>$signal->getUser()->getAbout(),
                        //'profit'=>$signal->getUser()->getProfit(),
                    )
                ),
                'meta' => array(
                    'link' => $this->container->parameters['api.route_domain'].$this->get('router')->generate('signals_show', array('id' => $signal->getUuid())).$query
                )
            );
            
            return new Response(json_encode($response));
        } else {

            return new Response($this->getRequest()->get('_format').' signal item:here+'.$id);
        }
    }
    public function indexAction()
    {
        $signalService = $this->get('raetingraeting.service.signals');
        $signals = $signalService->getSignalsByRequest($this->getRequest());
        
        $query = '';
        if($this->getRequest()->getQueryString()){
            $query = '?'.$this->getRequest()->getQueryString();
        }
        
        if ('json' === $this->getRequest()->get('_format')){
            $signalList = array('signals' => array(), 'meta' => array());
            foreach($signals as $signal) {
                $signalList['signals'][] = array(
                    'uuid'=>$signal->getUuid(),
                    'type'=>$signal->getBuyValue(),
                    'symbol'=>$signal->getQuote()->getTitle(),
                    'open'=>$signal->getOpen(),
                    'takeProfit'=>$signal->getTakeprofit(),
                    'stopLoss'=>$signal->getStoploss(),
                    'closed'=>$signal->getClose(),
                    'profit'=>$signal->getProfit(),
                    'description'=>$signal->getDescription(),
                    'status'=>$signal->getStatus(),
                    'dateCreated'=>$signal->getCreated(),
                    'dateOpened'=>$signal->getOpened(),
                    'dateClosed'=>$signal->getClosed(),
                    'trader'=>    array(
                        'slug'=>$signal->getUser()->getSlug(),
                        'firstName'=>$signal->getUser()->getFirstname(),
                        'lastName'=>$signal->getUser()->getLastname(),
                        //'company'=>$signal->getUser()->getCompany(),
                        //'about'=>$signal->getUser()->getAbout(),
                        //'profit'=>$signal->getUser()->getProfit(),
                    )
                );
            }
            
            $totalResults = $signalService->getSignalsCountByRequest($this->getRequest());

            $signalList['meta']['total'] = $totalResults;
            if($this->getRequest()->get('limit')){
                $signalList['meta']['limit'] = $this->getRequest()->get('limit');
            }else{
                $signalList['meta']['limit'] = $signalService->defaultLimit;
            }
            if($this->getRequest()->get('offset')){
                $signalList['meta']['offset'] = $this->getRequest()->get('offset');
            }else{
                $signalList['meta']['offset'] = $signalService->defaultOffset;
            }
            
            $signalList['meta']['link'] = $this->container->parameters['api.route_domain'].$this->get('router')->generate('signals').$query;
            return new Response(json_encode($signalList));
        } else {

            return new Response($this->getRequest()->get('_format').' signals list:here+');
        }
    }
}