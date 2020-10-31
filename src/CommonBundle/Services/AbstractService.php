<?php


namespace CommonBundle\Services;

use CommonBundle\Entity\FosUser;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AbstractService
{
    /** @var ContainerInterface */
    public $container;

    /**
     * BannerService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritDoc
     */
    public function save($entity, $data)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        unset($data['id']);
        $em->getConnection()->beginTransaction();
        try {
            foreach ($data as $field => $value) {
                switch ($field) {
                    case 'startDate':
                    case 'endDate':
                        $value = new \DateTime($value);
                        break;
                }
                $setFun = 'set' . ucwords($field);
                $entity->{$setFun}($value);
            }
            $em->persist($entity);
            $em->flush();

            $em->getConnection()->commit();

            return $entity;
        } catch (\Exception $e) {
            $em->rollback();

            throw new \LogicException($e->getMessage());
        }
    }
}
