<?php

namespace Raeting\CoreBundle\Controller;

use Symfony\Component\HttpKernel\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ExceptionController extends Controller
{
    /**
     * Converts an Exception to a Response.
     *
     * @param FlattenException $exception A FlattenException instance
     * @param DebugLoggerInterface $logger A DebugLoggerInterface instance
     * @param string $format The format to use for rendering (html, xml, …)
     * @param Boolean $embedded Whether the rendered Response will be embedded or not
     *
     * @throws \InvalidArgumentException When the exception template does not exist
     */
    public function exceptionAction(FlattenException $exception, DebugLoggerInterface $logger = null, $format = 'html', $embedded = false)
    {
        $this->container->get('request')->setRequestFormat($format);

        // the count variable avoids an infinite loop on
        // some Windows configurations where ob_get_level()
        // never reaches 0

        $count = 100;
        $currentContent = '';
        while (ob_get_level() && --$count) {
            $currentContent .= ob_get_clean();
        }

        //Debug mode shows exception and live shows error pages
        $name = $this->container->get('kernel')->isDebug() ? 'exception' : 'error';

        //3 types of status codes: 2xx (OK), 3xx (redirection), 4xx/5xx (errors)
        $code = $exception->getStatusCode();

        return $this->render('RaetingCoreBundle:Exception:404.html.php', array(
            'statusCode'     => $code,
            'statusText'     => Response::$statusTexts[$code],
            'exception'      => $exception,
            'logger'         => $logger,
            'currentContent' => $currentContent,
            'isDebug'        => $this->container->get('kernel')->isDebug(),
        ));
    }
}
