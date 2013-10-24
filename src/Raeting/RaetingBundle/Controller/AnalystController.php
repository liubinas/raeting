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
        $request = $this->get('request');
        $page = $request->query->get('page');
        if(empty($page)){
            $page = 1;
        }
        
        $analyst = $this->get('raetingraeting.service.analyst')->get($id);
        $analysisService = $this->get('raetingraeting.service.analysis');
        
        $query = $request->query->get('analysis-search');
        if ($request->getMethod() == 'GET' && !empty($query)) {
            $analysis = $analysisService->getAllByAnalystAndQuery($id, $query, $this->resultsPerPage, $page);
            $totalAnalysis = $analysisService->countAllByAnalystAndQuery($id, $query);
        }else{
            $analysis = $analysisService->getAllByAnalyst($id, $this->resultsPerPage, $page);
            $totalAnalysis = $analysisService->countAllByAnalyst($id);
        }
            
        return $this->render('RaetingRaetingBundle:Analyst:show.html.php', array(
            'analyst' => $analyst,
            'analysis' => $analysis,
            'totalAnalysis' => $totalAnalysis,
            'perPage' => $this->resultsPerPage,
            'page' => $page,
            'query' => $query,
        ));
    }
    
    public function showtickerAction($id, $ticker)
    {
        $request = $this->get('request');
        $page = $request->query->get('page');
        if(empty($page)){
            $page = 1;
        }
        
        $ticker = strtoupper($ticker);
        
        $analyst = $this->get('raetingraeting.service.analyst')->get($id);
        
        $analysisService = $this->get('raetingraeting.service.analysis');
        $symbolService = $this->get('raetingraeting.service.symbol');
        $tickerRateService = $this->get('raetingraeting.service.ticker_rate');
        
        
        $analysisRange = $analysisService->getAnalystEstimationRangeByTicker($id, $ticker);
        $analysisForGraph = $analysisService->getAllByAnalystAndTickerForGraph($id, $ticker);
        $analysis = $analysisService->getAllByAnalystAndTicker($id, $ticker, $this->resultsPerPage, $page);
        $totalAnalysis = $analysisService->countAllByAnalyst($id, $ticker);
        
        $rates = $tickerRateService->findAllBySymbolInRange($ticker, $analysisRange['min_date'], $analysisRange['max_date']);

        $symbol = $symbolService->getBySymbol($ticker);
        
        return $this->render('RaetingRaetingBundle:Analyst:show_ticker.html.php', array(
            'analyst' => $analyst,
            'analysis' => $analysis,
            'analysisForGraph' => $analysisForGraph,
            'rates' => $rates,
            'totalAnalysis' => $totalAnalysis,
            'perPage' => $this->resultsPerPage,
            'page' => $page,
            'ticker' => $symbol,
        ));
    }

}
