<?php

namespace Raeting\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class TraderController extends Controller
{

    private $serializer;
    /**
     * Constructor
     */
    public function __construct()
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * Show single Traders' $slug details
     *
     * @param $slug
     * @return Response
     */
    public function showAction($slug)
    {
        $userService = $this->get('user.service.user');
        $trader = $userService->getBySlug($slug);
        
        if(!$trader){
            throw $this->createNotFoundException('Unable to find trader.');
        }
        
        $response = array(
            'trader' => array(
                'slug'=>$trader->getSlug(),
                'firstName'=>$trader->getFirstname(),
                'lastName'=>$trader->getLastname(),
                'company'=>$trader->getCompany(),
                'about'=>$trader->getAbout(),
                //'profit'=>$trader->getProfit(),
            ),
            'meta' => array(
                'link' => $this->container->parameters['api.route_domain'].$this->get('router')->generate('trader_show', array('slug' => $trader->getSlug()))
    )
        );

        if ('xml' === $this->getRequest()->get('_format')) {
            return new Response($this->serializer->serialize($response, 'xml'));
        } else {
            return new Response($this->serializer->serialize($response, 'json'));
        }
    }

    /**
     * Return list of all Traders
     *
     * @return Response
     */
    public function indexAction()
    {
        $userService = $this->get('user.service.user');
        $traders = $userService->getTradersByRequest($this->getRequest());

        $query = '';
        if ($this->getRequest()->getQueryString()) {
            $query = '?'.$this->getRequest()->getQueryString();
        }

        $traderList = array('traders' => array(), 'meta' => array());
        if(!empty($traders)){
            foreach ($traders as $trader) {
                $traderList['traders'][] = array(
                    'trader' => array(
                        'slug'=>$trader->getSlug(),
                        'firstName'=>$trader->getFirstname(),
                        'lastName'=>$trader->getLastname(),
                        'company'=>$trader->getCompany(),
                        'about'=>$trader->getAbout(),
                        //'profit'=>$trader->getProfit(),
                    )
                );
            }
        }

        $totalResults = $userService->getTradersCountByRequest($this->getRequest());

        $traderList['meta']['total'] = $totalResults;
        if ($this->getRequest()->get('limit')) {
            $traderList['meta']['limit'] = $this->getRequest()->get('limit');
        } else {
            $traderList['meta']['limit'] = $userService->defaultLimit;
        }
        if ($this->getRequest()->get('offset')) {
            $traderList['meta']['offset'] = $this->getRequest()->get('offset');
        } else {
            $traderList['meta']['offset'] = $userService->defaultOffset;
        }

        $query = '';
        if ($this->getRequest()->getQueryString()) {
            $query = '?'.$this->getRequest()->getQueryString();
        }

        $traderList['meta']['link'] = $this->container->parameters['api.route_domain'].$this->get('router')->generate('trader').$query;

        $response = $traderList;

        if ('xml' === $this->getRequest()->get('_format')) {
            return new Response($this->serializer->serialize($response, 'xml'));
        } else {
            return new Response($this->serializer->serialize($response, 'json'));
        }
    }

    /**
     * Return Traders $slug signals
     *
     * @param $slug
     * @return Response
     */
    public function signalsAction($slug)
    {

        $signalService = $this->get('raetingraeting.service.signals');
        $signals = $signalService->getSignalsByRequestAndTraderSlug($this->getRequest(), $slug);

        $query = '';
        if ($this->getRequest()->getQueryString()) {
            $query = '?'.$this->getRequest()->getQueryString();
        }

        $signalList = array('signals' => array(), 'meta' => array());
        if(!empty($signals)){
            foreach ($signals as $signal) {
                $signalList['signals'][] = array(
                    'uuid'=>$signal->getUuid(),
                    'type'=>$signal->getBuyValue(),
                    'symbol'=>$signal->getSymbol()->getTitle(),
                    'open'=>$signal->getOpen(),
                    'takeProfit'=>$signal->getTakeprofit(),
                    'stopLoss'=>$signal->getStoploss(),
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
                        'company'=>$signal->getUser()->getCompany(),
                        'about'=>$signal->getUser()->getAbout(),
                        //'profit'=>$signal->getUser()->getProfit(),
                    )
                );
            }
        }

        $totalResults = $signalService->getSignalsCountByRequest($this->getRequest());

        $signalList['meta']['total'] = $totalResults;
        if ($this->getRequest()->get('limit')) {
            $signalList['meta']['limit'] = $this->getRequest()->get('limit');
        } else {
            $signalList['meta']['limit'] = $signalService->defaultLimit;
        }
        if ($this->getRequest()->get('offset')) {
            $signalList['meta']['offset'] = $this->getRequest()->get('offset');
        } else {
            $signalList['meta']['offset'] = $signalService->defaultOffset;
        }

        $signalList['meta']['link'] = $this->container->parameters['api.route_domain'].$this->get('router')->generate('trader_show', array('slug'=>$slug)).$query;

        $response = $signalList;

        if ('xml' === $this->getRequest()->get('_format')) {
            return new Response($this->serializer->serialize($response, 'xml'));
        } else {
            return new Response($this->serializer->serialize($response, 'json'));
        }
    }
}
