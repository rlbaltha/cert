<?php

namespace AppBundle\Entity;

/**
 * MajorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MajorRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * find major data
     *
     */
    public function findMajorData() {
        $data = $this->createQueryBuilder('m')
            ->join('m.program1', 'pr')
            ->join('pr.user', 'u')
            ->join('u.progress', 'p')
            ->andWhere(':tag MEMBER OF u.tags')
            ->select('m.name AS area', 'count(m.id) AS value')
            ->groupBy('m.name')
            ->orderBy("value", "DESC")
            ->setParameter('tag', 116)
            ->getQuery()
            ->getResult();
        return $data;
    }
}
