<?php


namespace AdminApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DashboardController
 * @package AdminApiBundle\Controller
 */
class DashboardController extends AbstractApiController
{
    /**
     * @Route("/info", name="admin.dashboard.info", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function info()
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $users = $em->getRepository('CommonBundle:FosUser')->findAll();
        $weappUser = $em->getRepository('CommonBundle:WeappUser')->findAll();

        return $this->createSuccessJSONResponse('success', [
            'statistics' => [
                'idles' => 0,
                'teams' => 0,
                'weappUser' => count($weappUser),
                'user' => count($users)
            ]
        ]);
    }
}
