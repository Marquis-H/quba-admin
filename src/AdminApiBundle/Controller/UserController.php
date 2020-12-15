<?php


namespace AdminApiBundle\Controller;

use CommonBundle\Entity\FosUser;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use CommonBundle\Services\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Yaml\Yaml;

/**
 * Class UserController
 * @package AdminApiBundle\Controller
 */
class UserController extends AbstractApiController
{
    /**
     * 获取用户信息
     *
     * @Route("/info", name="admin.user.info")
     * @Method({"GET"})
     * @param $request
     *
     * @return JsonResponse
     */
    public function info(Request $request)
    {
        /** @var FosUser $user */
        $user = $this->getUser();

        $router = $this->get('router');
        return $this->createSuccessJSONResponse('success', [
            'name' => $user->getUsername(),
            'roles' => $user->getRoles(),
            'introduction' => '我是管理员',
            'avatar' => 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
            'setting' => [
                'domain' => $this->getParameter('api_domain'),
                'uploadImageUrl' => $router->generate('admin.upload.image', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'uploadFileUrl' => $router->generate('admin.upload.file', [], UrlGeneratorInterface::ABSOLUTE_URL)
            ]
        ]);
    }

    /**
     * 权限列表
     * @Route("/roles", name="admin.user.roles")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function roles(Request $request)
    {
        $settingRoleYml = $this->get('kernel')->getRootDir() . '/config/setting_role.yml';
        $value = Yaml::parseFile($settingRoleYml);
        $roles = [];
        foreach ($value['choices'] as $k => $v) {
            array_push($roles, [
                'text' => $v['label'],
                'value' => $k
            ]);
        }

        return self::createSuccessJSONResponse('success', $roles);
    }

    /**
     * 用户列表
     * @Route("/list", name="admin.user.list")
     * @Method({"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request)
    {
        $common = $this->container->get(CommonHelper::class);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:FosUser');

        $queryBuild = $repo->getQueryBuilder();
        $result = $common->filterPagination($request->query->get('filters'), $request->query->get('currentPage'), $request->query->get('perPage'), $queryBuild, FosUser::class);

        return $this->createSuccessJSONResponse('success', $result);
    }

    /**
     * 用户创建
     * @Route("/create", name="admin.user.create")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $fosUserRepo = $em->getRepository('CommonBundle:FosUser');
        $data = $request->request->all();
        $validator = $this->get('validator');
        $collectionConstraint = new Collection([
            'enabled' => [],
            'isSuperAdmin' => [],
            'name' => [
                new NotBlank()
            ],
            'username' => [
                new NotBlank()
            ],
            'email' => [],
            'password' => [
                new NotBlank()
            ],
            'confirmPassword' => [],
            'roles' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);

        if ($fosUserRepo->findOneBy(['username' => $data['username']])) {
            return self::createFailureJSONResponse('fail', '用户名已存在', []);
        } else if (count($errors) > 0) {
            return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
        } else {
            $userService = $this->get(UserService::class);
            try {
                $fosUser = new FosUser();
                /** @var FosUser $fosUser */
                $fosUser = $userService->save($fosUser, $data);

                $data['id'] = $fosUser->getId();
                $data['lastLogin'] = '-';
            } catch (\Exception $e) {
                return self::createFailureJSONResponse($e->getMessage());
            }
        }

        return self::createSuccessJSONResponse('success', $data);
    }

    /**
     * 用户更新
     * @Route("/{id}/update", name="admin.user.update")
     * @Method({"POST"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $fosUserRepo = $em->getRepository('CommonBundle:FosUser');

        $data = $request->request->all();
        $validator = $this->get('validator');

        $collectionConstraint = new Collection([
            'id' => [],
            'enabled' => [],
            'isSuperAdmin' => [],
            'name' => [
                new NotBlank()
            ],
            'username' => [
                new NotBlank()
            ],
            'email' => [],
            'password' => [],
            'confirmPassword' => [],
            'roles' => [],
            'lastLogin' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);
        $isUnique = $fosUserRepo->isUnique($data['username'], $id);
        if ($isUnique > 0) {
            return self::createFailureJSONResponse('fail', "用户名已存在", []);
        } else if (count($errors) > 0) {
            return self::createFailureJSONResponse(100, 'fail', $this->getErrors($errors));
        } else {
            $userService = $this->get(UserService::class);
            try {
                $fosUser = $fosUserRepo->find($id);
                if ($fosUser === null) {
                    return $this->createFailureJSONResponse(-1, 'fail');
                }
                /** @var FosUser $fosUser */
                $fosUser = $userService->save($fosUser, $data);

                $data['id'] = $fosUser->getId();
            } catch (\Exception $e) {
                return self::createFailureJSONResponse(-1, 'fail');
            }
        }

        return $this->createSuccessJSONResponse('success', $data);
    }

    /**
     * 用户删除
     * @Route("/{id}/delete", name="admin.user.delete")
     * @Method({"POST"})
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $fosUserRepo = $em->getRepository('CommonBundle:FosUser');
        $fosUser = $fosUserRepo->findOneBy(['id' => $id]);
        if ($fosUser === null) {
            return self::createFailureJSONResponse('fail');
        }

        try {
            $em->remove($fosUser);
            $em->flush();
        } catch (\Exception $e) {
            $em->rollback();
        }

        return self::createSuccessJSONResponse('success', []);
    }
}
