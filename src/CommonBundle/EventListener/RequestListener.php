<?php
/**
 * RequestListener.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    jack <jack@wizmacau.com>
 * @copyright 2007-2018/1/16 WIZ TECHNOLOGY
 * @link      https://wizmacau.com
 * @link      https://lamjack.github.io
 * @link      https://github.com/lamjack
 * @version
 */

namespace CommonBundle\EventListener;

use CommonBundle\Helpers\CommonHelper;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Translation\TranslatorInterface;
use Util\Json;

/**
 * Class RequestListener
 * @package App\EventListener
 */
class RequestListener
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * LocaleEventLister constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        if ($request->isMethod('post') && 0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = Json::decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : []);
        }
    }
}
