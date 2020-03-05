<?php
/**
 * @package Extra_QuestionnaireBundle
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace Extra\QuestionnaireBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class CompletedQuestionnaireAdmin extends Admin
{
    protected $translationDomain = 'ExtraQuestionnaireBundle';

    /**
     * @inheritdoc
     */
    protected $datagridValues = array(
        '_page'       => 1,
        '_sort_order' => 'DESC',
        '_sort_by'    => 'id',
    );

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->remove('create');
        $collection->remove('edit');
        $collection->remove('delete');
    }


    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General')
            ->add('questionnaireData', null,
                [
                    'label'    => 'form.questionnaire_data',
                    'template' => 'ExtraQuestionnaireBundle:Admin:show_questionnaire_data.html.twig'
                ])
            ->add('createdAt', null, ['label' => 'form.created_at'])
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('questionnaireTitle', null, [
                'label' => 'form.title',
            ])
            ->add('createdAt', null, ['label' => 'form.created_at'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                ),
                'label'   => 'form.actions'
            ));
    }
}
