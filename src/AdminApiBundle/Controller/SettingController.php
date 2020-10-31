<?php


namespace AdminApiBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SettingController
 * @package AdminApiBundle\Controller
 */
class SettingController extends AbstractApiController
{
    /**
     * @Route("/info", name="admin.setting.info", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function info(Request $request)
    {
        return $this->createSuccessJSONResponse('success', [
            'system' => [
                'name' => '后台管理系统',
                'logo' => null
            ],
            'normal' => [
                'isGray' => false
            ]
        ]);
    }

    /**
     * @Route("/update", name="admin.setting.update", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        return $this->createSuccessJSONResponse('success', [
            'system' => [
                'name' => '后台管理系统',
                'logo' => null
            ],
            'normal' => [
                'isGray' => false
            ]
        ]);
    }
}
