<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\EventListener;

use Extra\QuestionnaireBundle\Entity\Questionnaire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Choice;

/**
 * Class AddFieldsSubscriber
 * @author Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */
class DynamicQuestionnaireFieldsSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();

        /* @var $questionnaire \Extra\QuestionnaireBundle\Entity\Questionnaire */
        $questionnaire = $this->entityManager->getRepository(Questionnaire::class)->getFirstActive();

        if ($questionnaire) {
            /* @var $question \Extra\QuestionnaireBundle\Entity\Question */
            foreach ($questionnaire->getQuestions() as $question) {
                $questionTr = $question->getCurrentTranslation();
                if ($questionTr) {
                    $title = $questionTr->getTitle();

                    /* @var $answers \Extra\QuestionnaireBundle\Entity\Answer[] */
                    $answers = $question->getAnswers();

                    /* @var $answer \Extra\QuestionnaireBundle\Entity\Answer */
                    $answerChoices = [];
                    foreach ($answers as $answer) {
                        $answerTr = $answer->getCurrentTranslation();
                        if ($answerTr) {
                            $answerTitle                 = $answer->getTitle();
                            $answerChoices[$answerTitle] = $answer->getSlug();
                            $contraintChoices[] = $answer->getSlug();
                        }
                    }
                    $form->add($question->getSlug(), ChoiceType::class, [
                        'label'          => $title,
                        'label_attr' => [ 'class' => 'question' ],
                        'required'       => true,
                        'choices'        => $answerChoices,
                        'multiple'       => false,
                        'expanded'       => true,
                        'constraints'    => [
                            new NotBlank(),
                            new Choice($contraintChoices)
                        ],
                        'attr'           => ['class' => 'formRow']
                    ]);
                }
            }
        }
    }
}
