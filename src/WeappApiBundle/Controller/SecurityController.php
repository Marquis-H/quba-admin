<?php
/**
 * Created by PhpStorm.
 * User: dxw
 * Date: 2020/1/20
 * Time: 5:07 PM
 */

namespace WeappApiBundle\Controller;

use CommonBundle\Constants\ApiCode;
use CommonBundle\Entity\WeappUser;
use CommonBundle\Helpers\CommonTools;
use CommonBundle\Services\SendMsgService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Network\Curl;
use Symfony\Component\PropertyAccess\PropertyAccess;
use CommonBundle\Exception\ApiException;
use Symfony\Component\Routing\Annotation\Route;
use Util\Json;
use WeappApiBundle\Annotation\Anonymous;
use WeappApiBundle\Security\ApiKeyUserProvider;

/**
 * Class SecurityController
 * @package WeappApiBundle\Controller
 * @Anonymous()
 */
class SecurityController extends AbstractApiController
{
    /**
     * 獲取openid
     *
     * @Route("/openid", name="api.security.openid", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function getOpenId(Request $request)
    {
        $params = $request->request->all();
        CommonTools::checkParams($params, ['code']);
        $curl = new Curl();
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $config = [
            'app_id' => $this->container->getParameter('app_id'),
            'secret' => $this->container->getParameter('app_secret'),
            // (以下为可选项参数)指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
        ];
        $url = sprintf("https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code", $config['app_id'], $config['secret'], $params['code']);
        $responseContent = $curl->get($url);
        $result = Json::decode($responseContent['data'], true);
        if ($result && $propertyAccessor->getValue($result, '[openid]') !== null) {
            $openid = $propertyAccessor->getValue($result, '[openid]');
            $response = [
                'openid' => $openid
            ];
        } else {
            throw new ApiException('code_invalid', ApiCode::DATA_INVALID);
        }

        return self::createSuccessJSONResponse('success', $response);
    }

    /**
     * 注册绑定用户
     * @Route("/bind", name="api.security.bind", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function bind(Request $request)
    {
        $params = $request->request->all();
        $accessor = PropertyAccess::createPropertyAccessor();
        CommonTools::checkParams($params, ['openid']);
        $em = $this->getEntityManager();
        $weappUser = $em->getRepository('CommonBundle:WeappUser')->findOneBy(['openID' => $params['openid']]);
        if ($weappUser) {
            throw new ApiException('user_already_exists', ApiCode::DATA_EXIST);
        }
        $weappUser = new WeappUser();
        $weappUser->setNickname($accessor->getValue($params, '[nickname]'));
        $weappUser->setAvatar($accessor->getValue($params, '[avatar]'));
        $weappUser->setOpenId($accessor->getValue($params, '[openid]'));
        $em->persist($weappUser);
        $em->flush();
        $token = $this->container->get(ApiKeyUserProvider::class)->createApiKey($weappUser);
        $response = [
            'openid' => $weappUser->getOpenId(),
            'token' => $token
        ];
        return self::createSuccessJSONResponse('success', $response);
    }


    /**
     * 获取并验证OPENID是否绑定
     *
     * @Route("/check", name="api.security.check", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function checkMember(Request $request)
    {
        $params = $request->request->all();
        CommonTools::checkParams($params, ['openid']);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:WeappUser');
        $weappUser = $repo->findOneBy(['openID' => $params['openid']]);
        if (!$weappUser) {
            throw new ApiException('login failed,openid not bind', ApiCode::DATA_NOT_FOUND);
        }
        $token = $this->container->get(ApiKeyUserProvider::class)->createApiKey($weappUser);
        $response = [
            'openid' => $weappUser->getOpenId(),
            'token' => $token
        ];
        return self::createSuccessJSONResponse('success', $response);
    }

    /**
     * 發送短信驗證碼
     *
     * @Route("/captcha", name="api.security.captcha", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function sendCaptcha(Request $request)
    {
        $params = Json::decode($request->getContent(), true);
        CommonTools::checkParams($params, ['mobile']);
        // 生成短信验证码
        $sendMsg = $this->container->get(SendMsgService::class);
        $number = CommonTools::genCaptcha(4);
        $sendMsg->sendCaptchaSMS($params['mobile'], $number);
        return $this->createSuccessJSONResponse('短信驗證碼已發送, 短信编号：' . $number);
    }
}
