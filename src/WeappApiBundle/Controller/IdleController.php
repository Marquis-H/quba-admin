<?php


namespace WeappApiBundle\Controller;

use CommonBundle\Constants\IdleStatus;
use CommonBundle\Constants\TradeStatus;
use CommonBundle\Entity\IdleApplication;
use CommonBundle\Entity\IdleProfile;
use CommonBundle\Entity\WeappUser;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonTools;
use CommonBundle\Services\CommonService;
use CommonBundle\Services\IdleApplicationService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;
use WeappApiBundle\Constants\ApiCode;

class IdleController extends AbstractApiController
{
    /**
     * 分類
     * @Route("/category", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function idleCategory(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        if (!$profile) {
            throw new ApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }

        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $idleCategory = $em->getRepository('CommonBundle:IdleCategory')->findAll();
        $commonService = $this->container->get(CommonService::class);

        return self::createSuccessJSONResponse('success', $commonService->toDataModel($idleCategory));
    }

    /**
     * 列表
     * @Route("/list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function idleList(Request $request)
    {
        $params = $request->query->all();
        CommonTools::checkParams($params, ['cId']); // 類別ID
        $commonService = $this->container->get(CommonService::class);

        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $idleApplications = $em->getRepository('CommonBundle:IdleApplication')->findByCategory($params['cId']);

        return self::createSuccessJSONResponse('success', $commonService->toDataModel($idleApplications));
    }

    /**
     * 詳情
     *
     * @Route("/detail", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function idleDetail(Request $request)
    {
        $params = $request->query->all();
        CommonTools::checkParams($params, ['id']); // Application ID
        $commonService = $this->container->get(CommonService::class);

        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $idleApplication = $em->getRepository("CommonBundle:IdleApplication")->find($params['id']);
        return self::createSuccessJSONResponse('success', $commonService->toDataModel($idleApplication));
    }

    /**
     * 创建
     * @Route("/create", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function create(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        if (!$profile) {
            throw new ApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }
        $params = $request->request->all();
        $accessor = PropertyAccess::createPropertyAccessor();
        CommonTools::checkParams($params, ['name', 'category', 'number', 'oldDeep', 'originalCost', 'currentCost', 'contactType', 'contact', 'description']);

        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        $category = $em->getRepository('CommonBundle:IdleCategory');
        $idle = new IdleApplication();
        try {
            $idle->setStatus(IdleStatus::ONLINE);
            $idle->setTitle($params['name']);
            $idle->setIdleCategory($category->find($params['category']));
            $idle->setNumber($params['number']);
            $idle->setOldDeep($params['oldDeep']);
            $idle->setOriginalCost($params['originalCost']);
            $idle->setCurrentCost($params['currentCost']);
            $idle->setOriginalUrl($accessor->getValue($params, '[originalUrl]'));
            $idle->setRemark($accessor->getValue($params, '[remark]'));
            $idle->setContactType($params['contactType']);
            $idle->setContact($params['contact']);
            $idle->setDescription($params['description']);
            $idle->setFamousPhoto($accessor->getValue($params, '[famousPhoto][0][file]'));
            $idle->setPhotos($accessor->getValue($params, '[photos]'));
            $idle->setProfile($profile);

            $em->persist($idle);
            $em->flush();

            return $this->createSuccessJSONResponse('success');
        } catch (\Exception $e) {
            return $this->createFailureJSONResponse(-1, $e->getMessage());
        }
    }

    /**
     * 订单
     * @Route("/trade", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function trade(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        if (!$profile) {
            throw new ApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }

        $params = $request->query->all();
        CommonTools::checkParams($params, ['id']);

        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        $idleProfile = $em->getRepository('CommonBundle:IdleProfile')->findOneBy(['id' => $params['id'], 'Profile' => $profile]);
        if ($idleProfile == null) {
            throw new ApiException('记录不存在', ApiCode::DATA_NOT_FOUND);
        }

        $commonService = $this->container->get(CommonService::class);
        return self::createSuccessJSONResponse('success', $commonService->toDataModel($idleProfile));
    }

    /**
     * 加入订单
     * @Route("/add_trade", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function addTrade(Request $request)
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
        $em = $this->get('doctrine.orm.default_entity_manager');
        $idleApplication = $em->getRepository('CommonBundle:IdleApplication')->findOneBy(['id' => $params['id'], 'status' => IdleStatus::ONLINE]);
        if ($idleApplication == null) {
            throw new ApiException('记录不存在', ApiCode::DATA_NOT_FOUND);
        }

        try {
            $idleApplicationService = $this->get(IdleApplicationService::class);
            $idleProfile = new IdleProfile();
            $idleProfile->setStatus(TradeStatus::Doing);
            $idleProfile->setProfile($profile);
            $idleProfile->setIdleApplication($idleApplication);
            $idleProfile->setTradeAt(new \DateTime());
            $idleProfile->setReceipt($idleApplicationService->buildOrderReceiptNumber($idleApplication->getId()));
            $idleApplication->setStatus(IdleStatus::Doing);

            $em->persist($idleApplication);
            $em->persist($idleProfile);
            $em->flush();
        } catch (\Exception $e) {
            return $this->createFailureJSONResponse(-1, $e->getMessage());
        }

        return $this->createSuccessJSONResponse('success', ['id' => $idleProfile->getId()]);
    }

    /**
     * 更改订单
     * @Route("/change_trade", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function changeTrade(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        if (!$profile) {
            throw new ApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }

        $params = $request->request->all();
        CommonTools::checkParams($params, ['id', 'status']);

        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        $idleProfile = $em->getRepository('CommonBundle:IdleProfile')->findOneBy(['id' => $params['id'], 'Profile' => $profile]);
        if ($idleProfile == null) {
            throw new ApiException('记录不存在', ApiCode::DATA_NOT_FOUND);
        }

        try {
            $idleProfile->setStatus($params['status']);
            /** @var IdleApplication $idleApplication */
            $idleApplication = $idleProfile->getIdleApplication();
            if ($idleApplication->getStatus() == IdleStatus::Doing) {
                switch ($params['status']) {
                    case TradeStatus::Done:
                        $idleApplication->setStatus(IdleStatus::OFFLINE);
                        break;
                    case TradeStatus::Cancel:
                        $idleApplication->setStatus(IdleStatus::ONLINE);
                        break;
                }
            }
            $idleProfile->setTradeEndAt(new \DateTime());
            $em->persist($idleProfile);
            $em->persist($idleApplication);
            $em->flush();
        } catch (\Exception $e) {
            return $this->createFailureJSONResponse(-1, $e->getMessage());
        }

        $commonService = $this->container->get(CommonService::class);
        return $this->createSuccessJSONResponse('success', $commonService->toDataModel($idleProfile));
    }

    /**
     * 更改二手交易
     * @Route("/change_idle_application", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function changeIdleApplication(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        if (!$profile) {
            throw new ApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }

        $params = $request->request->all();
        CommonTools::checkParams($params, ['id', 'status']);

        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        $idleApplication = $em->getRepository('CommonBundle:IdleApplication')->findOneBy(['id' => $params['id'], 'Profile' => $profile]);
        if ($idleApplication == null) {
            throw new ApiException('记录不存在', ApiCode::DATA_NOT_FOUND);
        }

        try {
            $idleApplication->setStatus($params['status']);
            $em->persist($idleApplication);
            $em->flush();
        } catch (\Exception $e) {
            return $this->createFailureJSONResponse(-1, $e->getMessage());
        }

        return $this->createSuccessJSONResponse('success');
    }
}
