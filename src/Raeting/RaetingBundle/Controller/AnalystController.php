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
    
    public $resultsPerPage = 25;
    
    public function indexAction()
    {
        $request = $this->get('request');
        $page = $request->query->get('page');
        if(empty($page)){
            $page = 1;
        }
        
        $analystService = $this->get('raetingraeting.service.analyst');
        
        $query = $request->query->get('analysis-search');
        if ($request->getMethod() == 'GET' && !empty($query)) {
            $analysts = $analystService->getAllByQuery($query, $this->resultsPerPage, $page);
            $totalAnalysts = $analystService->countAllByQuery($query);
        }else{
            $analysts = $analystService->getAllWithPaging($this->resultsPerPage, $page);
            $totalAnalysts = $analystService->countAll();
        }
        $analysts = $analystService->prepareListingData($analysts);
        return $this->render('RaetingRaetingBundle:Analyst:index.html.php', array(
            'analysts' => $analysts,
            'totalAnalysts' => $totalAnalysts,
            'perPage' => $this->resultsPerPage,
            'page' => $page,
            'query' => $query,
        ));
    }
    
    public function showAction($slug)
    {
        $request = $this->get('request');
        $page = $request->query->get('page');
        if(empty($page)){
            $page = 1;
        }
        
        $analyst = $this->get('raetingraeting.service.analyst')->getBySlug($slug);
        $id = $analyst->getId();
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
    
    public function analysisAction()
    {
        $request = $this->get('request');
        $page = $request->query->get('page');
        if(empty($page)){
            $page = 1;
        }
        
        $analysisService = $this->get('raetingraeting.service.analysis');
        
        $query = $request->query->get('analysis-search');
        if ($request->getMethod() == 'GET' && !empty($query)) {
            $analysis = $analysisService->getAllByQuery($query, $this->resultsPerPage, $page);
            $totalAnalysis = $analysisService->countAllByQuery($query);
        }else{
            $analysis = $analysisService->getAllWithPaging($this->resultsPerPage, $page);
            $totalAnalysis = $analysisService->countAll();
        }
            
        return $this->render('RaetingRaetingBundle:Analyst:analysis.html.php', array(
            'analysis' => $analysis,
            'totalAnalysis' => $totalAnalysis,
            'perPage' => $this->resultsPerPage,
            'page' => $page,
            'query' => $query,
        ));
    }
    
    public function showAnalystTickerAction($slug, $ticker)
    {
        $request = $this->get('request');
        $page = $request->query->get('page');
        if(empty($page)){
            $page = 1;
        }
        
        $ticker = strtoupper($ticker);
        
        $analyst = $this->get('raetingraeting.service.analyst')->getBySlug($slug);
        $id = $analyst->getId();
        
        $analysisService = $this->get('raetingraeting.service.analysis');
        $symbolService = $this->get('raetingraeting.service.symbol');
        $rateService = $this->get('raetingraeting.service.rate');
        
        
        $analysisRange = $analysisService->getAnalystEstimationRangeByTicker($id, $ticker);
        $analysisForGraph = $analysisService->getAllByAnalystAndTickerForGraph($id, $ticker);
        $analysis = $analysisService->getAllByAnalystAndTicker($id, $ticker, $this->resultsPerPage, $page);
        $totalAnalysis = $analysisService->countAllByAnalyst($id, $ticker);
        
        $symbol = $symbolService->getBySymbol($ticker);
        
        $rates = $rateService->findAllBySymbolInRangeByDay($symbol, $analysisRange['min_date'], $analysisRange['max_date']);

        return $this->render('RaetingRaetingBundle:Analyst:show_analyst_ticker.html.php', array(
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
    
    public function showtickerAction($ticker)
    {
        $request = $this->get('request');
        $page = $request->query->get('page');
        if(empty($page)){
            $page = 1;
        }
        
        $ticker = strtoupper($ticker);
        
        $analysisService = $this->get('raetingraeting.service.analysis');
        $symbolService = $this->get('raetingraeting.service.symbol');
        
        $query = $request->query->get('analysis-search');
        if ($request->getMethod() == 'GET' && !empty($query)) {
            $analysis = $analysisService->getAllByTickerWithPagingByQuery($ticker, $this->resultsPerPage, $page, $query);
            $totalAnalysis = $analysisService->countAllByTickerAndQuery($ticker, $query);
        }else{
            $analysis = $analysisService->getAllByTickerWithPaging($ticker, $this->resultsPerPage, $page);
            $totalAnalysis = $analysisService->countAllByTicker($ticker);
        }
        
        $symbol = $symbolService->getBySymbol($ticker);
        
        return $this->render('RaetingRaetingBundle:Analyst:show_ticker.html.php', array(
            'analysis' => $analysis,
            'totalAnalysis' => $totalAnalysis,
            'perPage' => $this->resultsPerPage,
            'page' => $page,
            'query' => $query,
            'ticker' => $symbol,
        ));
    }
    
    public function ratingAction()
    {
        $request = $this->get('request');
        $page = $request->query->get('page');
        if(empty($page)){
            $page = 1;
        }
        
        $analystService = $this->get('raetingraeting.service.analyst');
        
        $query = $request->query->get('analysis-search');
        if ($request->getMethod() == 'GET' && !empty($query)) {
            $analysts = $analystService->getAllForRatingByQuery($query, $this->resultsPerPage, $page);
            $totalAnalysts = $analystService->countAllForRatingByQuery($query);
        }else{
            $analysts = $analystService->getAllForRatingWithPaging($this->resultsPerPage, $page);
            $totalAnalysts = $analystService->countAllForRating();
        }
            var_dump($analysts);die;
        return $this->render('RaetingRaetingBundle:Analyst:rating.html.php', array(
            'analysts' => $analysts,
            'totalAnalysts' => $totalAnalysts,
            'perPage' => $this->resultsPerPage,
            'page' => $page,
            'query' => $query,
        ));
    }

}
