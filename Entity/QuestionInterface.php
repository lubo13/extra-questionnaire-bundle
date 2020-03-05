<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Entity;


/**
 * Interface QuestionInterface
 * @package Extra\QuestionnaireBundle\Entity
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */
interface QuestionInterface
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
     * @return \Extra\QuestionnaireBundle\Entity\Aswer[]
     */
    public function getAnswers();

    /**
     * @return \Extra\QuestionnaireBundle\Entity\Questionnaire
     */
    public function getQuestionnaire();

    /**
     * @return \Extra\QuestionnaireBundle\Entity\QuestionTranslation[]
     */
    public function getTranslations();
}
