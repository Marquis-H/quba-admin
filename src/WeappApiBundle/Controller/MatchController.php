<?php


namespace WeappApiBundle\Controller;


use CommonBundle\Entity\WeappUser;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonTools;
use CommonBundle\Services\CommonService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use WeappApiBundle\Constants\ApiCode;
use WeappApiBundle\Exceptions\WeappApiException;

class MatchController extends AbstractApiController
{
    /**
     * 列表
     * @Route("/list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request)
    {
        $commonService = $this->container->get(CommonService::class);

        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $match = $em->getRepository('CommonBundle:MatchInfo')->findBy([], ['endAt' => 'desc']);

        return self::createSuccessJSONResponse('success', $commonService->toDataModel($match));
    }

    /**
     * 详情
     * @Route("/detail", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws WeappApiException
     */
    public function detail(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        if (!$profile) {
            throw new WeappApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }

        $params = $request->query->all();
        CommonTools::checkParams($params, ['id']);
        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        $matchInfo = $em->getRepository('CommonBundle:MatchInfo')->find($params['id']);

        if ($matchInfo == null) {
            throw new ApiException('记录不存在', ApiCode::DATA_NOT_FOUND);
        }

        $commonService = $this->container->get(CommonService::class);
        return self::createSuccessJSONResponse('success', $commonService->toDataModel($matchInfo));
    }
}
