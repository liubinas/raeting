<?php

namespace Raeting\CoreBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Templating\DelegatingEngine as Templating;
use Raeting\CoreBundle\Service\Meta;

class MetaHelper extends Helper
{
    /**
     * @var Raeting\CoreBundle\Service\Meta
     */
    protected $metaService;

    /*
     * @var Symfony\Component\Templating\Helper\Helper
     */
    protected $templating;

    /**
     * @var Symfony\Component\HttpFoundation\Request
     */
    protected $request;


    /**
     * @param Raeting\CoreBundle\Service\Meta                    $metaService 
     * @param Symfony\Component\Templating\Helper\Helper        $templating     
     * @param Symfony\Component\HttpFoundation\Request          $request    
     */
    public function __construct(Meta $metaService, Templating $templating, Request $request)
    {
        $this->metaService = $metaService;
        $this->templating = $templating;
        $this->request = $request;
    }

    public function render($title, $keywords, $description)
    {
        return $this->templating->render('RaetingCoreBundle:Helper:meta.html.php', array(
            'title' => filter_var($title, FILTER_SANITIZE_STRING),
            'description' => filter_var($description, FILTER_SANITIZE_STRING),
            'keywords' => filter_var($keywords, FILTER_SANITIZE_STRING),
            'canonical' => ($this->request->getRequestUri() === "/en" ? true : false)
        ));
    }

    public function renderFacebookTags($title, $description, $url, $siteName, $image = null, $type = null)
    {
        return $this->templating->render('RaetingCoreBundle:Helper:facebook.html.php', array(
            'title' => filter_var($title, FILTER_SANITIZE_STRING),
            'description' => filter_var($description, FILTER_SANITIZE_STRING),
            'url' => filter_var($url, FILTER_SANITIZE_STRING),
            'siteName' => filter_var($siteName, FILTER_SANITIZE_STRING),
            'image' => filter_var($image, FILTER_SANITIZE_STRING),
            'type' => (null === $type) ? $this->type():filter_var($type, FILTER_SANITIZE_STRING),
        )); 
    }

    /**
     * @param  string $slug
     * @return String
     */
    public function title()
    {
        return $this->metaService->getValueByFieldAndRequest('title', $this->request);
    }

    /**
     * @param  string $slug
     * @return String
     */
    public function description()
    {
        return $this->metaService->getValueByFieldAndRequest('description', $this->request);
    }

    /**
     * @param  string $slug
     * @return String
     */
    public function keywords()
    {
        return $this->metaService->getValueByFieldAndRequest('keywords', $this->request);
    }

    /**
     * @param  string $slug
     * @return String
     */
    public function getDefaultTitle()
    {
        return $this->metaService->getDefaultValueByFieldAndRequest('title', $this->request);
    }

    /**
     * @param  string $slug
     * @return String
     */
    public function getDefaultDescription()
    {
        return $this->metaService->getDefaultValueByFieldAndRequest('description', $this->request);
    }

    /**
     * @param  string $slug
     * @return String
     */
    public function getDefaultKeywords()
    {
        return $this->metaService->getDefaultValueByFieldAndRequest('keywords', $this->request);
    }    

    public function type()
    {
        return 'website';
    }

    public function siteName()
    {
        return 'Raeting';
    }

    public function getPageNumber()
    {
        return $this->metaService->getPageNumberFromRequest($this->request);
    }

    public function renderTripListing($searchData, $routeParams)
    {
        $params = '';
        if(!empty($routeParams['stop_start_slug']) &&  !empty($routeParams['stop_end_slug'])){
            $params = $routeParams['stop_start_slug'] . ' > ' . $routeParams['stop_end_slug'];
        }elseif(!empty($routeParams['stop_start_slug'])){   
            $params = $routeParams['stop_start_slug'];
        }elseif(!empty($routeParams['stop_end_slug'])){
            $params = $routeParams['stop_end_slug'];  
        }

        if(!empty($searchData['date'])){
            $params .= ' ' . $searchData['date'];    
        }

        $title = $this->title();
        $description = $this->description();
        $keywords = $this->keywords();

        return $this->render(
            (!empty($title) ? $title . ' ' . $searchData['date'] : $params . ' ' . $this->getDefaultTitle()),
            (!empty($description) ? $description . ' ' . $searchData['date'] :  $this->getDefaultDescription()  . ' ' . $params),
            (!empty($keywords) ? $keywords . ' ' . $searchData['date'] : $this->getDefaultKeywords() . ' ' . $params) 
        );
    }
  

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName()
    {
        return 'meta';
    }    
}