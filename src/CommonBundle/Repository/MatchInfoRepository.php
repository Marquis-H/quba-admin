<?php

namespace CommonBundle\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * MatchInfoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MatchInfoRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->createQueryBuilder('q');
    }

    /**
     * @param $cId
     * @param $title
     * @param $isOnline
     * @param $type
     * @param $currentSortOrder
     * @return QueryBuilder|mixed
     */
    public function searchByCategory($cId, $isOnline, $type, $title, $currentSortOrder)
    {
        $result = $this->createQueryBuilder('q')
            ->leftJoin('q.MatchCategory', 'm')
            ->where('q.title LIKE :title');

        if ($cId != 0) {
            $result = $result
                ->andWhere('m.id = :cId')
                ->setParameter('cId', $cId);
        }

        if($isOnline != "null"){
            $result = $result
                ->andWhere('m.isOnline = :isOnline')
                ->setParameter('isOnline', $isOnline);
        }

        if($type != "null"){
            $result = $result
                ->andWhere('m.type = :type')
                ->setParameter('type', $isOnline);
        }

        if ($currentSortOrder != "null") {
            $result = $result
                ->orderBy('q.currentCost', $currentSortOrder);
        }

        $result = $result
            ->setParameter('title', "%{$title}%")
            ->getQuery()
            ->getResult();
        return $result;
    }
}
