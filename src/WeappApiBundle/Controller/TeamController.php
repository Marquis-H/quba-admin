<?php


namespace WeappApiBundle\Controller;


use CommonBundle\Entity\MatchApplication;
use CommonBundle\Entity\MatchInfo;
use CommonBundle\Entity\WeappUser;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonTools;
use CommonBundle\Services\CommonService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use WeappApiBundle\Constants\ApiCode;
use WeappApiBundle\Exceptions\WeappApiException;

class TeamController extends AbstractApiController
{
    /**
     * 队伍列表
     * @Route("/list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request)
    {
        $commonService = $this->container->get(CommonService::class);

        $params = $request->query->all();
        CommonTools::checkParams($params, ['id']);
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $matchAppcation = $em->getRepository('CommonBundle:MatchApplication')->findBy(['MatchInfo' => $params['id'], 'isSponsor' => true]);

        return self::createSuccessJSONResponse('success', $commonService->toDataModel($matchAppcation));
    }

    /**
     * 队伍详情
     * @Route("/detail", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws WeappApiException
     */
    public function detail(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        if (!$profile) {
            throw new WeappApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }

        $params = $request->query->all();
        CommonTools::checkParams($params, ['id']);
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $matchAppcation = $em->getRepository('CommonBundle:MatchApplication')->findOneBy(['id' => $params['id']]);

        if ($matchAppcation == null) {
            throw new ApiException('记录不存在', ApiCode::DATA_NOT_FOUND);
        }
        $commonService = $this->container->get(CommonService::class);
        return self::createSuccessJSONResponse('success', $commonService->toDataModel($matchAppcation));
    }

    /**
     * 创建或加入队伍
     * @Route("/create", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws WeappApiException
     */
    public function create(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        if (!$profile) {
            throw new WeappApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }

        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $params = $request->request->all();
        CommonTools::checkParams($params, ['currentStatus', 'skill', 'experience', 'people', 'mid']);
        /** @var MatchInfo $matchInfo */
        $matchInfo = $em->getRepository('CommonBundle:MatchInfo')->findOneBy(['id' => $params['mid']]);
        if ($matchInfo == null) {
            throw new ApiException('记录不存在', ApiCode::DATA_NOT_FOUND);
        }

        try {
            $matchApplication = new MatchApplication();
            $matchApplication->setCurrentStatus($params['currentStatus']);
            $matchApplication->setSkill($params['skill']);
            $matchApplication->setExperience($params['experience']);
            $matchApplication->setPeople($params['people']);
            $matchApplication->setJoinEndAt(new \DateTime($params['joinEndAt']));
            $matchApplication->setIsSponsor(true);
            $matchApplication->setTotalPeople(1);
            $matchApplication->setProfile($profile);
            $matchApplication->setMatchInfo($matchInfo);
            $em->persist($matchApplication);
            $em->flush();
        } catch (\Exception $e) {
            return self::createFailureJSONResponse(-1, $e->getMessage());
        }

        return self::createSuccessJSONResponse('success');
    }

    /**
     * 加入队伍
     * @Route("/add", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws WeappApiException
     */
    public function addTeam(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        if (!$profile) {
            throw new WeappApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }

        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $params = $request->request->all();
        CommonTools::checkParams($params, ['skills', 'matchExperience', 'contact', 'aid']);
        /** @var MatchApplication $matchApplication */
        $matchApplication = $em->getRepository('CommonBundle:MatchApplication')->findOneBy(['id' => $params['aid']]);
        if ($matchApplication == null) {
            throw new ApiException('记录不存在', ApiCode::DATA_NOT_FOUND);
        }

        try {
            $newMatchApplication = new MatchApplication();
            $newMatchApplication->setSkills($params['skills']);
            $newMatchApplication->setMatchExperience($params['matchExperience']);
            $newMatchApplication->setContact($params['contact']);
            $newMatchApplication->setIsSponsor(false);
            $newMatchApplication->setProfile($profile);
            $newMatchApplication->setMatchInfo($matchApplication->getMatchInfo());
            $newMatchApplication->setParent($matchApplication);
            $matchApplication->setTotalPeople($matchApplication->getTotalPeople() + 1);

            $em->persist($matchApplication);
            $em->persist($newMatchApplication);
            $em->flush();
        } catch (\Exception $e) {
            return self::createFailureJSONResponse(-1, $e->getMessage());
        }

        return self::createSuccessJSONResponse('success');
    }
}
