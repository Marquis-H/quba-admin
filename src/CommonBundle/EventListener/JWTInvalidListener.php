<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2018/6/4
 * Time: 下午3:09
 */

namespace CommonBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;

class JWTInvalidListener
{
    use ContainerAwareTrait;

    /**
     * @param JWTNotFoundEvent $event
     */
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $res = new JsonResponse(['code' => 403, 'message' => '没有权限访问，请稍后再试'], 403);
        $event->setResponse($res);
    }

    /**
     * @param JWTExpiredEvent $event
     */
    public function onJWTExpired(JWTExpiredEvent $event)
    {
        $res = new JsonResponse(['code' => 401, 'message' => '已失效，正在重新登录'], 401);
        $event->setResponse($res);
    }

}
