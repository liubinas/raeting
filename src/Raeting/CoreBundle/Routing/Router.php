<?php

namespace Raeting\CoreBundle\Routing;

use Raeting\LocalizationBundle\Service\Localization;
use Symfony\Bundle\FrameworkBundle\Routing\Router as BaseRouter;
use Symfony\Component\HttpFoundation\Request;

/**
 * Customized router.
 */
class Router extends BaseRouter
{
    private $localizationService;

    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = array(), $absolute = false)
    {
        //Set lang if it is not exist.
        if (!isset($parameters['lang'])) {
            $parameters['lang'] = $this->localizationService->getCurrentLanguage('slug');
        }

        return $this->getGenerator()->generate($name, $parameters, $absolute);
    }

    /**
     * Set localization service
     * 
     * @param Localization $localizationService 
     */
    public function setLocalizationService(Localization $localizationService)
    {
        $this->localizationService = $localizationService;
    }

    /**
     * Localize url in given language.
     * 
     * @param Request $request  Request object
     * @param int     $langId   Language id to localize url
     * @param bool    $absolute Provide absolute url
     *
     * @return string
     */
    public function localizeUrl(Request $request, $langId, $absolute = false)
    {
        $langSlug = $this->localizationService->getLanguageById($langId, 'slug');
        $route = $request->attributes->get('_route');

        $methodsMap = array(
            // 'page' => 'localizePageUrl'
        );

        $url = null;
        if (isset($methodsMap[$route])) {
            $url = $this->$methodsMap[$route]($request, $langId, $absolute);
        } else {
            $url = $this->localizeDefaultUrl($request, $langId, $absolute);
        }

        if (empty($url)) {
            $url = $this->generate('index');
        }

        return $url;
    }

    /**
     * Default url localizator for any of urls which does not need special handling.
     * 
     * @param Request $request
     * @param int     $langId
     * @param bool    $absolute
     *
     * @return string
     */
    protected function localizeDefaultUrl(Request $request, $langId, $absolute = false)
    {
        $url = null;
        $route = $request->attributes->get('_route');
        if ($route) {
            $langSlug = $this->localizationService->getLanguageById($langId, 'slug');
            $parameters = $this->getRequestParameters($request);
            $parameters['lang'] = $langSlug;
            $url = $this->generate($route, $parameters, $absolute);
        }
        return $url;
    }

    /**
     * Return cleaned request parameters.
     * 
     * @param Request $request 
     *
     * @return array
     */
    protected function getRequestParameters(Request $request)
    {
        $result = array();
        $match = $this->match($request->getPathInfo());
        foreach ($match as $key => $value) {
            if ('_' !== $key[0]) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
