<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/3
 * Time: 2:38 PM
 */

namespace CommonBundle\Services;


use GuzzleHttp\Client;
use Util\Json;

/**
 * Class SMSService
 * @package CommonBundle\Services
 */
class SMSService
{
	const BASE_URL = 'https://api.mysubmail.com';

	/**
	 * @var string
	 */
	private $appid;

	/**
	 * @var string
	 */
	private $appkey;

	/**
	 * @var Client
	 */
	private $client;

	/**
	 * SMSService constructor.
	 * @param $appid
	 * @param $appkey
	 */
	public function __construct($appid, $appkey)
	{
		$this->appid = $appid;
		$this->appkey = $appkey;
		$this->client = new Client(['base_uri' => self::BASE_URL]);
	}

	/**
	 * 发送短信
	 *
	 * @param string $to
	 * @param string $project
	 * @param array $vars
	 *
	 * @return array
	 */
	public function sendMessage(string $to, string $project = "2MH8N4", array $vars = [])
	{
		$postData = [
			'appid' => $this->appid,
			'to' => $to,
			'project' => $project,
			'signature' => $this->appkey
		];
		if (count($vars) > 0) {
			$postData['vars'] = Json::encode($vars);
		}
		$reps = $this->client->post('/message/xsend.json', ['json' => $postData]);
		return Json::decode($reps->getBody()->getContents(), true);
	}
}
