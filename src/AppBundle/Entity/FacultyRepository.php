<?php

namespace AppBundle\Entity;

/**
 * FacultyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FacultyRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Find faculty
     *
     * @return Faculty
     */
    public function findAllSorted($status)
    {
        if ($status == 'mentor') {
            $faculty = $this->createQueryBuilder('f')
                ->andWhere('f.mentor = :mentor')
                ->addOrderBy('f.lastname')
                ->setParameter('mentor', 'yes')
                ->getQuery()
                ->getResult();
            return $faculty;
        }
        elseif ($status != 'all') {
            $faculty = $this->createQueryBuilder('f')
                ->andWhere('f.status = :status')
                ->addOrderBy('f.lastname')
                ->setParameter('status', $status)
                ->getQuery()
                ->getResult();
            return $faculty;
        }
        else {
            $faculty = $this->createQueryBuilder('f')
                ->addOrderBy('f.lastname')
                ->getQuery()
                ->getResult();
            return $faculty;
        }

    }

    /**
     * Find faculty
     *
     * @return Faculty
     */
    public function findByEmail($email)
    {
            $faculty = $this->createQueryBuilder('f')
                ->andWhere('f.email = :email')
                ->addOrderBy('f.lastname')
                ->setParameter('email', $email)
                ->getQuery()
                ->getOneOrNullResult();
            return $faculty;

    }
}
