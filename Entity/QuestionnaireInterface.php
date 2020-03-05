<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Entity;


/**
 * Interface QuestionnaireInterface
 * @package Extra\QuestionnaireBundle\Entity
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */
interface QuestionnaireInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getSlug();

    /**
     * @return \Extra\QuestionnaireBundle\Entity\Question[]
     */
    public function getQuestions();

    /**
     * @return \Extra\QuestionnaireBundle\Entity\QuestionnaireTranslation[]
     */
    public function getTranslations();

}
