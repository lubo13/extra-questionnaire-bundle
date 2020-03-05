<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Form;

use Extra\QuestionnaireBundle\Entity\CompletedQuestionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;
use Extra\QuestionnaireBundle\EventListener\DynamicQuestionnaireFieldsSubscriber;
use Extra\QuestionnaireBundle\Form\DataMapper\QuestionnaireMapper;

class QuestionnaireType extends AbstractType
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \Extra\QuestionnaireBundle\EventListener\DynamicQuestionnaireFieldsSubscriber
     */
    protected $dynamicQuestionnaireFieldsSubscriber;

    /**
     * @var \Extra\QuestionnaireBundle\Form\DataMapper\QuestionnaireMapper
     */
    protected $questionnaireMapper;

    public function __construct(
        EntityManagerInterface $entityManager,
        DynamicQuestionnaireFieldsSubscriber $dynamicQuestionnaireFieldsSubscriber,
        QuestionnaireMapper $questionnaireMapper
    ) {
        $this->entityManager                        = $entityManager;
        $this->dynamicQuestionnaireFieldsSubscriber = $dynamicQuestionnaireFieldsSubscriber;
        $this->questionnaireMapper                  = $questionnaireMapper;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber($this->dynamicQuestionnaireFieldsSubscriber);
        $builder->setDataMapper($this->questionnaireMapper);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CompletedQuestionnaire::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'extra_questionnaire_questionnaire';
    }
}
