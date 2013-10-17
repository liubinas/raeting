<?php
namespace Raeting\RaetingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Signals controller.
 *
 */
class AnalystController extends Controller
{
    
    public $resultsPerPage = 10;
    
    public function indexAction()
    {
        $request = $this->get('request');
        
        $page = $request->query->get('page');
        if(empty($page)){
            $page = 1;
        }
        $entities = $this->get('raetingraeting.service.analyst')->getAllWithPaging($this->resultsPerPage, $page);
        $totalEntities = $this->get('raetingraeting.service.analyst')->countAll();
        
        return $this->render('RaetingRaetingBundle:Analyst:index.html.php', array(
            'entities' => $entities,
            'totalEntities' => $totalEntities,
            'perPage' => $this->resultsPerPage,
            'page' => $page
        ));
    }
    
    public function showAction($id)
    {
        
        $analyst = $this->get('raetingraeting.service.analyst')->get($id);
        $analysis = $this->get('raetingraeting.service.analysis')->getAllByAnalyst($id);

        return $this->render('RaetingRaetingBundle:Analyst:show.html.php', array(
            'analyst' => $analyst,
            'analysis' => $analysis,
        ));
    }

}
