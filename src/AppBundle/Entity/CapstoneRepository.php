<?php

namespace AppBundle\Entity;

/**
 * CapstoneRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CapstoneRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Find capstone by type
     *
     * @return Capstone
     */
    public function findByType($type)
    {
        if ($type == 'Peer') {
            $status = 'Ready for Peer Review';
        }
        elseif ($type == 'Completed') {
            $status = 'Completed';
        }
        else {
            $status = 'Ready for Director Review';
        }

        $capstones = $this->createQueryBuilder('c')
            ->join("c.user", "u")
            ->andWhere("u.type = :type")
            ->setParameter('type', $status)
            ->getQuery()
            ->getResult();
        return $capstones;
    }

    /**
     * Find capstones by status
     *
     * @return Capstone
     */
    public function findByStatus($status)
    {

        $capstones = $this->createQueryBuilder('c')
            ->andWhere("c.status = :status")
            ->setParameter('status', $status)
            ->getQuery()
            ->getResult();
        return $capstones;
    }

    /**
     * Find capstones by status
     *
     * @return Capstone
     */
    public function findCurrent()
    {

        $capstones = $this->createQueryBuilder('c')
            ->andWhere("c.status = :status1")
            ->orWhere("c.status = :status2")
            ->orWhere("c.status = :status3")
            ->setParameter('status1', 'Created')
            ->setParameter('status2', 'Ready for Peer Review')
            ->setParameter('status3', 'Ready for Director Review')
            ->orderBy('c.status')
            ->getQuery()
            ->getResult();
        return $capstones;
    }

    public function findByGroup($id)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT c FROM AppBundle:Capstone c JOIN c.user u LEFT JOIN c.users us WHERE (u.id = ?1 OR us.id = ?1)')->setParameter('1', $id)
            ->getResult();
    }
}
