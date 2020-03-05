<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Controller;

use Extra\QuestionnaireBundle\Form\QuestionnaireType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Extra\QuestionnaireBundle\Utills\Questionnaire;

/**
 * Class QuestionnaireController
 * @author Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */
class QuestionnaireController extends AbstractController
{
    /**
     * @Route("/questionnaire", name="extra_questionnaire", defaults={"_locale"="en"}, options = { "expose" = true })
     *
     * @param \Symfony\Component\HttpFoundation\Request       $request
     * @param \Extra\QuestionnaireBundle\Utills\Questionnaire $questionnaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function questionnaireAction(Request $request, Questionnaire $questionnaire)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToRoute('homepage');
        }

        $form = $this->createForm(QuestionnaireType::class);

        if ($request->request->has('extra_questionnairebundle_questionnaire')) {
            $form->submit($request->request->get('extra_questionnairebundle_questionnaire'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $questionnaire->saveCompletedQuestionnaire($form->getData());

            $questionnaire->sendMail($form->getData());

            $this->addFlash('success_questionnaire', 'submit_questionnaire_successfully');
            return $this->redirect($request->getUri() . '#formQuestionnaire');
        }

        return $this->render('@ExtraQuestionnaire/Form/questionnaire.html.twig',
            ['form' => $form->createView()]
        );
    }
}
