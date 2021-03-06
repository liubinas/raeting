<?php

namespace Raeting\RaetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TraderController extends Controller
{
    public $resultsPerPage = 25;
    
    /**
     * @Template()
     */
    public function indexAction()
    {
        $request = $this->get('request');
        $page = $request->query->get('page');
        if(empty($page)){
            $page = 1;
        }
        $traderService = $this->get('user.service.user');
        $entities = $traderService->getAllWithPaging($this->resultsPerPage, $page);
        $totalTraders = $traderService->countAll();

        return $this->render('RaetingRaetingBundle:Trader:index.html.php', array(
            'entities'=>$entities,
            'totalTraders' => $totalTraders,
            'perPage' => $this->resultsPerPage,
            'page' => $page
            ));
    }

    /**
     * Finds and displays a Trader profile.
     *
     */
    public function showAction($slug)
    {
        $request = $this->get('request');
        $page = $request->query->get('page');
        if(empty($page)){
            $page = 1;
        }
        $query = $request->query->get('signal-search');
        
        $entity = $this->get('user.service.user')->getBySlug($slug);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find trader .');
        }

        if ($request->getMethod() == 'GET' && !empty($query)) {
            $signals = $this->get('raetingraeting.service.signals')->getAllByQueryAndUser($query, $entity->getId(), $this->resultsPerPage, $page);
            $totalSignals = $this->get('raetingraeting.service.signals')->countByQueryAndUser($query, $entity->getId());
        }else{
            $signals = $this->get('raetingraeting.service.signals')->getAllByTrader($entity->getId(), $this->resultsPerPage, $page);
            $totalSignals = $this->get('raetingraeting.service.signals')->countByTrader($entity->getId());
        }
        
        $chartSignals = $this->get('raetingraeting.service.signals')->getAllByUserForChart($entity->getId());
        
        return $this->render('RaetingRaetingBundle:Trader:show.html.php', array(
            'query'      => $query,
            'entity'      => $entity,
            'signals'     => $signals,
            'totalSignals' => $totalSignals,
            'perPage' => $this->resultsPerPage,
            'page' => $page,
            'chartSignals' => $chartSignals
        ));
    }
}
