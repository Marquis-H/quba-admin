<?php

namespace CommonBundle\Repository;

use CommonBundle\Constants\TradeStatus;

/**
 * IdleProfileRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IdleProfileRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $profile
     * @param $slug
     * @return mixed
     */
    public function findByStatus($profile, $slug)
    {
        $result = $this->createQueryBuilder('q')
            ->select('q')
            ->leftJoin('q.IdleApplication', 'i');

        if ($slug == 'buy') {
            $result = $result
                ->andWhere('q.Profile = :profile')
                ->setParameter('profile', $profile);
        } else if ($slug == 'sale') {
            $result = $result
                ->andWhere('i.Profile = :profile')
                ->setParameter('profile', $profile);
        }
        return $result
            ->orderBy('q.createdAt', 'desc')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $profile
     * @return array
     */
    public function findOrders($profile){
        return $this->createQueryBuilder('q')
            ->leftJoin('q.IdleApplication', 'a')
            ->where('q.Profile = :profile or a.Profile = :profile')
            ->andWhere('q.status = :status')
            ->setParameters([
                'profile' => $profile,
                'status' => TradeStatus::Done
            ])
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @param $id
     * @param $profile
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByApplicationProfile($id, $profile)
    {
        return $this->createQueryBuilder('q')
            ->leftJoin('q.IdleApplication', 'a')
            ->where('a.Profile = :profile or q.Profile = :profile')
            ->andWhere('q.id = :id')
            ->setParameters([
                'profile' => $profile,
                'id' => $id
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
