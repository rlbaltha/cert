<?php

namespace AppBundle\Entity;

/**
 * QuestionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * find default answerset for text question creation
     *
     * @return Question
     */
    public function findQuestions($questionsetid) {

        $questions = $this->createQueryBuilder('q')
            ->join('q.questionset','s')
            ->andWhere('s.id = :id')
            ->setParameter('id', $questionsetid)
            ->getQuery()
            ->getResult();
        return $questions;
    }
}
