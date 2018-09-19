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
        $users = $this->createQueryBuilder('u')
            ->andWhere("u.progress = :type")
            ->setParameter('type', $type)
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->getQuery()
            ->getResult();
        return $users;
    }

    /**
     * Find users all capstones
     *
     * @return User
     */
    public function findCapstones()
    {
        $users = $this->createQueryBuilder('u')
            ->andWhere("u.progress = '5' or u.progress = '6' or u.progress = '12' or u.progress = '13'")
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->getQuery()
            ->getResult();
        return $users;
    }

    /**
     * Find users by term
     *
     * @return User
     */
    public function findUsersByTerm($term, $date)
    {
        $users = $this->createQueryBuilder('u')
            ->join('u.progress', 'p')
            ->join('u.program', 'pr')
            ->andWhere("u.gradterm = :term")
            ->andWhere("u.graddate = :date")
            ->andWhere("p.name != 'Administration' and p.name != 'Faculty' and p.name != 'Inactive' and p.name != 'Graduated' and p.name != 'Account Created'")
            ->setParameter('term', $term)
            ->setParameter('date', $date)
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->getQuery()
            ->getResult();
        return $users;
    }

    /**
     * Find student users
     *
     * @return User
     */
    public function findStudents()
    {
        $users = $this->createQueryBuilder('u')
            ->join('u.progress', 'p')
            ->join('u.program', 'pr')
            ->andWhere("p.name != 'Inactive' and p.name != 'Administration' and p.name != 'Faculty' and p.name != 'Graduated'  and p.name != 'Account Created'")
            ->addOrderBy('u.graddate', 'ASC')
            ->addOrderBy('u.gradterm', 'DESC')
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->getQuery()
            ->getResult();
        return $users;
    }

    /**
     * Find student users
     *
     * @return Capstone
     */
    public function findCapstonementees($user)
    {
        $users = $this->createQueryBuilder('u')
            ->join('u.capstone', 'c')
            ->andWhere('c.capstone_mentor = :user')
            ->setParameter('user', $user)
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->getQuery()
            ->getResult();
        return $users;
    }

    /**
     * Find student users
     *
     * @return User
     */
    public function findMentors()
    {
        $users = $this->createQueryBuilder('u')
            ->join('u.progress', 'p')
            ->join('u.program', 'pr')
            ->andWhere("p.name != 'Inactive' and p.name != 'Administration' and p.name != 'Faculty' and p.name != 'Graduated' and p.name != 'Account Created'")
            ->addOrderBy('u.graddate', 'ASC')
            ->addOrderBy('u.gradterm', 'DESC')
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->getQuery()
            ->getResult();
        return $users;
    }

    /**
     * Find student users
     *
     * @return User
     */
    public function findByTag($tagid)
    {
        $users = $this->createQueryBuilder('u')
            ->leftjoin('u.progress', 'p')
            ->leftjoin('u.program', 'pr')
            ->andWhere(':tag MEMBER OF u.tags')
            ->addOrderBy('u.graddate', 'ASC')
            ->addOrderBy('u.gradterm', 'DESC')
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->setParameter('tag', $tagid)
            ->getQuery()
            ->getResult();
        return $users;
    }


    /**
     * Find student users
     *
     * @return User
     */
    public function findMentees()
    {
        $users = $this->createQueryBuilder('u')
            ->join('u.progress', 'p')
            ->join('u.program', 'pr')
            ->andWhere("pr.mentor = 'Yes'")
            ->addOrderBy('u.graddate', 'ASC')
            ->addOrderBy('u.gradterm', 'DESC')
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->getQuery()
            ->getResult();
        return $users;
    }


    /**
     * Find student users
     *
     * @return User
     */
    public function findUnassignedMentee()
    {
        $users = $this->createQueryBuilder('u')
            ->join('u.progress', 'p')
            ->join('u.program', 'pr')
            ->andWhere("pr.mentor = 'Yes'")
            ->andWhere("u.peermentor is null")
            ->addOrderBy('u.graddate', 'ASC')
            ->addOrderBy('u.gradterm', 'DESC')
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
        return $users;
    }

    /**
     * Find student users
     *
     * @return User
     */
    public function findMentorWithNoMentees()
    {
        $users = $this->createQueryBuilder('u')
            ->join('u.progress', 'p')
            ->join('u.program', 'pr')
            ->leftJoin('u.peermentees','pm')
            ->having('COUNT(pm.id) = 0')
            ->andWhere("pr.mentor = 'More'")
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        return $users;
    }

    /**
     * Find student users
     *
     * @return User
     */
    public function findMentor($limit)
    {
        $users = $this->createQueryBuilder('u')
            ->join('u.progress', 'p')
            ->join('u.program', 'pr')
            ->andWhere("pr.mentor = 'More'")
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        return $users;
    }

    /**
     * Find student users
     *
     * @return User
     */
    public function findPeerMentors()
    {
        $users = $this->createQueryBuilder('u')
            ->join('u.progress', 'p')
            ->join('u.program', 'pr')
            ->andWhere("pr.mentor = 'More'")
            ->addOrderBy('pr.graddate', 'ASC')
            ->addOrderBy('pr.gradterm', 'DESC')
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->getQuery()
            ->getResult();
        return $users;
    }

    /**
     * Find student users
     *
     * @return User
     */
    public function findFaculty()
    {
        $users = $this->createQueryBuilder('u')
            ->join('u.progress', 'p')
            ->andWhere("u.progress = '15'")
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->getQuery()
            ->getResult();
        return $users;
    }

    /**
     * Find student users
     *
     * @return User
     */
    public function findDirector()
    {
        $users = $this->createQueryBuilder('u')
            ->join('u.progress', 'p')
            ->andWhere("u.progress = '16'")
            ->getQuery()
            ->getSingleResult();
        return $users;
    }

    /**
     * Find student users
     *
     * @return User
     */
    public function findAccounts()
    {
        $users = $this->createQueryBuilder('u')
            ->andWhere("u.lastname != '' and u.firstname != '' ")
            ->addOrderBy('u.lastname', 'ASC')
            ->addOrderBy('u.firstname', 'ASC')
            ->getQuery()
            ->getResult();
        return $users;
    }

    /**
     * find gradterm data
     *
     */
    public function findGraddateData() {
        $data = $this->createQueryBuilder('u')
            ->join('u.progress', 'p')
            ->join('u.program', 'pr')
            ->andWhere("p.name != 'Inactive' and p.name != 'Administration' and p.name != 'Faculty' and p.name != 'Graduated'  and p.name != 'Account Created'")
            ->select('u.graddate AS area', 'count(u.id) AS value')
            ->groupBy('u.graddate')
            ->getQuery()
            ->getResult();
        return $data;
    }

}
