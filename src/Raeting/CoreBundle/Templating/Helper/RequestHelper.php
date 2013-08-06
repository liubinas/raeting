<?php

namespace Raeting\CoreBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\HttpFoundation\Request;

class RequestHelper extends Helper
{
    protected $request;

    /**
     * Constructor.
     *
     * @param Request $request A Request instance
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Returns a parameter from the current request object.
     *
     * @param string $key     The name of the parameter
     * @param string $default A default value
     *
     * @see Symfony\Component\HttpFoundation\Request::get()
     */
    public function getParameter($key, $default = null)
    {
        return($this->request->get($key, $default));
    }

    /**
     * @see Symfony\Component\HttpFoundation\Request::getRequestUri
     */
    public function getRequestUri()
    {
        return $this->request->getRequestUri();
    }
    /**
     * @see Symfony\Component\HttpFoundation\Request::getUri
     */
    public function getUri()
    {
        return $this->request->getUri();
    }

    public function isSecure()
    {
        return $this->request->isSecure();
    }

    public function getHost()
    {
        return $this->request->getHost();
    }

    public function getRequest()
    {
        return $this->request;
    }
    public function getCharset()
    {
        if ($this->getParameter('language') == 'zh') {
            
            return 'zh-CN';
        } else {
           
            return 'en-GB'; 
        }
    }

    public function getSession()
    {
        return $this->request->getSession();
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName()
    {
        return 'request';
    }
    public function getRootUrl(){
        if ($this->isSecure() === true) {
            
            return 'https://'.$this->getHost();
            
        } else {
            
            return 'http://'.$this->getHost();
           
        }
    }
}
