<?php

namespace Syngular\BackendBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class LinkRequestListener
{
    /**
     * @var ControllerResolverInterface
     */
    private $resolver;
    private $urlMatcher;

    /**
     * @param ControllerResolverInterface $controllerResolver The 'controller_resolver' service
     * @param UrlMatcherInterface         $urlMatcher         The 'router' service
     */
    public function __construct(ControllerResolverInterface $controllerResolver, UrlMatcherInterface $urlMatcher)
    {
        $this->resolver = $controllerResolver;
        $this->urlMatcher = $urlMatcher;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->getRequest()->headers->has('link')) {
            return;
        }

        $links  = array();
        $header = $event->getRequest()->headers->get('link');

        /*
         * Due to limitations, multiple same-name headers are sent as comma
         * separated values.
         *
         * This breaks those headers into Link headers following the format
         * http://tools.ietf.org/html/rfc2068#section-19.6.2.4
         */
        while (preg_match('/^((?:[^"]|"[^"]*")*?),/', $header, $matches)) {
            $header  = trim(substr($header, strlen($matches[0])));
            $links[] = $matches[1];
        }

        if ($header) {
            $links[] = $header;
        }

        $requestMethod = $this->urlMatcher->getContext()->getMethod();
        // Force the GET method to avoid the use of the
        // previous method (LINK/UNLINK)
        $this->urlMatcher->getContext()->setMethod('GET');

        // The controller resolver needs a request to resolve the controller.
        $stubRequest = new Request();
        
        foreach ($links as $idx => $link) {
            $linkParams = explode(';', trim($link));
            $resource   = array_shift($linkParams);
            $resource   = preg_replace('/\"|\"/', '', $resource);

            try {
                $route = $this->urlMatcher->match($resource);
            } catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
                // If we don't have a matching route we return
                // the original Link header
                continue;
            } catch (\Symfony\Component\Routing\Exception\MethodNotAllowedException $e) {
                // If we don't have a matching route we return
                // the original Link header
                continue;
            }

            $stubRequest->attributes->replace($route);

            if (false === $controller = $this->resolver->getController($stubRequest)) {
                continue;
            }

            // Make sure @ParamConverter and friends are handled
            $subEvent = new FilterControllerEvent($event->getKernel(), $controller, $stubRequest, HttpKernelInterface::MASTER_REQUEST);
            $event->getDispatcher()->dispatch(KernelEvents::CONTROLLER, $subEvent);
            $controller = $subEvent->getController();

            $arguments = $this->resolver->getArguments($stubRequest, $controller);

            try {
                $result = call_user_func_array($controller, $arguments);

                // By convention the controller action must return an array
                if (!is_array($result)) {
                    continue;
                }

                // The key of first item is discarded
                $links[$idx] = current($result);
            } catch (\Exception $e) {
                continue;
            }
        }

        $event->getRequest()->attributes->set('links', $links);
        $this->urlMatcher->getContext()->setMethod($requestMethod);
    }
}
