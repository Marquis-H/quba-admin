<?php


namespace AdminApiBundle\Controller;


use CommonBundle\Entity\Banner;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use CommonBundle\Services\BannerService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;

class BannerController extends AbstractApiController
{
    /**
     * @Route("/list", name="admin.banner.list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request)
    {
        $common = $this->container->get(CommonHelper::class);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:Banner');

        $queryBuild = $repo->getQueryBuilder();
        $result = $common->filterPagination($request->query->get('filters'), $request->query->get('currentPage'), $request->query->get('perPage'), $queryBuild, Banner::class);

        return $this->createSuccessJSONResponse('success', $result);
    }

    /**
     * @Route("/create", name="admin.banner.create", methods={"POST"})
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
            'file' => [],
            'slug' => [],
            'url' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);
        if (count($errors) > 0) {
            return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
        } else {
            $BannerService = $this->get(BannerService::class);
            try {
                $banner = new Banner();
                /** @var Banner $banner */
                $banner = $BannerService->save($banner, $data);

                $data['id'] = $banner->getId();
                $data['createdAt'] = $banner->getCreatedAt()->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return self::createFailureJSONResponse('fail');
            }
        }

        return self::createSuccessJSONResponse('success', $data);
    }

    /**
     * @Route("/{id}/update", name="admin.banner.update", methods={"POST"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:Banner');

        $data = $request->request->all();
        $validator = $this->get('validator');
        unset($data['createdAt']);

        $collectionConstraint = new Collection([
            'id' => [],
            'title' => [],
            'file' => [],
            'slug' => [],
            'url' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);
        if (count($errors) > 0) {
            return self::createFailureJSONResponse(100, 'fail', $this->getErrors($errors));
        } else {
            $bannerService = $this->get(BannerService::class);
            try {
                $banner = $repo->find($id);
                if ($banner === null) {
                    return $this->createFailureJSONResponse(-1, 'fail');
                }
                /** @var Banner $banner */
                $banner = $bannerService->save($banner, $data);

                $data['id'] = $banner->getId();
                $data['createdAt'] = $banner->getCreatedAt()->format('Y-m-d H:i');
            } catch (\Exception $e) {
                return self::createFailureJSONResponse(-1, 'fail');
            }
        }

        return $this->createSuccessJSONResponse('success', $data);
    }

    /**
     * 删除
     * @Route("/{id}/delete", name="admin.banner.delete", methods={"POST"})
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:Banner');
        $banner = $repo->findOneBy(['id' => $id]);
        if ($banner === null) {
            return self::createFailureJSONResponse('fail');
        }

        try {
            $em->remove($banner);
            $em->flush();
        } catch (\Exception $e) {
            $em->rollback();
        }

        return self::createSuccessJSONResponse('success', []);
    }
}
