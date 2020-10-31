<?php


namespace AdminApiBundle\Controller;


use CommonBundle\Entity\WeappUser;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WeappUserController extends AbstractApiController
{
    /**
     * 小程序用户列表
     * @Route("/list", name="admin.weapp_user.list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request)
    {
        $common = $this->container->get(CommonHelper::class);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:WeappUser');

        $queryBuild = $repo->getQueryBuilder();
        $result = $common->filterPagination($request->query->get('filters'), $request->query->get('currentPage'), $request->query->get('perPage'), $queryBuild, WeappUser::class);

        return $this->createSuccessJSONResponse('success', $result);
    }
}
