<?php


namespace CommonBundle\Services;

use CommonBundle\Entity\FosUser;
use Symfony\Component\PropertyAccess\PropertyAccess;

class UserService extends AbstractService
{
    /**
     * @param FosUser $fosUser
     * @param $data
     * @return FosUser|mixed
     */
    public function save($fosUser, $data)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $accessor = PropertyAccess::createPropertyAccessor();
        $conn = $em->getConnection();

        try {
            $conn->beginTransaction();
            $fosUser->setUsername($accessor->getValue($data, '[username]'));
            $fosUser->setEmail($accessor->getValue($data, '[email]'));
            $password = $accessor->getValue($data, '[password]');
            if ($password) {
                $encodePassword = $this->container->get('security.password_encoder')->encodePassword($fosUser, $password);
                $fosUser->setPassword($encodePassword);
            }
            $fosUser->setEnabled($accessor->getValue($data, '[enabled]'));
            $fosUser->setRoles($accessor->getValue($data, '[roles]'));
            if ($accessor->getValue($data, '[isSuperAdmin]')) {
                $fosUser->addRole('ROLE_SUPER_ADMIN');
            } else {
                $fosUser->removeRole('ROLE_SUPER_ADMIN');
            }
            $fosUser->setName($accessor->getValue($data, '[name]'));

            $em->persist($fosUser);
            $em->flush();

            $conn->commit();
            return $fosUser;
        } catch (\Exception $exception) {
            $em->rollback();

            throw new \LogicException($exception->getMessage());
        }
    }
}
