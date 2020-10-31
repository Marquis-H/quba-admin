<?php


namespace AdminApiBundle\Controller;


use CommonBundle\Entity\IdleApplication;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IdleApplicationController extends AbstractApiController
{
    /**
     * @Route("/list", name="admin.idle_application.list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request)
    {
        $common = $this->container->get(CommonHelper::class);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:IdleApplication');

        $queryBuild = $repo->getQueryBuilder();
        $result = $common->filterPagination($request->query->get('filters'), 1, 10, $queryBuild, IdleApplication::class);

        return $this->createSuccessJSONResponse('success', $result);
    }
}
