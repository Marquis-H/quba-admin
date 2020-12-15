<?php


namespace CommonBundle\Services;


use EasyWeChat\Factory;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\MiniProgram\Application;
use \GuzzleHttp\Exception\GuzzleException;

class WechatService
{
    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $logFile;

    /**
     * WechatService constructor.
     * @param string $appId
     * @param string $secret
     * @param string $logFile
     */
    public function __construct(string $appId, string $secret, string $logFile)
    {
        $this->appId = $appId;
        $this->secret = $secret;
        $this->logFile = $logFile;
    }

    /**
     * 获取小程序接口对象
     *
     * @return Application
     */
    public function getApplication()
    {
        $config = [
            'app_id' => $this->appId,
            'secret' => $this->secret,
            'log' => [
                'level' => 'debug',
                'file' => $this->logFile,
            ],
            'response_type' => 'array',
        ];
        return Factory::miniProgram($config);
    }
}
