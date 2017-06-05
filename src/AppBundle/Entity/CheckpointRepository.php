<?php

namespace AppBundle\Entity;

/**
 * CheckpointRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CheckpointRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * Find all upcoming checkpoints
     *
     * @return Checkpoint
     */
    public function findCurrent() {
        $today = date("Y-m-d");
        $events = $this->createQueryBuilder('c')
            ->andWhere('c.deadline >= :today')
            ->orderBy('c.deadline', 'ASC')
            ->setParameter('today',$today)
            ->getQuery()
            ->getResult();
        return $events;
    }


}
