<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Entity;


/**
 * Interface CompletedQuestionnaireInterface
 * @package Extra\QuestionnaireBundle\Entity
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */
interface CompletedQuestionnaireInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getUserData();

    /**
     * @return string
     */
    public function getQuestionnaireData();

}
