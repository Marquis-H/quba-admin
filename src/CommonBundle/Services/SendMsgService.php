<?php
/**
 * Created by PhpStorm.
 * User: dxw
 * Date: 2020/1/21
 * Time: 11:08 AM
 */

namespace CommonBundle\Services;

use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonRedis;
use CommonBundle\Helpers\CommonTools;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SendMsgService
 * @package CommonBundle\Services
 */
class SendMsgService
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * SendMsgService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $message
     * @param int $chat_id
     */
    public function sendTelegramMsg($message, $chat_id = 0)
    {
        $client = new Client();
        $client->post('https://integram.org/webhook/coZgZKHEHyV', ['json' => ['text' => $message]]);
    }

    /**
     * @param $mobile
     * @param $locale
     * @param $number
     * @throws ApiException
     */
    public function sendCaptchaSMS($mobile, $number)
    {
        $captchaKey = '__mobile_captcha:' . $mobile;
        $redis = $this->container->get(CommonRedis::class)->getRedis();
        if (!$redis->exists($captchaKey)) {
            $captcha = CommonTools::genCaptcha();
            $this->sendSMSMessage($mobile, strip_tags("短信编号：{$number}，验证码：{$captcha}"));
            $redis->set($captchaKey, $captcha, 50);
        }
    }

    /**
     * 发送SMS 澳门/中国，号码带上区号
     *
     * @param $mobile
     * @param $message
     */
    public function sendSMSMessage($mobile, $message)
    {
        if ($this->container->getParameter('is_dev_mode')) {
            $this->sendTelegramMsg($message, 0); //-328290346
        }
    }

    /**
     * @param $mobile
     * @return bool|string
     */
    public function getCaptchaCode($mobile)
    {
        $captchaKey = '__mobile_captcha:' . $mobile;
        $redis = $this->container->get(CommonRedis::class)->getRedis();
        return $redis->get($captchaKey);
    }
}
