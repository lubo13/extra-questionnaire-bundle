<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Utills;

use Doctrine\ORM\EntityManagerInterface;
use Extra\QuestionnaireBundle\Entity\CompletedQuestionnaireInterface;
use ThirdPartyBundle\SettingsBundle\Manager\SettingsManager;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class Questionnaire
 * @author Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */
class Questionnaire
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \ThirdPartyBundle\SettingsBundle\Manager
     */
    protected $settingManager;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    protected $engine;

    /**
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    protected $translator;

    /**
     * Questionnaire constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        SettingsManager $settingManager,
        \Swift_Mailer $mailer,
        EngineInterface $engine,
        TranslatorInterface $translator
    ) {
        $this->entityManager  = $entityManager;
        $this->settingManager = $settingManager;
        $this->mailer         = $mailer;
        $this->engine         = $engine;
        $this->translator     = $translator;
    }

    /**
     * @param \Extra\QuestionnaireBundle\Entity\CompletedQuestionnaireInterface $completedQuestionnaire
     *
     * @return void
     */
    public function saveCompletedQuestionnaire(CompletedQuestionnaireInterface $completedQuestionnaire)
    {
        $this->entityManager->persist($completedQuestionnaire);
        $this->entityManager->flush();
    }

    /**
     * @param \Extra\QuestionnaireBundle\Entity\CompletedQuestionnaireInterface $completedQuestionnaire
     */
    public function sendMail(CompletedQuestionnaireInterface $completedQuestionnaire)
    {
        $sendFrom = $this->settingManager->get('sender_email');
        $sendTo   = $this->settingManager->get('questionnaire_email');

        if ($sendTo) {
            $message = (new \Swift_Message())
                ->setSubject(
                    $this->translator->trans(
                        'questionnaire.mail.subject',
                        array(),
                        'ExtraQuestionnaireBundle'
                    )
                )
                ->setFrom($sendFrom)
                ->setTo($sendTo)
                ->setBody(
                    $this->engine->render(
                        'ExtraQuestionnaireBundle:Email:questionnaire_mail.html.twig',
                        array(
                            'data' => $completedQuestionnaire
                        )
                    ), 'text/html'
                );

            $this->mailer->send($message);
        }
    }
}
