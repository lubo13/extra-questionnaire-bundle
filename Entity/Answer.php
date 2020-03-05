<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;

/**
 * Answer
 *
 * @ORM\Table(name="answers")
 * @ORM\Entity(repositoryClass="Extra\QuestionnaireBundle\Repository\AnswerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Answer implements AnswerInterface
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
     * @var \Extra\QuestionnaireBundle\Entity\Question
     * @ORM\ManyToOne(targetEntity="\Extra\QuestionnaireBundle\Entity\Question", inversedBy="answers" )
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;

    /**
     * @var \Extra\QuestionnaireBundle\Entity\AnswerTranslation
     * @ORM\OneToMany(targetEntity="\Extra\QuestionnaireBundle\Entity\AnswerTranslation", mappedBy="translatable", cascade={"persist", "remove"}, indexBy="locale")
     */
    private $translations;

    /**
     * Answer constructor.
     */
    public function __construct()
    {
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
     * @return \Extra\QuestionnaireBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param \Extra\QuestionnaireBundle\Entity\Question $question
     */
    public function setQuestion(Question $question)
    {
        $this->question = $question;
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
