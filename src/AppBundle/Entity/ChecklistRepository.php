<?php

namespace AppBundle\Entity;

/**
 * ChecklistRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ChecklistRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * find anchor data
     *
     * @return Course
     */
    public function findAnchorData() {
        $data = $this->createQueryBuilder('c')
            ->join('c.anchor','a')
            ->select('a.name AS area', 'count(a.id) AS value')
            ->groupBy('a.name')
            ->orderBy("value", "DESC")
            ->getQuery()
            ->getResult();
        return $data;
    }

    /**
     * find sphere1 data
     *
     * @return Course
     */
    public function findSphere1Data() {
        $data = $this->createQueryBuilder('c')
            ->join('c.sphere1','s')
            ->select('s.name AS area', 'count(s.id) AS value')
            ->groupBy('s.name')
            ->orderBy("value", "DESC")
            ->getQuery()
            ->getResult();
        return $data;
    }

    /**
     * find sphere2 data
     *
     * @return Course
     */
    public function findSphere2Data() {
        $data = $this->createQueryBuilder('c')
            ->join('c.sphere2','s')
            ->select('s.name AS area', 'count(s.id) AS value')
            ->groupBy('s.name')
            ->orderBy("value", "DESC")
            ->getQuery()
            ->getResult();
        return $data;
    }

    /**
     * find sphere3 data
     *
     * @return Course
     */
    public function findSphere3Data() {
        $data = $this->createQueryBuilder('c')
            ->join('c.sphere3','s')
            ->select('s.name AS area', 'count(s.id) AS value')
            ->groupBy('s.name')
            ->orderBy("value", "DESC")
            ->getQuery()
            ->getResult();
        return $data;
    }


}
