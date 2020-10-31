<?php


namespace AdminApiBundle\Controller;

use CommonBundle\Entity\FosUser;
use CommonBundle\Services\ProfileService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ProfileController
 * @package AdminApiBundle\Controller
 */
class ProfileController extends AbstractApiController
{
    /**
     * @Route("/info", name="admin.profile.info", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function info(Request $request)
    {
        /** @var FosUser $user */
        $user = $this->getUser();

        return $this->createSuccessJSONResponse('success', [
            'isEnable' => $user->getEnable(),
            'username' => $user->getUsername(),
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ]);
    }

    /**
     * @Route("/update", name="admin.profile.update", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $fosUserRepo = $em->getRepository('CommonBundle:FosUser');
        /** @var FosUser $user */
        $user = $this->getUser();

        $data = $request->request->all();
        $validator = $this->get('validator');
        $collectionConstraint = new Collection([
            'isEnable' => [],
            'username' => [
                new NotBlank()
            ],
            'email' => [],
            'name' => [
                new NotBlank()
            ]
        ]);

        $errors = $validator->validate($data, $collectionConstraint);
        $isUnique = $fosUserRepo->isUnique($data['username'], $user->getId());
        if ($isUnique > 0) {
            return self::createFailureJSONResponse('fail', "用户名已存在", []);
        } else if (count($errors) > 0) {
            return self::createFailureJSONResponse(100, 'fail', $this->getErrors($errors));
        } else {
            $profileService = $this->get(ProfileService::class);
            try {
                $fosUser = $fosUserRepo->find($user->getId());
                if ($fosUser === null) {
                    return $this->createFailureJSONResponse(-1, 'fail');
                }
                $data['Enabled'] = $data['isEnable'];
                unset($data['isEnable']); // 处理特殊字段
                /** @var FosUser $fosUser */
                $fosUser = $profileService->save($fosUser, $data);

                $data['id'] = $fosUser->getId();
            } catch (\Exception $e) {
                return self::createFailureJSONResponse(-1, 'fail');
            }
        }

        return $this->createSuccessJSONResponse('success', $data);
    }

    /**
     * @Route("/change_password", name="admin.profile.change_password", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function changePassword(Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        /** @var FosUser $user */
        $user = $this->getUser();

        $data = $request->request->all();
        $validator = $this->get('validator');
        $collectionConstraint = new Collection([
            'old' => [
                new NotBlank()
            ],
            'password' => [
                new NotBlank()
            ],
            'repeatPassword' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);

        if (count($errors) > 0) {
            return self::createFailureJSONResponse(100, 'fail', $this->getErrors($errors));
        } else {
            $encodePassword = $this->container->get('security.password_encoder')->encodePassword($user, $data['old']);
            if ($encodePassword != $user->getPassword()) {
                return self::createFailureJSONResponse(100, '旧密码不正确', []);
            }

            $encodePassword = $this->container->get('security.password_encoder')->encodePassword($user, $data['password']);
            $user->setPassword($encodePassword);

            $em->persist($user);
            $em->flush();
        }

        return $this->createSuccessJSONResponse('success', $data);
    }
}
