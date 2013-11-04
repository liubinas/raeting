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

        $signal = $signalService->get($id);
        
        if(!$signal){
            throw $this->createNotFoundException('Unable to find Signal.');
        }
        
        $query = '';
        if ($this->getRequest()->getQueryString()) {
            $query = '?'.$this->getRequest()->getQueryString();
        }

        $response = array(
            'signal' => $signalService->signalToArray($signal),
            'meta' => array(
                'link' => $this->container->parameters['api.route_domain'].$this->get('router')->generate('signals_show', array('id' => $signal->getId())).$query
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
        $signals = $signalService->getAllSignalsByRequest($this->getRequest());
        
        $query = '';
        if ($this->getRequest()->getQueryString()) {
            $query = '?'.$this->getRequest()->getQueryString();
        }

        $signalList = array('signals' => array(), 'meta' => array());
        if(!empty($signals)){
            foreach ($signals as $signal) {
                $signalList['signals'][] = array(
                    'signal'=> $signalService->signalToArray($signal)
                );
            }
        }

        $totalResults = $signalService->countSignalsByRequest($this->getRequest());

        $signalList['meta']['total'] = $totalResults;
        if ($this->getRequest()->get('limit')) {
            $signalList['meta']['limit'] = $this->getRequest()->get('limit');
        } else {
            $signalList['meta']['limit'] = $this->container->parameters['default_page_limit'];
        }
        if ($this->getRequest()->get('offset')) {
            $signalList['meta']['offset'] = $this->getRequest()->get('offset');
        } else {
            $signalList['meta']['offset'] = $this->container->parameters['default_page_offset'];
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
