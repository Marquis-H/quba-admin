<?php


namespace WeappApiBundle\Controller;


use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonTools;
use CommonBundle\Services\CommonService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use WeappApiBundle\Annotation\Anonymous;
use WeappApiBundle\Exceptions\WeappApiException;

/**
 * @Anonymous()
 *
 * Class WebController
 * @package WeappApiBundle\Controller
 */
class WebController extends AbstractApiController
{
    /**
     * 廣告
     * @Route("/banner", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function banner(Request $request)
    {
        $common = $this->container->get(CommonService::class);
        $params = $request->query->all();
        CommonTools::checkParams($params, ['slug']);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:Banner');
        $output = $repo->findBy(['slug' => $params['slug']]);

        return $this->createSuccessJSONResponse('success', $common->toDataModel($output));
    }

    /**
     * 页面
     * @Route("/page", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function page(Request $request){
        $common = $this->container->get(CommonService::class);
        $params = $request->query->all();
        CommonTools::checkParams($params, ['slug']);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:Page');
        $output = $repo->findOneBy(['slug' => $params['slug']]);

        return $this->createSuccessJSONResponse('success', $common->toDataModel($output));
    }
}
