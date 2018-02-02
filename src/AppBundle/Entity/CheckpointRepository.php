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
    public function findCurrent($user, $admin) {
        $today = date("Y-m-d");
        if ($admin = 'yes') {
            $type = 'Admin';
            $events = $this->createQueryBuilder('c')
                ->join('c.project','p')
                ->andWhere('c.deadline >= :today')
                ->andWhere('p.user = :user or p.type = :type')
                ->orderBy('c.deadline', 'ASC')
                ->setParameter('today',$today)
                ->setParameter('user',$user)
                ->setParameter('type',$type)
                ->getQuery()
                ->getResult();
            return $events;
        }
        else {
            $events = $this->createQueryBuilder('c')
                ->join('c.project','p')
                ->andWhere('c.deadline >= :today')
                ->andWhere('p.user = :user')
                ->orderBy('c.deadline', 'ASC')
                ->setParameter('today',$today)
                ->setParameter('user',$user)
                ->getQuery()
                ->getResult();
            return $events;
        }

    }

    /**
     * Find all upcoming checkpoints
     *
     * @return Checkpoint
     */
    public function findAdminCurrent() {
        $type = 'Admin';
        $status = 'Opened';
        $today = date("Y-m-d");
        $events = $this->createQueryBuilder('c')
            ->join('c.project','p')
            ->andWhere('c.status = :status')
            ->andWhere('p.type = :type')
            ->orderBy('c.deadline', 'ASC')
            ->setParameter('status',$status)
            ->setParameter('type',$type)
            ->getQuery()
            ->getResult();
        return $events;
    }

    /**
     * Find all upcoming checkpoints
     *
     * @return Checkpoint
     */
    public function findCurrentForMail() {
        $status = 'Opened';
        $date = strtotime("-1 day");
        $startdate = date("Y-m-d", $date);
        $events = $this->createQueryBuilder('c')
            ->join('c.project','p')
            ->join('p.capstone','a')
            ->join('a.user','u')
            ->andWhere('c.status = :status')
            ->andWhere('c.deadline >= :startdate')
            ->orderBy('c.deadline', 'ASC')
            ->setParameter('status',$status)
            ->setParameter('startdate',$startdate)
            ->getQuery()
            ->getResult();
        return $events;
    }

}
