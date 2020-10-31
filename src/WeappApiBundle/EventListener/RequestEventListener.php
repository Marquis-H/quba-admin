<?php
/**
 * RequestEventListener.php
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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Util\Json;

/**
 * Class RequestEventListener
 * @package WeappApiBundle\EventListener
 */
class RequestEventListener
{
    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        $request = $event->getRequest();
        if (in_array($request->getMethod(), [Request::METHOD_POST, Request::METHOD_PUT])) {
            if (strpos($request->headers->get('Content-Type'), 'application/json') === 0) {
                $data = Json::decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : []);
            }
        }
    }
}
