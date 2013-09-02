<?php


namespace Raeting\CoreBundle\EventListener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Core listener.
 *
 * The handle method must be connected to the core.request event.
 *
 */
class CoreListener
{

    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType() &&
            strpos($event->getRequest()->get('_controller'), 'Exception') === false) {
            return;
        }
        $request = $event->getRequest();

        $this->initControllerActionNames($request);
    }


    /**
     * @param Request $request
     */
    protected function initControllerActionNames($request)
    {
        $controllerActionParts = explode('::', $request->attributes->get('_controller'));
        if (count($controllerActionParts) != 2) {
            return;
        }

        $controllerParts = explode('\\', $controllerActionParts[0]);
        $controllerName = strtolower(str_replace('Controller', '', array_pop($controllerParts)));

        $actionName = strtolower(str_replace('Action', '', $controllerActionParts[1]));

        $request->attributes->set('controllerName', $controllerName);
        $request->attributes->set('actionName', $actionName);
    }
}
