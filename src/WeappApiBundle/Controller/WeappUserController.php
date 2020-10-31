<?php


namespace WeappApiBundle\Controller;

use CommonBundle\Entity\WeappUser;
use CommonBundle\Entity\WeappUserProfile;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use CommonBundle\Helpers\CommonTools;
use CommonBundle\Services\CommonService;
use CommonBundle\Services\SendMsgService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;
use WeappApiBundle\Constants\ApiCode;
use WeappApiBundle\Exceptions\WeappApiException;

/**
 * Class WeappUserController
 * @package WeappApiBundle\Controller
 */
class WeappUserController extends AbstractApiController
{
    /**
     * @Route("/profile", name="weapp.weapp_user.profile", methods={"GET", "POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws WeappApiException
     * @throws ApiException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function profile(Request $request)
    {
        $common = $this->container->get(CommonService::class);
        $accessor = PropertyAccess::createPropertyAccessor();
        /** @var WeappUser $user */
        $user = $this->getUser();
<<<<<<< HEAD
=======
        /** @var WeappUserProfile $profile */
>>>>>>> 9322d1f3deb79714a7d9c05aa4e611a75f6b7637
        $profile = $user->getWeappUserProfile();
        if ($request->isMethod('POST')) {
            $em = $this->getEntityManager();
            $params = $request->request->all();
            if (!$profile) {
                CommonTools::checkParams($params, ['mobile', 'captcha']);
                $profile = new WeappUserProfile();
                $user->setWeappUserProfile($profile);
            }
            // 验证验证码
            if (isset($params['mobile'])) {
                $captcha = $this->container->get(SendMsgService::class)->getCaptchaCode($params['mobile']);
                if ($params['captcha'] !== '999888') {
                    if (!$captcha)
                        throw new WeappApiException('驗證碼已失效，請重新發送。', ApiCode::DATA_INVALID);
                    if ($captcha !== $params['captcha'])
                        throw new WeappApiException('驗證碼錯誤', ApiCode::DATA_INVALID);
                }
            }
            $profile->setName($accessor->getValue($params, '[name]'));
            $college = $em->getRepository('CommonBundle:College')->find($accessor->getValue($params, '[college]'));
            $profile->setCollege($college);
            $profile->setMobile($accessor->getValue($params, '[mobile]'));
            $profile->setGender($accessor->getValue($params, '[gender]'));
            $professional = $em->getRepository('CommonBundle:Professional')->find($accessor->getValue($params, '[professional]'));
            $profile->setProfessional($professional);
            $profile->setSNo($accessor->getValue($params, '[sNo]'));
            $em->persist($user);
            $em->persist($profile);
            $em->flush();
        }

        $memberExpand = $common->toDataModel($user);
        $profile = $common->toDataModel($profile);

        $orders = 0;
        $applications = 0;
        $teams = 0;
        $response = array_merge($memberExpand, $profile, [
            'orders' => $orders,
            'applications' => $applications,
            'teams' => $teams
        ]);

        return self::createSuccessJSONResponse('success', $response);
    }
}
