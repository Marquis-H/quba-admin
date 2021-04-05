<?php


namespace AdminApiBundle\Controller;

use CommonBundle\Services\WechatService;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use WeappApiBundle\Annotation\Anonymous;

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
        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        $users = $em->getRepository('CommonBundle:FosUser')->findAll();
        $weappUser = $em->getRepository('CommonBundle:WeappUser')->findAll();
        $idles = $em->getRepository('CommonBundle:IdleApplication')->findAll();
        $teams = $em->getRepository('CommonBundle:MatchApplication')->findBy(['isSponsor' => true]);

        return $this->createSuccessJSONResponse('success', [
            'statistics' => [
                'idles' => count($idles),
                'teams' => count($teams),
                'weappUser' => count($weappUser),
                'user' => count($users)
            ]
        ]);
    }

    /**
     * @Route("/line", name="admin.dashboard.line", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function Line(Request $request)
    {
        $day = $request->query->get('day');
        $app = $this->get(WechatService::class)->getApplication();
        $line = [];
        $pie = [];

        for ($i = 1; $i <= $day; $i++) {
            $date = date("Ymd", strtotime("-{$i} day", strtotime(date('Y-m-d'))));
            array_push($line, $app->data_cube->summaryTrend($date, $date));
            array_push($pie, $app->data_cube->visitPage($date, $date));
        }

        return $this->createSuccessJSONResponse('success', [
            'line' => $line,
            'pie' => $pie,
        ]);
    }
}
