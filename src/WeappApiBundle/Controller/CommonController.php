<?php


namespace WeappApiBundle\Controller;

use CommonBundle\Services\CommonService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommonController extends AbstractApiController
{
    /**
     * 廣告
     * @Route("/colleges", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function banner(Request $request)
    {
        $common = $this->container->get(CommonService::class);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:College');
        $output = $repo->findAll();

        return $this->createSuccessJSONResponse('success', $common->toDataModel($output));
    }
}
