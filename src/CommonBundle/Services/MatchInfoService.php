<?php


namespace CommonBundle\Services;


use CommonBundle\Entity\MatchInfo;
use Doctrine\ORM\EntityManager;

class MatchInfoService extends AbstractService
{
    /**
     * @param MatchInfo $entity
     * @param $data
     * @return MatchInfo
     */
    public function save($entity, $data)
    {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $matchCategory = $em->getRepository('CommonBundle:MatchCategory')->find($data['tabs'][2]);
        unset($data['id']);
        $em->getConnection()->beginTransaction();
        try {
            $entity->setTitle($data['title']);
            $entity->setEndAt(new \DateTime($data['endAt']));
            $entity->setFiles($data['files']);
            $entity->setMatchCategory($matchCategory);
            $entity->setTabs($data['tabs']);
            $entity->setPeopleLimit($data['peopleLimit']);
            $entity->setQualificationLimit($data['qualificationLimit']);
            $entity->setUrls($data['urls']);
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
