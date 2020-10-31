<?php
/**
 * ExceptionListener.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author      Nicky <lib.work@qq.com>
 * @copyright   @2020 WIZ TECHNOLOGY
 * @date        <2020-06-07>
 * @link        http://wizmacau.com
 * @link        http://raoliping.cn
 */

namespace WeappApiBundle\EventListener;

use WeappApiBundle\Constants\ApiCode;
use WeappApiBundle\Exceptions\WeappApiException;
use CommonBundle\Services\CommonService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class ExceptionListener
 * @package WeappApiBundle\EventListener
 */
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
        $common = $this->container->get(CommonService::class);
        if ($exception instanceof WeappApiException) {
            $domainAllow = $this->container->getParameter('api_domain_allow');
            if (is_array($domainAllow)) {
                $origin = $event->getRequest()->headers->get('Origin');
                $domainAllow = in_array($origin, $domainAllow) ? $origin : $event->getRequest()->getHost();
            }
            $message = $this->container->get('translator')->trans($message);
            if ($exception->getCode() == ApiCode::SERVER_ERROR) {
                $common->sendTelegramMsg("ERROR: " . $event->getRequest()->attributes->get('_route') . ":\n" . $message);
                $message = '系統繁忙，請稍後再試！';
            }
            $response = new JsonResponse(['code' => $exception->getCode(), 'message' => $message], Response::HTTP_OK, [
                'Access-Control-Allow-Origin' => $domainAllow,
                'Access-Control-Allow-Headers' => 'Content-Type',
                'Access-Control-Allow-Methods' => 'GET,HEAD,OPTIONS,POST,PUT'
            ]);
            $event->allowCustomResponseCode();
            $event->setResponse($response);
        } else if (!$exception instanceof \RuntimeException) {
            $common->sendTelegramMsg("ERROR: " . $event->getRequest()->attributes->get('_route') . ":\n" . $message);
        }
    }
}
