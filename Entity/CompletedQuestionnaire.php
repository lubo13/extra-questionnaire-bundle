<?php

namespace Extra\QuestionnaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompletedQuestionnaire
 *
 * @ORM\Table(name="completed_questionnaires")
 * @ORM\Entity(repositoryClass="Extra\QuestionnaireBundle\Repository\CompletedQuestionnaireRepository")
 */
class CompletedQuestionnaire implements CompletedQuestionnaireInterface
{
    use Timestampable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="userData", type="json_array")
     */
    private $userData;

    /**
     * @var array
     *
     * @ORM\Column(name="questionnaireData", type="json_array")
     */
    private $questionnaireData;


    public function __toString()
    {
        return $this->getQuestionnaireTitle() ?? '';
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userData.
     *
     * @param array $userData
     *
     * @return CompletedQuestionnaire
     */
    public function setUserData($userData)
    {
        $this->userData = $userData;

        return $this;
    }

    /**
     * Get userData.
     *
     * @return array
     */
    public function getUserData()
    {
        return $this->userData;
    }

    /**
     * Set questionnaireData.
     *
     * @param array $questionnaireData
     *
     * @return CompletedQuestionnaire
     */
    public function setQuestionnaireData($questionnaireData)
    {
        $this->questionnaireData = $questionnaireData;

        return $this;
    }

    /**
     * Get questionnaireData.
     *
     * @return array
     */
    public function getQuestionnaireData()
    {
        return $this->questionnaireData;
    }

    /**
     * Get questionnaireData.
     *
     * @return string
     */
    public function getQuestionnaireTitle()
    {
        return $this->questionnaireData['title'] ?? '';
    }
}
