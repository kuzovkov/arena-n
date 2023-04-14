<?php
namespace Cinema\CinemaBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
 
class PageAdmin extends Admin
{
    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'title'
    );
    
 
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        $formMapper
            ->add('title', 'text', array( 'label' => 'Заголовок', 'required' => true ))
            ->add('content', 'textarea', array( 'label' => 'Контент', 'required' => false ))
            ->add('htmlTitle', 'text',array('required' => false))
            ->add('metaKeywords', 'text',array('required' => false))
            ->add('metaDescription', 'text',array('required' => false))
            ->add('type', 'choice',array('required' => true, 'label' => 'Тип', 
                                                'choices'=>array
                                                (
                                                    'CINEMA' => 'Кинотеатр',
                                                    'RETROBAR' => 'Ретро-Бар'
                                                )))
            ->add('slug', 'text')
            
        ;
    }
 
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, array('label'=>'Заголовок'))
            ->add('content',null, array('label'=>'Контент'))
            ->add('htmlTitle')
            ->add('metaKeywords')
            ->add('metaDescription')
            ->add('slug')
        ;
    }
 
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title','text', array( 'label' => 'Заголовок' ))
            ->add('content','html', array( 'label' => 'Контент', 'required' => false ))
            ->add('htmlTitle', 'text')
            ->add('metaKeywords', 'text')
            ->add('metaDescription', 'text')
            ->add('type', 'choice',array('required' => true, 'label' => 'Тип', 
                                                'choices'=>array
                                                (
                                                    'CINEMA' => 'Кинотеатр',
                                                    'RETROBAR' => 'Ретро-Бар'
                                                )))
            ->add('slug', 'text')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CinemaCinemaBundle:CRUD:list__action_view.html.twig'),
                    'edit' => array('template' => 'CinemaCinemaBundle:CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CinemaCinemaBundle:CRUD:list__action_delete.html.twig'),
                )
            ))
        ;
    }
    
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title','text', array( 'label' => 'Заголовок' ))
            ->add('content','textarea', array( 'label' => 'Контент', 'required' => false ))
            ->add('htmlTitle', 'text')
            ->add('metaKeywords', 'text')
            ->add('metaDescription', 'text')
            ->add('type', 'text')
            ->add('slug', 'text')
        ;
    }
    
    
    
}