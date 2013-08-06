<?php

namespace Raeting\CoreBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\HttpFoundation\Request;

class PaginationHelper extends Helper
{
    protected $templating;
    protected $router;

    /**
     * Constructor.
     *
     */
    public function __construct($templating, $router)
    {
        $this->templating = $templating;
        $this->router = $router;
    }

    public function render($page, $total, $perPage, $route, $routeParams = array(), $layout = 'main_layout')
    {
        $from = $this->getDisplayFrom($page, $perPage);
        $to = $this->getDisplayTo($page, $perPage, $total);

        $prevPage = $this->getPrevPage($page);
        $nextPage = $this->getNextPage($page, $perPage, $total);

        $urlNext = '';
        if ($nextPage)
        {
            $routeParams['page'] = $nextPage;
            $urlNext = $this->router->generate($route, $routeParams);
        }

        $urlPrev = '';
        if ($prevPage)
        {
            $routeParams['page'] = $prevPage;
            $urlPrev = $this->router->generate($route, $routeParams);
        }
        if($layout == 'merchant_layout'){
            $htmlFilename = 'RaetingCoreBundle:Helper:paginationMerchant.html.php';
        }else{
            $htmlFilename = 'RaetingCoreBundle:Helper:pagination.html.php';
        }
        return $this->templating->render($htmlFilename, array(
            'total' => $total,
            'perPage' => $perPage,
            'from' => $from,
            'to' => $to,
            'urlNext' => $urlNext,
            'urlPrev' => $urlPrev,
        ));
    }

    public function getPageCount($perPage, $total)
    {
        $r = ceil($total / $perPage);

        return $r;
    }

    /**
     * Returns next page number, null if not exists
     * @return int|null page number or null if next page does not exist
     */
    public function getNextPage($page, $perPage, $total)
    {
        $count = $this->getPageCount($perPage, $total);

        $r = $page + 1;
        if ($r > $count || $page < 1)
        {
            $r = null;
        }

        return $r;
    }


    /**
     * Returns previous page number, null if not exists
     * @return int|null page number or null if previous page does not exist
     */
    public function getPrevPage($page)
    {
        $r = $page - 1;
        if ($r < 1)
        {
            $r = null;
        }

        return $r;
    }

    public function getDisplayFrom($page, $perPage)
    {
        $r = ($page * $perPage) - $perPage + 1;

        return $r;
    }

    public function getDisplayTo($page, $perPage, $total)
    {
        $r = ($page * $perPage);
        if ($r > $total)
        {
            $r = $total;
        }

        return $r;
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName()
    {
        return 'pagination';
    }
}
