<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Entity;


/**
 * Interface AnswerInterface
 * @package Extra\QuestionnaireBundle\Entity
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */
interface AnswerInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getSlug();

    /**
     * @return \Extra\QuestionnaireBundle\Entity\Question
     */
    public function getQuestion();

    /**
     * @return \Extra\QuestionnaireBundle\Entity\AnswerTranslation[]
     */
    public function getTranslations();
}
