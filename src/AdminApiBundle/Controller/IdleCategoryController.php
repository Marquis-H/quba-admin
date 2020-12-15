<?php


namespace AdminApiBundle\Controller;


use CommonBundle\Entity\IdleCategory;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use CommonBundle\Services\IdleCategoryService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;

class IdleCategoryController extends AbstractApiController
{
    /**
     * @Route("/items", name="admin.idle_category.items", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function items(Request $request)
    {
        $repo = $this->getEntityManager()->getRepository('CommonBundle:IdleCategory');
        $idleCategorys = $repo->findAll();

        $idleCategoryDatas = [];
        /** @var IdleCategory $idleCategory */
        foreach ($idleCategorys as $idleCategory) {
            array_push($idleCategoryDatas, [
                'text' => $idleCategory->getTitle(),
                'value' => $idleCategory->getId()
            ]);
        }

        return self::createSuccessJSONResponse('success', $idleCategoryDatas);
    }

    /**
     * @Route("/list", name="admin.idle_category.list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request)
    {
        $common = $this->container->get(CommonHelper::class);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:IdleCategory');

        $queryBuild = $repo->getQueryBuilder();
        $result = $common->filterPagination($request->query->get('filters'), $request->query->get('currentPage'), $request->query->get('perPage'), $queryBuild, IdleCategory::class);

        return $this->createSuccessJSONResponse('success', $result);
    }

    /**
     * @Route("/create", name="admin.idle_category.create", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:IdleCategory');
        $data = $request->request->all();
        $validator = $this->get('validator');
        $collectionConstraint = new Collection([
            'title' => [],
            'description' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);

        if ($repo->findOneBy(['title' => $data['title']])) {
            return self::createFailureJSONResponse('fail', '名称已存在', []);
        } else if (count($errors) > 0) {
            return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
        } else {
            $idleCategoryService = $this->get(IdleCategoryService::class);
            try {
                $idleCategory = new IdleCategory();
                /** @var IdleCategory $idleCategory */
                $idleCategory = $idleCategoryService->save($idleCategory, $data);

                $data['id'] = $idleCategory->getId();
                $data['createdAt'] = $idleCategory->getCreatedAt()->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return self::createFailureJSONResponse('fail');
            }
        }

        return self::createSuccessJSONResponse('success', $data);
    }

    /**
     * @Route("/{id}/update", name="admin.idle_category.update", methods={"POST"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:IdleCategory');

        $data = $request->request->all();
        $validator = $this->get('validator');
        unset($data['createdAt']);

        $collectionConstraint = new Collection([
            'id' => [],
            'title' => [],
            'description' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);
        $isUnique = $repo->isUnique($data['title'], $id);
        if ($isUnique > 0) {
            return self::createFailureJSONResponse('fail', "数据已存在", []);
        } else if (count($errors) > 0) {
            return self::createFailureJSONResponse(100, 'fail', $this->getErrors($errors));
        } else {
            $idleCategoryService = $this->get(IdleCategoryService::class);
            try {
                $idleCategory = $repo->find($id);
                if ($idleCategory === null) {
                    return $this->createFailureJSONResponse(-1, 'fail');
                }
                /** @var IdleCategory $idleCategory */
                $idleCategory = $idleCategoryService->save($idleCategory, $data);

                $data['id'] = $idleCategory->getId();
                $data['createdAt'] = $idleCategory->getCreatedAt()->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return self::createFailureJSONResponse(-1, 'fail');
            }
        }

        return $this->createSuccessJSONResponse('success', $data);
    }

    /**
     * 标签删除
     * @Route("/{id}/delete", name="admin.idle_category.delete", methods={"POST"})
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:IdleCategory');
        $idleCategory = $repo->findOneBy(['id' => $id]);
        if ($idleCategory === null) {
            return self::createFailureJSONResponse('fail');
        }

        try {
            $em->remove($idleCategory);
            $em->flush();
        } catch (\Exception $e) {
            $em->rollback();
        }

        return self::createSuccessJSONResponse('success', []);
    }
}
