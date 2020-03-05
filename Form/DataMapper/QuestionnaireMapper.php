<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Form\DataMapper;

use Extra\QuestionnaireBundle\Entity\CompletedQuestionnaire;
use Extra\QuestionnaireBundle\Entity\Questionnaire;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class QuestionnaireMapper
 * @author Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */
class QuestionnaireMapper implements DataMapperInterface
{

    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $entityManager;


    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    ) {
        $this->requestStack  = $requestStack;
        $this->entityManager = $entityManager;
    }

    /**
     * @param mixed                                                $viewData
     * @param \Symfony\Component\Form\FormInterface[]|\Traversable $forms
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function mapDataToForms($viewData, $forms)
    {

        // there is no data yet, so nothing to prepopulate
        if (null === $viewData) {
            return;
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        /* @var $questionnaire \Extra\QuestionnaireBundle\Entity\Questionnaire */
        $questionnaire = $this->entityManager->getRepository(Questionnaire::class)->getFirstActive();

        $questionnaireData = $viewData->setQuestionnaireData();

        foreach ($questionnaireData['questions'] as $question) {
            foreach ($question['answers'] as $answer) {
                if ($answer['checked']) {
                    $forms[$question['slug']]->setData($answer['slug']);
                }
            }
        }
    }

    /**
     * @param \Symfony\Component\Form\FormInterface[]|\Traversable $forms
     * @param mixed                                                $viewData
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function mapFormsToData($forms, &$viewData)
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        $masterRequset            = $this->requestStack->getMasterRequest();
        $userData['base_url']     = $masterRequset->getBaseUrl();
        $userData['base_path']    = $masterRequset->getBasePath();
        $userData['query_string'] = $masterRequset->getQueryString();
        $userData['charsets']     = $masterRequset->getCharsets();
        $userData['locale']       = $masterRequset->getLocale();
        $userData['client_ip']    = $masterRequset->getClientIp();
        $userData['user_info']    = $masterRequset->getUserInfo();

        $viewData = new CompletedQuestionnaire();
        $viewData->setUserData($userData);


        /* @var $questionnaire \Extra\QuestionnaireBundle\Entity\Questionnaire */
        $questionnaire = $this->entityManager->getRepository(Questionnaire::class)->getFirstActive();

        $questionnaireData['slug'] = $questionnaire->getSlug();
        $questionnaireTr           = $questionnaire->getCurrentTranslation();
        if ($questionnaireTr) {
            $questionnaireData['title'] = $questionnaireTr->getTitle();
        }

        $questionnaireData['questions'] = [];
        /* @var $question \Extra\QuestionnaireBundle\Entity\Question */
        foreach ($questionnaire->getQuestions() as $question) {
            $questionTr = $question->getCurrentTranslation();
            if ($questionTr) {
                $questions          = [];
                $questions['slug']  = $question->getSlug();
                $questions['title'] = $questionTr->getTitle();

                /* @var $answer \Extra\QuestionnaireBundle\Entity\Asnswer */
                foreach ($question->getAnswers() as $answer) {
                    $answerTr = $answer->getCurrentTranslation();
                    if ($answerTr) {
                        $questionsAnswers            = [];
                        $questionsAnswers['slug']    = $answer->getSlug();
                        $questionsAnswers['title']   = $answerTr->getTitle();
                        $questionsAnswers['checked'] = false;

                        if (isset($forms[$questions['slug']]) && $forms[$questions['slug']]->getData() === $questionsAnswers['slug']) {
                            $questionsAnswers['checked'] = true;
                        }
                        $questions['answers'][] = $questionsAnswers;
                    }
                }
                $questionnaireData['questions'][] = $questions;
            }

        }
        $viewData->setQuestionnaireData($questionnaireData);
    }
}
