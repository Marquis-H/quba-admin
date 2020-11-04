<?php


namespace WeappApiBundle\Controller;


use CommonBundle\Entity\Mark;
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

class MarkController extends AbstractApiController
{
    /**
     * @Route("/is_mark", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function isMark(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        $params = $request->query->all();
        CommonTools::checkParams($params, ['id', 'slug']);
        $commonService = $this->container->get(CommonService::class);
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $mark = null;
        if ($profile) {
            switch ($params['slug']) {
                case 'idle_application':
                    $idleApplication = $em->getRepository('CommonBundle:IdleApplication')->find($params['id']);
                    $mark = $em->getRepository('CommonBundle:Mark')->findOneBy(['WeappUserProfile' => $profile, 'slug' => $params['slug'], 'IdleApplication' => $idleApplication]);
                    break;
                case 'match_info':
                    $matchInfo = $em->getRepository('CommonBundle:MatchInfo')->find($params['id']);
                    $mark = $em->getRepository('CommonBundle:Mark')->findOneBy(['WeappUserProfile' => $profile, 'slug' => $params['slug'], 'MatchInfo' => $matchInfo]);
                    break;
            }
        }

        return $this->createSuccessJSONResponse('success', $commonService->toDataModel($mark));
    }

    /**
     * @Route("/add", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws WeappApiException
     * @throws ApiException
     */
    public function add(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        if (!$profile) {
            throw new WeappApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }

        $params = $request->request->all();
        CommonTools::checkParams($params, ['id', 'module']);
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        try {
            $mark = new Mark();
            switch ($params['module']) {
                case 'idle_application':
                    $idleApplication = $em->getRepository('CommonBundle:IdleApplication')->find($params['id']);
                    $mark->setIdleApplication($idleApplication);
                    $mark->setWeappUserProfile($profile);
                    $mark->setSlug('idle_application');

                    break;
                case 'match_info':
                    $matchInfo = $em->getRepository('CommonBundle:MatchInfo')->find($params['id']);
                    $mark->setMatchInfo($matchInfo);
                    $mark->setWeappUserProfile($profile);
                    $mark->setSlug('match_info');

                    break;
            }

            $em->persist($mark);
            $em->flush();
        } catch (\Exception $e) {
            return self::createFailureJSONResponse(-1, $e->getMessage());
        }

        return self::createSuccessJSONResponse('success');
    }
}
