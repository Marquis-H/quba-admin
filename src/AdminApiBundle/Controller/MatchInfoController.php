<?php


namespace AdminApiBundle\Controller;


use CommonBundle\Entity\MatchApplication;
use CommonBundle\Entity\MatchInfo;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use CommonBundle\Helpers\CommonTools;
use CommonBundle\Helpers\ExcelHelper;
use CommonBundle\Services\MatchInfoService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;

class MatchInfoController extends AbstractApiController
{
    /**
     * @Route("/list", name="admin.match_info.list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request)
    {
        $common = $this->container->get(CommonHelper::class);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:MatchInfo');

        $queryBuild = $repo->getQueryBuilder();
        $result = $common->filterPagination($request->query->get('filters'), $request->query->get('currentPage'), $request->query->get('perPage'), $queryBuild, MatchInfo::class);

        return $this->createSuccessJSONResponse('success', $result);
    }

    /**
     * @Route("/create", name="admin.match_info.create", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $data = $request->request->all();
        $validator = $this->get('validator');
        $collectionConstraint = new Collection([
            'title' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);

        if (count($errors) > 0) {
            return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
        } else {
            $matchInfoService = $this->get(MatchInfoService::class);
            try {
                $matchInfo = new MatchInfo();
                /** @var MatchInfo $matchInfo */
                $matchInfo = $matchInfoService->save($matchInfo, $data);

                $data['id'] = $matchInfo->getId();
                $data['createdAt'] = $matchInfo->getCreatedAt()->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return self::createFailureJSONResponse($e->getMessage());
            }
        }

        return self::createSuccessJSONResponse('success', $data);
    }

    /**
     * @Route("/{id}/update", name="admin.match_info.update", methods={"POST"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:MatchInfo');

        $data = $request->request->all();
        $validator = $this->get('validator');
        unset($data['createdAt']);

        $collectionConstraint = new Collection([
            'id' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);
        if (count($errors) > 0) {
            return self::createFailureJSONResponse(100, 'fail', $this->getErrors($errors));
        } else {
            $matchInfoService = $this->get(MatchInfoService::class);
            try {
                $matchInfo = $repo->find($id);
                if ($matchInfo === null) {
                    return $this->createFailureJSONResponse(-1, 'fail');
                }
                /** @var MatchInfo $matchCategory */
                $matchInfo = $matchInfoService->save($matchInfo, $data);

                $data['id'] = $matchInfo->getId();
                $data['createdAt'] = $matchInfo->getCreatedAt()->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return self::createFailureJSONResponse(-1, 'fail');
            }
        }

        return $this->createSuccessJSONResponse('success', $data);
    }

    /**
     * 删除
     * @Route("/{id}/delete", name="admin.match_info.delete", methods={"POST"})
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:MatchInfo');
        $matchInfo = $repo->findOneBy(['id' => $id]);
        if ($matchInfo === null) {
            return self::createFailureJSONResponse('fail');
        }

        try {
            $em->remove($matchInfo);
            $em->flush();
        } catch (\Exception $e) {
            $em->rollback();
        }

        return self::createSuccessJSONResponse('success', []);
    }

    /**
     * @Route("/change_top", name="admin.match_info.change_top", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ApiException
     */
    public function changeTop(Request $request)
    {
        $params = $request->request->all();
        CommonTools::checkParams($params, ['id', 'isTop']);

        $em = $this->getEntityManager();
        $matchInfo = $em->getRepository('CommonBundle:MatchInfo')->find($params['id']);
        if ($matchInfo == null) {
            return $this->createFailureJSONResponse(-1, '没有记录');
        }

        $matchInfo->setTopAt($params['isTop'] ? new \DateTime() : null);
        $em->persist($matchInfo);
        $em->flush();

        return $this->createSuccessJSONResponse('success');
    }

    /**
     * @Route("/export", name="admin.match_info.export", methods={"POST"})
     *
     * @param Request $request
     * @return string|JsonResponse
     * @throws ApiException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Request $request)
    {
        $params = $request->request->all();
        CommonTools::checkParams($params, ['id']);

        $em = $this->getEntityManager();
        $matchInfo = $em->getRepository('CommonBundle:MatchInfo')->find($params['id']);
        if ($matchInfo == null) {
            return $this->createFailureJSONResponse(-1, '没有记录');
        }
        $matchApplications = $em->getRepository('CommonBundle:MatchApplication')->findBy(['MatchInfo' => $params['id'], 'isSponsor' => true]);

        $cols = [
            '队伍' => ['ID', '队伍名称', '项目现状', '人数', '要求', '加入队伍截止时间'],
            '队员' => ['队伍ID', '队伍名称', '姓名', '性别', '学号', '学院', '专业', '手机号', '拥有技能', '比赛经验', '联系方式']
        ];
        $data = [
            '队伍' => [],
            '队员' => []
        ];
        foreach ($matchApplications as $matchApplication) {
            // 队伍
            array_push($data['队伍'], [
                'id' => $matchApplication->getId(),
                'title' => $matchApplication->getTeamName(),
                'status' => $matchApplication->getCurrentStatus(),
                'people' => $matchApplication->getPeople(),
                'kill' => $matchApplication->getSkill() ? $matchApplication->getSkill() : '-',
                'joinAt' => $matchApplication->getJoinEndAt()->format('Y-m-d')
            ]);
            $profile = $matchApplication->getProfile();
            array_push($data['队员'], [
                "id" => $matchApplication->getId(),
                'title' => $matchApplication->getTeamName(),
                'name' => $profile->getName(),
                'gender' => $profile->getGender() == 'M' ? '男' : '女',
                'sNo' => $profile->getSNo(),
                'college' => $profile->getCollege()->getTitle(),
                'professional' => $profile->getProfessional()->getTitle(),
                'mobile' => $profile->getMobile(),
                'kills' => $matchApplication->getSkills() ? $matchApplication->getSkills() : '-',
                'experience' => $matchApplication->getMatchExperience(),
                'contact' => $matchApplication->getContact()
            ]);
            /** @var MatchApplication $value */
            foreach ($matchApplication->getChildren()->getValues() as $value) {
                $cProfile = $value->getProfile();
                array_push($data['队员'], [
                    "id" => $matchApplication->getId(),
                    'title' => $matchApplication->getTeamName(),
                    'name' => $cProfile->getName(),
                    'gender' => $cProfile->getGender() == 'M' ? '男' : '女',
                    'sNo' => $cProfile->getSNo(),
                    'college' => $cProfile->getCollege()->getTitle(),
                    'professional' => $cProfile->getProfessional()->getTitle(),
                    'mobile' => $cProfile->getMobile(),
                    'kills' => $value->getSkills() ? $value->getSkills() : '-',
                    'experience' => $value->getMatchExperience() ? $value->getMatchExperience() : '-',
                    'contact' => $value->getContact() ? $value->getContact() : '-'
                ]);
            }
        }

        $excelHelper = new ExcelHelper();

        return self::createSuccessJSONResponse('success', [
            'url' => $this->getParameter('api_domain') . '/' . $excelHelper->exportMatchApplication($cols, $data, $matchInfo->getTitle() . "人员表")
        ]);
    }
}
