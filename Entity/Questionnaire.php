<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;

/**
 * Questionnaire
 *
 * @ORM\Table(name="questionnaires")
 * @ORM\Entity(repositoryClass="Extra\QuestionnaireBundle\Repository\QuestionnaireRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Questionnaire implements QuestionnaireInterface
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
     * @var \Extra\QuestionnaireBundle\Entity\Question|null
     * @ORM\OneToMany(targetEntity="\Extra\QuestionnaireBundle\Entity\Question", mappedBy="questionnaire", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $questions;

    /**
     * @var \Extra\QuestionnaireBundle\Entity\QuestionnaireTranslation
     * @ORM\OneToMany(targetEntity="\Extra\QuestionnaireBundle\Entity\QuestionnaireTranslation", mappedBy="translatable", cascade={"persist", "remove"}, indexBy="locale")
     */
    private $translations;

    /**
     * @Gedmo\SortablePosition()
     * @ORM\Column(type="integer")
     */
    private $rank;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * Questionnaire constructor.
     */
    public function __construct()
    {
        $this->questions    = new ArrayCollection();
        $this->translations = new ArrayCollection();
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
     * Set slug.
     *
     * @param string $slug
     *
     * @return Questionnaire
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * @return \Doctrine\Common\Collections\Collection|\Extra\QuestionnaireBundle\Entity\Question[]
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param \Extra\QuestionnaireBundle\Entity\Question $question
     *
     * @return self
     */
    public function addQuestion(Question $question)
    {
        if (!$this->questions->contains($question)) {
            $question->setQuestionnaire($this);
            $this->questions->add($question);
        }

        return $this;
    }

    /**
     * @param \Extra\QuestionnaireBundle\Entity\Question $question
     *
     * @return self
     */
    public function removeQuestion(Question $question)
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
        }

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection of \Extra\QuestionnaireBundle\Entity\Question $questions
     */
    public function setQuestions(Collection $questions)
    {
        $this->questions = $questions;
    }

    public function clearQuestions()
    {
        $this->questions = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param mixed $position
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
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
