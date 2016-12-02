<?php

namespace AppBundle\Entity;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * Find users by type
     *
     * @return User
     */
    public function findUsersByType($type)
    {
        $course = $this->createQueryBuilder('u')
            ->join('u.program', 'p')
            ->andWhere("u.progress = :type")
            ->setParameter('type', $type)
            ->addOrderBy('p.graddate', 'ASC')
            ->addOrderBy('p.gradterm', 'DESC')
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->getQuery()
            ->getResult();
        return $course;
    }

    /**
     * Find users by term
     *
     * @return User
     */
    public function findUsersByTerm($term, $date)
    {
        $course = $this->createQueryBuilder('u')
            ->join('u.progress', 'p')
            ->join('u.program', 'pr')
            ->andWhere("pr.gradterm = :term")
            ->andWhere("pr.graddate = :date")
            ->andWhere("p.name != 'Administration' and p.name != 'Faculty' and p.name != 'Graduated'  and p.name != 'Account Created'")
            ->setParameter('term', $term)
            ->setParameter('date', $date)
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->getQuery()
            ->getResult();
        return $course;
    }

    /**
     * Find student users
     *
     * @return User
     */
    public function findStudents()
    {
        $course = $this->createQueryBuilder('u')
            ->join('u.progress', 'p')
            ->join('u.program', 'pr')
            ->andWhere("p.name != 'Administration' and p.name != 'Faculty' and p.name != 'Graduated'  and p.name != 'Account Created'")
            ->addOrderBy('pr.graddate', 'ASC')
            ->addOrderBy('pr.gradterm', 'DESC')
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->getQuery()
            ->getResult();
        return $course;
    }

}
