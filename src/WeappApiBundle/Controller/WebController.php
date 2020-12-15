<?php


namespace WeappApiBundle\Controller;


use CommonBundle\Constants\IdleStatus;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonTools;
use CommonBundle\Services\CommonService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use WeappApiBundle\Annotation\Anonymous;

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

    /**
     * 静态数据
     * @Route("/statistic", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function statistic(Request $request){
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $idleApplications = $em->getRepository('CommonBundle:IdleApplication')->findBy(['status' => IdleStatus::ONLINE]);
        $matchInfos = $em->getRepository('CommonBundle:MatchInfo')->findAll();
        $matchApplications = $em->getRepository('CommonBundle:MatchApplication')->findBy(['isSponsor' => true]);

        return $this->createSuccessJSONResponse('success', [
            'idleApplications' => count($idleApplications),
            'matchInfos' => count($matchInfos),
            'matchApplications' => count($matchApplications)
        ]);
    }
}
