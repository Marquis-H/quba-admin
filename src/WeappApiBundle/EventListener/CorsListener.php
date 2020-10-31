<?php
/**
 * CorsListener.php
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

use WeappApiBundle\Constants\Common;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class CorsListener
 * @package WeappApiBundle\EventListener
 */
class CorsListener
{
    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }
        $request = $event->getRequest();
        if ('OPTIONS' === $request->getMethod() && $request->headers->has('Access-Control-Request-Method')) {
            $response = new Response();
            $response->setVary(array('Origin'));
            if (true) {
                $headers = ['Content-Type', 'Authorization', 'x-file-name', 'x-File-Size'];
                array_push($headers, Common::API_KEY);
                $response->headers->set('Access-Control-Allow-Credentials', 'true');
                $response->headers->set('Access-Control-Allow-Methods', 'GET,HEAD,OPTIONS,POST,PUT');
                $response->headers->set('Access-Control-Allow-Headers', implode(',', $headers));
            }
            $response->headers->set('Access-Control-Allow-Origin', $request->headers->get('Origin'));
            $event->setResponse($response);
            return;
        }
    }
}
