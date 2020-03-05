<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Route\RouteCollection;

class QuestionnaireAdmin extends Admin
{
    protected $translationDomain = 'ExtraQuestionnaireBundle';

    /**
     * @inheritdoc
     */
    protected $datagridValues = array(
        '_page'       => 1,
        '_sort_order' => 'ASC',
        '_sort_by'    => 'rank',
    );

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('order', 'order');
    }


    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General')
            ->add('slug', null, ['label' => 'form.slug'])
            ->add('active', null, ['label' => 'form.active'])
            ->add('questions', null, ['label' => 'form.questions'])
            ->add('translations', null, ['label' => 'form.translations'])
            ->add('createdAt', null, ['label' => 'form.created_at'])
            ->add('updatedAt', null, ['label' => 'form.updated_at'])
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('slug', null, ['label' => 'form.slug'])
            ->add('active', null, ['label' => 'form.active'])
            ->add('translations.title', null, ['label' => 'form.title']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('title', null, ['label' => 'form.title'])
            ->add('active', null,
                ['label' => 'form.active', 'editable' => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('active', null, ['label' => 'form.active'])
            ->add('translations', TranslationsType::class, [
                'by_reference'       => false,
                'fields'             => [
                    'title' => [
                        'field_type' => TextType::class,
                        'label'      => 'form.title',
                    ],
                ],
                'excluded_fields'    => [
                    'created_at',
                    'update_at'
                ],
                'translation_domain' => 'ExtraQuestionnaireBundle',
                'label'              => 'form.translations',
            ])
            ->add('questions', CollectionType::class,
                [
                    'label'        => 'form.questions',
                    'by_reference' => false
                ],
                [
                    'edit'         => 'inline',
                    'inline'       => 'table',
                    'sortable'     => 'position',
                    'allow_add'    => true,
                    'allow_delete' => true
                ]);
    }
}
