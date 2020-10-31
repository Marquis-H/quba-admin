<?php

namespace CommonBundle\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * IdleCategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IdleCategoryRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->createQueryBuilder('q');
    }

    /**
     * @param $title
     * @param $id
     * @return int
     */
    public function isUnique($title, $id)
    {
        $result = $this->createQueryBuilder('q')
            ->select('q')
            ->where('q.title = :title')
            ->andWhere('q.id != :id')
            ->setParameters([
                'id' => $id,
                'title' => $title
            ])
            ->getQuery()
            ->getResult();

        return count($result);
    }
}
