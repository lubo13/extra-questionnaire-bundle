<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;

/**
 * Question
 *
 * @ORM\Table(name="questions")
 * @ORM\Entity(repositoryClass="Extra\QuestionnaireBundle\Repository\QuestionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Question implements QuestionInterface
{
    use Translatable,
        Timestampable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=1500)
     */
    private $slug;

    /**
     * @var \Extra\QuestionnaireBundle\Entity\Answer|null
     * @ORM\OneToMany(targetEntity="\Extra\QuestionnaireBundle\Entity\Answer", mappedBy="question", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $answers;

    /**
     * @var \Extra\QuestionnaireBundle\Entity\Questionnaire
     * @ORM\ManyToOne(targetEntity="\Extra\QuestionnaireBundle\Entity\Questionnaire", inversedBy="questions")
     * @ORM\JoinColumn(name="questionnaire_id", referencedColumnName="id")
     */
    private $questionnaire;

    /**
     * @var \Extra\QuestionnaireBundle\Entity\QuestionsTranslation
     * @ORM\OneToMany(targetEntity="\Extra\QuestionnaireBundle\Entity\QuestionTranslation", mappedBy="translatable", cascade={"persist", "remove"}, indexBy="locale")
     */
    private $translations;

    /**
     * Questionnaire constructor.
     */
    public function __construct()
    {
        $this->answers      = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection|\Extra\QuestionnaireBundle\Entity\Answer[]
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param \Extra\QuestionnaireBundle\Entity\Answer $answer
     *
     * @return self
     */
    public function addAnswer(Answer $answer)
    {
        if (!$this->answers->contains($answer)) {
            $answer->setQuestion($this);
            $this->answers->add($answer);
        }

        return $this;
    }

    /**
     * @param \Extra\QuestionnaireBundle\Entity\Answer $question
     *
     * @return self
     */
    public function removeAnswer(Answer $answer)
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
        }

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection of \Extra\QuestionnaireBundle\Entity\Answer $questions
     */
    public function setAnswers(Collection $answers)
    {
        $this->answers = $answers;
    }

    public function clearAnswers()
    {
        $this->answers = new ArrayCollection();
    }

    /**
     * @return \Extra\QuestionnaireBundle\Entity\Questionnaire
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
    }

    /**
     * @param \Extra\QuestionnaireBundle\Entity\Questionnaire $questionnaire
     */
    public function setQuestionnaire(Questionnaire $questionnaire)
    {
        $this->questionnaire = $questionnaire;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function lifecycleSlug()
    {
        $date       = new \DateTime();
        $this->slug = mt_rand(1000000000, 9999999999) . $date->getTimestamp();
    }
}
