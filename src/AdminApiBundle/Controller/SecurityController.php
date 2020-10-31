<?php


namespace AdminApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractApiController
{
    /**
     * 登陆
     *
     * @Route("/login_check", name="admin.auth.login_check")
     * @Method({"POST"})
     * @param Request $request
     */
    public function login(Request $request)
    {
    }

    /**
     * 登出
     *
     * @Route("/logout", name="admin.auth.logout")
     * @return JsonResponse
     */
    public function logout()
    {
        return self::createSuccessJSONResponse();
    }
}
