<?php


namespace CommonBundle\Services;


use CommonBundle\Entity\Professional;
use Doctrine\ORM\EntityManager;

class ProfessionalService extends AbstractService
{
    /**
     * @param Professional $entity
     * @param $data
     * @return Professional
     */
    public function save($entity, $data)
    {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $college = $em->getRepository('CommonBundle:College')->find($data['college']);
        unset($data['id']);
        $em->getConnection()->beginTransaction();
        try {
            $entity->setTitle($data['title']);
            $entity->setDescription($data['description']);
            $entity->setCollege($college);
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
