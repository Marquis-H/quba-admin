<?php


namespace CommonBundle\EventListener;


use CommonBundle\Constants\ApiCode;
use CommonBundle\Exception\ApiException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * CommonHelper constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $message = $exception->getMessage();
        if ($exception instanceof ApiException) {
            $message = $this->container->get('translator')->trans($message);
            if ($exception->getCode() == ApiCode::SERVER_ERROR) {
                $log = $this->container->get('logger');
                $log->error('error', ['message' => $message]);
                $message = '系統繁忙，請稍後再試！';
            }
            $response = new JsonResponse(['code' => $exception->getCode(), 'message' => $message], Response::HTTP_OK, [
                'Access-Control-Allow-Origin' => $this->container->getParameter('api_domain_allow'),
                'Access-Control-Allow-Headers' => 'Content-Type',
                'Access-Control-Allow-Methods' => 'GET,HEAD,OPTIONS,POST,PUT'
            ]);
            $event->allowCustomResponseCode();
            $event->setResponse($response);
        } else {
            $log = $this->container->get('logger');
            $log->error('error', ['message' => $message]);
        }
    }
}
