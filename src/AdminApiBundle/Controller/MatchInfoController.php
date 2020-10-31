<?php


namespace AdminApiBundle\Controller;


use CommonBundle\Entity\MatchInfo;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use CommonBundle\Services\MatchInfoService;
use Doctrine\ORM\EntityManager;
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
        $result = $common->filterPagination($request->query->get('filters'), 1, 10, $queryBuild, MatchInfo::class);

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
}
