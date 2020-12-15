<?php


namespace AdminApiBundle\Controller;


use CommonBundle\Entity\Page;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use CommonBundle\Services\PageService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;

class PageController extends AbstractApiController
{
    /**
     * @Route("/list", name="admin.page.list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request)
    {
        $common = $this->container->get(CommonHelper::class);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:Page');

        $queryBuild = $repo->getQueryBuilder();
        $result = $common->filterPagination($request->query->get('filters'), $request->query->get('currentPage'), $request->query->get('perPage'), $queryBuild, Page::class);

        return $this->createSuccessJSONResponse('success', $result);
    }

    /**
     * @Route("/create", name="admin.page.create", methods={"POST"})
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
            'content' => [],
            'slug' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);
        if (count($errors) > 0) {
            return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
        } else {
            $PageService = $this->get(PageService::class);
            try {
                $page = new Page();
                /** @var Page $page */
                $page = $PageService->save($page, $data);

                $data['id'] = $page->getId();
                $data['createdAt'] = $page->getCreatedAt()->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return self::createFailureJSONResponse('fail');
            }
        }

        return self::createSuccessJSONResponse('success', $data);
    }

    /**
     * @Route("/{id}/update", name="admin.page.update", methods={"POST"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:Page');

        $data = $request->request->all();
        $validator = $this->get('validator');
        unset($data['createdAt']);

        $collectionConstraint = new Collection([
            'id' => [],
            'title' => [],
            'content' => [],
            'slug' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);
        if (count($errors) > 0) {
            return self::createFailureJSONResponse(100, 'fail', $this->getErrors($errors));
        } else {
            $pageService = $this->get(PageService::class);
            try {
                $page = $repo->find($id);
                if ($page === null) {
                    return $this->createFailureJSONResponse(-1, 'fail');
                }
                /** @var Page $page */
                $page = $pageService->save($page, $data);

                $data['id'] = $page->getId();
                $data['createdAt'] = $page->getCreatedAt()->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return self::createFailureJSONResponse(-1, 'fail');
            }
        }

        return $this->createSuccessJSONResponse('success', $data);
    }

    /**
     * 删除
     * @Route("/{id}/delete", name="admin.page.delete", methods={"POST"})
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:Page');
        $page = $repo->findOneBy(['id' => $id]);
        if ($page === null) {
            return self::createFailureJSONResponse('fail');
        }

        try {
            $em->remove($page);
            $em->flush();
        } catch (\Exception $e) {
            $em->rollback();
        }

        return self::createSuccessJSONResponse('success', []);
    }
}
