<?php


namespace AdminApiBundle\Controller;


use CommonBundle\Entity\Professional;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use CommonBundle\Services\ProfessionalService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;

class ProfessionalController extends AbstractApiController
{
    /**
     * @Route("/items", name="admin.professional.items", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function items(Request $request)
    {
        $repo = $this->getEntityManager()->getRepository('CommonBundle:Professional');
        $professionals = $repo->findAll();

        $professionalDatas = [];
        /** @var Professional $professional */
        foreach ($professionals as $professional) {
            array_push($professionalDatas, [
                'text' => $professional->getTitle(),
                'value' => $professional->getId()
            ]);
        }

        return self::createSuccessJSONResponse('success', $professionalDatas);
    }

    /**
     * @Route("/list", name="admin.professional.list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request)
    {
        $common = $this->container->get(CommonHelper::class);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:Professional');

        $queryBuild = $repo->getQueryBuilder();
        $result = $common->filterPagination($request->query->get('filters'), 1, 10, $queryBuild, Professional::class);

        return $this->createSuccessJSONResponse('success', $result);
    }

    /**
     * @Route("/create", name="admin.professional.create", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:Professional');
        $data = $request->request->all();
        $validator = $this->get('validator');
        $collectionConstraint = new Collection([
            'title' => [],
            'description' => [],
            'college' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);

        if ($repo->findOneBy(['title' => $data['title']])) {
            return self::createFailureJSONResponse('fail', '名称已存在', []);
        } else if (count($errors) > 0) {
            return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
        } else {
            $professionalService = $this->get(ProfessionalService::class);
            try {
                $professional = new Professional();
                /** @var Professional $professional */
                $professional = $professionalService->save($professional, $data);

                $data['id'] = $professional->getId();
                $data['createdAt'] = $professional->getCreatedAt()->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return self::createFailureJSONResponse('fail');
            }
        }

        return self::createSuccessJSONResponse('success', $data);
    }

    /**
     * @Route("/{id}/update", name="admin.professional.update", methods={"POST"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:Professional');

        $data = $request->request->all();
        $validator = $this->get('validator');
        unset($data['createdAt']);

        $collectionConstraint = new Collection([
            'id' => [],
            'title' => [],
            'description' => [],
            'college' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);
        $isUnique = $repo->isUnique($data['title'], $id);
        if ($isUnique > 0) {
            return self::createFailureJSONResponse('fail', "数据已存在", []);
        } else if (count($errors) > 0) {
            return self::createFailureJSONResponse(100, 'fail', $this->getErrors($errors));
        } else {
            $professionalService = $this->get(ProfessionalService::class);
            try {
                $professional = $repo->find($id);
                if ($professional === null) {
                    return $this->createFailureJSONResponse(-1, 'fail');
                }
                /** @var Professional $professional */
                $professional = $professionalService->save($professional, $data);

                $data['id'] = $professional->getId();
                $data['createdAt'] = $professional->getCreatedAt()->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return self::createFailureJSONResponse(-1, 'fail');
            }
        }

        return $this->createSuccessJSONResponse('success', $data);
    }

    /**
     * 删除
     * @Route("/{id}/delete", name="admin.professional.delete", methods={"POST"})
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:Professional');
        $professional = $repo->findOneBy(['id' => $id]);
        if ($professional === null) {
            return self::createFailureJSONResponse('fail');
        }

        try {
            $em->remove($professional);
            $em->flush();
        } catch (\Exception $e) {
            $em->rollback();
        }

        return self::createSuccessJSONResponse('success', []);
    }
}
