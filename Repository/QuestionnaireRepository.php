<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * QuestionnaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionnaireRepository extends EntityRepository
{
    /**
     * @return \Extra\QuestionnaireBundle\Entity\Questionnaire|null
     */
    public function getFirstActive()
    {
        $qb = $this->createQueryBuilder('q');
        $qb->select('q', 'qu', 'a');
        $qb->leftJoin('q.questions', 'qu')
            ->leftJoin('qu.answers', 'a')
            ->where('q.active = :active')
            ->setParameter('active', true)
            ->add('orderBy', 'q.rank ASC, qu.id ASC, a.id ASC');
        $query = $qb->getQuery();

        return $query->getResult()[0] ?? null;
    }

}
