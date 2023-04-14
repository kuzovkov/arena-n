<?php
namespace Cinema\CinemaBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
 
class SnipetAdmin extends Admin
{
    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'id'
    );
    
 
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        $formMapper
            ->add('key', null, array( 'label' => 'Ключ', 'required' => true ))
            ->add('desc', null, array( 'label' => 'Описание', 'required' => false ))
            ->add('snipet', 'textarea', array( 'label' => 'Текст', 'required' => false ))
        ;
    }
 
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('key', null, array( 'label' => 'Ключ', 'required' => true ))
        ;
    }
 
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
             ->addIdentifier('key', null, array( 'label' => 'Название', 'required' => true ))
            ->add('desc', null, array( 'label' => 'Описание', 'required' => false ))
            ->add('snipet', 'text', array( 'label' => 'Текст', 'required' => false ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }
    
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('key', null, array( 'label' => 'Ключ', 'required' => true ))
            ->add('desc', null, array( 'label' => 'Описание', 'required' => false ))
            ->add('snipet', 'textarea', array( 'label' => 'Текст', 'required' => false ))
        ;
    }
    
}