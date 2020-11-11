<?php


namespace WeappApiBundle\Controller;

use CommonBundle\Constants\TradeStatus;
use CommonBundle\Entity\WeappUser;
use CommonBundle\Entity\WeappUserProfile;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use CommonBundle\Helpers\CommonTools;
use CommonBundle\Services\CommonService;
use CommonBundle\Services\SendMsgService;
use Doctrine\ORM\EntityManager;
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
        /** @var WeappUserProfile $profile */
        $profile = $user->getWeappUserProfile();
        $em = $this->getEntityManager();
        if ($request->isMethod('POST')) {
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

        $idleApplicationRepo = $em->getRepository('CommonBundle:IdleApplication');
        $teamRepo = $em->getRepository('CommonBundle:MatchApplication');
        $idleProfileRepo = $em->getRepository('CommonBundle:IdleProfile');
        $orders = count($idleProfileRepo->findOrders($profile));
        $applications = count($idleApplicationRepo->findBy(['WeappUserProfile' => $profile])); // 商品发布数
        $teams = count($teamRepo->findBy(['WeappUserProfile' => $profile])); // 组队数
        $response = array_merge($memberExpand, $profile, [
            'orders' => $orders,
            'applications' => $applications,
            'teams' => $teams
        ]);

        return self::createSuccessJSONResponse('success', $response);
    }

    /**
     * 表白墙发布记录
     * @Route("/publish/love", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function getLovePublish(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        if (!$profile) {
            throw new ApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }
        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        $common = $this->get(CommonService::class);
        $sayLoves = $em->getRepository('CommonBundle:SayLoveMessage')->findBy(['Profile' => $profile], ["createdAt" => 'desc']);

        return $this->createSuccessJSONResponse('success', $common->toDataModel($sayLoves));
    }

    /**
     * 二手闲置发布记录
     * @Route("/publish/idle_application", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function getIdleApplication(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();
        if (!$profile) {
            throw new ApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }

        $commonService = $this->container->get(CommonService::class);
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $idleApplications = $em->getRepository('CommonBundle:IdleApplication')->findBy(['Profile' => $profile], ['createdAt' => 'desc']);

        return self::createSuccessJSONResponse('success', $commonService->toDataModel($idleApplications));
    }

    /**
     * 我的交易
     * @Route("/trade/list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function getTrade(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();
        if (!$profile) {
            throw new ApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }
        $params = $request->query->all();
        CommonTools::checkParams($params, ['slug']);
        $commonService = $this->container->get(CommonService::class);
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $trades = $em->getRepository('CommonBundle:IdleProfile')->findByStatus($profile, $params['slug']);

        return self::createSuccessJSONResponse('success', $commonService->toDataModel($trades));
    }

    /**
     * 组队记录
     * @Route("/team/list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function getTeam(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();
        if (!$profile) {
            throw new ApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }

        $commonService = $this->container->get(CommonService::class);
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $teams = $em->getRepository('CommonBundle:MatchApplication')->findBy(['Profile' => $profile], ['createdAt' => 'desc']);

        return self::createSuccessJSONResponse('success', $commonService->toDataModel($teams));
    }

    /**
     * 移除队伍
     * @Route("/team/remove", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function removeTeam(Request $request)
    {
        $params = $request->request->all();
        CommonTools::checkParams($params, ['id']);
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $team = $em->getRepository('CommonBundle:MatchApplication')->find($params['id']);
        if ($team == null) {
            throw new ApiException('无数据', ApiCode::DATA_NOT_FOUND);
        }

        $em->remove($team);
        $em->flush();

        return self::createSuccessJSONResponse('success');
    }

    /**
     * 收藏列表
     * @Route("/mark/list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function getMark(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();
        if (!$profile) {
            throw new ApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }

        $params = $request->query->all();
        CommonTools::checkParams($params, ['slug']);
        $commonService = $this->container->get(CommonService::class);
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $mark = $em->getRepository('CommonBundle:Mark')->findBy(['WeappUserProfile' => $profile, 'slug' => $params['slug']], ['createdAt' => 'desc']);

        return $this->createSuccessJSONResponse('success', $commonService->toDataModel($mark));
    }

    /**
     * 移除Mark
     * @Route("/mark/remove", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function removeMark(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();
        if (!$profile) {
            throw new ApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }

        $params = $request->request->all();
        CommonTools::checkParams($params, ['id']);
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $mark = $em->getRepository('CommonBundle:Mark')->findOneBy(['id' => $params['id'], 'WeappUserProfile' => $profile]);
        if ($mark == null) {
            throw new ApiException('无数据', ApiCode::DATA_NOT_FOUND);
        }

        $em->remove($mark);
        $em->flush();

        return self::createSuccessJSONResponse('success');
    }
}
