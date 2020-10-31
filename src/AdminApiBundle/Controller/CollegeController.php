<?php


namespace AdminApiBundle\Controller;

use CommonBundle\Entity\College;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use CommonBundle\Services\CollegeService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;

class CollegeController extends AbstractApiController
{
    /**
     * @Route("/items", name="admin.college.items", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function items(Request $request)
    {
        $repo = $this->getEntityManager()->getRepository('CommonBundle:College');
        $colleges = $repo->findAll();

        $collegeDatas = [
            [
                'text' => "请选择学院",
                'value' => null
            ]
        ];
        /** @var College $college */
        foreach ($colleges as $college) {
            array_push($collegeDatas, [
                'text' => $college->getTitle(),
                'value' => $college->getId()
            ]);
        }

        return self::createSuccessJSONResponse('success', $collegeDatas);
    }

    /**
     * @Route("/list", name="admin.college.list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request)
    {
        $common = $this->container->get(CommonHelper::class);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:College');

        $queryBuild = $repo->getQueryBuilder();
        $result = $common->filterPagination($request->query->get('filters'), 1, 10, $queryBuild, College::class);

        return $this->createSuccessJSONResponse('success', $result);
    }

    /**
     * @Route("/create", name="admin.college.create", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:College');
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
            $collegeService = $this->get(CollegeService::class);
            try {
                $college = new College();
                /** @var College $college */
                $college = $collegeService->save($college, $data);

                $data['id'] = $college->getId();
                $data['createdAt'] = $college->getCreatedAt()->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return self::createFailureJSONResponse('fail');
            }
        }

        return self::createSuccessJSONResponse('success', $data);
    }

    /**
     * @Route("/{id}/update", name="admin.college.update", methods={"POST"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:College');

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
            $collegeService = $this->get(CollegeService::class);
            try {
                $college = $repo->find($id);
                if ($college === null) {
                    return $this->createFailureJSONResponse(-1, 'fail');
                }
                /** @var College $college */
                $college = $collegeService->save($college, $data);

                $data['id'] = $college->getId();
                $data['createdAt'] = $college->getCreatedAt()->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return self::createFailureJSONResponse(-1, 'fail');
            }
        }

        return $this->createSuccessJSONResponse('success', $data);
    }

    /**
     * 标签删除
     * @Route("/{id}/delete", name="admin.college.delete", methods={"POST"})
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:College');
        $college = $repo->findOneBy(['id' => $id]);
        if ($college === null) {
            return self::createFailureJSONResponse('fail');
        }

        try {
            $em->remove($college);
            $em->flush();
        } catch (\Exception $e) {
            $em->rollback();
        }

        return self::createSuccessJSONResponse('success', []);
    }
}
