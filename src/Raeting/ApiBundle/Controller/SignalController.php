<?php

namespace Raeting\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class SignalController extends Controller
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
     * Show single Signal info
     * @param $id
     * @return Response
     */
    public function showAction($id)
    {
        $signalService = $this->get('raetingraeting.service.signals');

        $signal = $signalService->getByUuid($id);

        $query = '';
        if ($this->getRequest()->getQueryString()) {
            $query = '?'.$this->getRequest()->getQueryString();
        }

        $response = array(
            'signal' => array(
                'uuid'=>$signal->getUuid(),
                'type'=>$signal->getBuyValue(),
                'symbol'=>$signal->getSymbol()->getTitle(),
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
                    'company'=>$signal->getUser()->getCompany(),
                    'about'=>$signal->getUser()->getAbout(),
                    //'profit'=>$signal->getUser()->getProfit(),
                )
            ),
            'meta' => array(
                'link' => $this->container->parameters['api.route_domain'].$this->get('router')->generate('signals_show', array('uid' => $signal->getUuid())).$query
            )
        );

        if ('xml' === $this->getRequest()->get('_format')) {
            return new Response($this->serializer->serialize($response, 'xml'));
        } else {
            return new Response($this->serializer->serialize($response, 'json'));
        }
    }

    /**
     * Show  signals list
     *
     * @return Response
     */
    public function indexAction()
    {
        $signalService = $this->get('raetingraeting.service.signals');
        $signals = $signalService->getSignalsByRequest($this->getRequest());

        $query = '';
        if ($this->getRequest()->getQueryString()) {
            $query = '?'.$this->getRequest()->getQueryString();
        }

        $signalList = array('signals' => array(), 'meta' => array());
        foreach ($signals as $signal) {
            $signalList['signals'][] = array(
                'signal'=> array(
                    'uuid'=>$signal->getUuid(),
                    'type'=>$signal->getBuyValue(),
                    'symbol'=>$signal->getSymbol()->getTitle(),
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
                        'company'=>$signal->getUser()->getCompany(),
                        'about'=>$signal->getUser()->getAbout(),
                        //'profit'=>$signal->getUser()->getProfit(),
                    )
                )
            );
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

        $signalList['meta']['link'] = $this->container->parameters['api.route_domain'].$this->get('router')->generate('signals').$query;

        $response = $signalList;

        if ('xml' === $this->getRequest()->get('_format')) {
            return new Response($this->serializer->serialize($response, 'xml'));
        } else {
            return new Response($this->serializer->serialize($response, 'json'));
        }
    }
}
