<?php


namespace WeappApiBundle\Controller;


use CommonBundle\Entity\IdleCategory;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonTools;
use CommonBundle\Repository\IdleApplicationRepository;
use CommonBundle\Services\CommonService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IdleController extends AbstractApiController
{
    /**
     * 分類
     * @Route("/category", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function idleCategory(Request $request)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $idleCategory = $em->getRepository('CommonBundle:IdleCategory')->findAll();

        $data = [];
        /** @var IdleCategory $value */
        foreach ($idleCategory as $value) {
            array_push($data, $value->getTitle());
        }

        return self::createSuccessJSONResponse($data);
    }

    /**
     * 列表
     * @Route("/list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function idleList(Request $request){
        $params = $request->query->all();
        CommonTools::checkParams($params, ['cId']); // 類別ID
        $commonService = $this->container->get(CommonService::class);

        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $idleApplications = $em->getRepository(IdleApplicationRepository::class)->findByCategory($params['cId']);

        return self::createSuccessJSONResponse($commonService->toDataModel($idleApplications));
    }

    /**
     * 詳情
     *
     * @Route("/list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function idleDetail(Request $request){
        $params = $request->query->all();
        CommonTools::checkParams($params, ['id']); // Application ID
        $commonService = $this->container->get(CommonService::class);

        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $idleApplication = $em->getRepository(IdleApplicationRepository::class)->find($params['id']);
        return self::createSuccessJSONResponse($commonService->toDataModel($idleApplication));
    }

    public function idleMark(Request $request){

    }
}
