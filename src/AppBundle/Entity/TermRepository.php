<?php

namespace AppBundle\Entity;

/**
 * TermRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TermRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Find current term
     *
     * @return Term
     */
    public function findCurrent() {
        $current_term = $this->createQueryBuilder('t')
            ->andWhere('t.status = :status')
            ->setParameter('status','Current')
            ->getQuery()
            ->getSingleResult();
        return $current_term;
    }

    /**
     * Find default term
     *
     * @return Term
     */
    public function findDefault() {
        $current_term = $this->createQueryBuilder('t')
            ->andWhere('t.status = :status')
            ->setParameter('status','Default')
            ->getQuery()
            ->getSingleResult();
        return $current_term;
    }
}
