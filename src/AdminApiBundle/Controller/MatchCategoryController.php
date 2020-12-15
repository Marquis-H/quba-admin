<?php


namespace AdminApiBundle\Controller;


use CommonBundle\Entity\MatchCategory;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use CommonBundle\Services\MatchCategoryService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * Class MatchCategoryController
 * @package AdminApiBundle\Controller
 */
class MatchCategoryController extends AbstractApiController
{
    /**
     * @Route("/items", name="admin.match_category.items", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function items(Request $request)
    {
        $repo = $this->getEntityManager()->getRepository('CommonBundle:MatchCategory');
        $matchCategorys = $repo->findAll();

        $matchCategoryDatas = [];
        /** @var MatchCategory $matchCategory */
        foreach ($matchCategorys as $matchCategory) {
            $matchCategoryDatas[$matchCategory->getIsOnline()][$matchCategory->getType()][] = [
                'text' => $matchCategory->getTitle(),
                'value' => $matchCategory->getId()
            ];
        }

        return self::createSuccessJSONResponse('success', $matchCategoryDatas);
    }

    /**
     * @Route("/list", name="admin.match_category.list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request)
    {
        $common = $this->container->get(CommonHelper::class);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:MatchCategory');

        $queryBuild = $repo->getQueryBuilder();
        $result = $common->filterPagination($request->query->get('filters'), $request->query->get('currentPage'), $request->query->get('perPage'), $queryBuild, MatchCategory::class);

        return $this->createSuccessJSONResponse('success', $result);
    }

    /**
     * @Route("/create", name="admin.match_category.create", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $data = $request->request->all();
        $validator = $this->get('validator');
        $collectionConstraint = new Collection([
            'title' => [],
            'type' => [],
            'isOnline' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);

        if (count($errors) > 0) {
            return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
        } else {
            $matchCategoryService = $this->get(MatchCategoryService::class);
            try {
                $matchCategory = new MatchCategory();
                /** @var MatchCategory $matchCategory */
                $matchCategory = $matchCategoryService->save($matchCategory, $data);

                $data['id'] = $matchCategory->getId();
                $data['createdAt'] = $matchCategory->getCreatedAt()->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return self::createFailureJSONResponse('fail');
            }
        }

        return self::createSuccessJSONResponse('success', $data);
    }

    /**
     * @Route("/{id}/update", name="admin.match_category.update", methods={"POST"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:MatchCategory');

        $data = $request->request->all();
        $validator = $this->get('validator');
        unset($data['createdAt']);

        $collectionConstraint = new Collection([
            'id' => [],
            'title' => [],
            'type' => [],
            'isOnline' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);
        if (count($errors) > 0) {
            return self::createFailureJSONResponse(100, 'fail', $this->getErrors($errors));
        } else {
            $matchCategoryService = $this->get(MatchCategoryService::class);
            try {
                $matchCategory = $repo->find($id);
                if ($matchCategory === null) {
                    return $this->createFailureJSONResponse(-1, 'fail');
                }
                /** @var MatchCategory $matchCategory */
                $matchCategory = $matchCategoryService->save($matchCategory, $data);

                $data['id'] = $matchCategory->getId();
                $data['createdAt'] = $matchCategory->getCreatedAt()->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return self::createFailureJSONResponse(-1, 'fail');
            }
        }

        return $this->createSuccessJSONResponse('success', $data);
    }

    /**
     * 标签删除
     * @Route("/{id}/delete", name="admin.match_category.delete", methods={"POST"})
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:MatchCategory');
        $matchCategory = $repo->findOneBy(['id' => $id]);
        if ($matchCategory === null) {
            return self::createFailureJSONResponse('fail');
        }

        try {
            $em->remove($matchCategory);
            $em->flush();
        } catch (\Exception $e) {
            $em->rollback();
        }

        return self::createSuccessJSONResponse('success', []);
    }
}
