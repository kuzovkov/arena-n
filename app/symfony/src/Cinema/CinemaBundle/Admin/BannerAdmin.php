<?php
namespace Cinema\CinemaBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
 
class BannerAdmin extends Admin
{
    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'id'
    );
    
 
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        $formMapper
            ->add('name', 'text', array( 'label' => 'Название', 'required' => true ))
            ->add('bannershow', null, array( 'label' => 'Показывать', 'required' => false ))
            ->add('banner_url', null, array( 'label' => 'Ссылка', 'required' => false ))
            ->add('imgfilename', 'file', array('label' => 'Загрузить файл', 'required'=>false, 'data_class'=>null))
        ;
    }
 
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array( 'label' => 'Название', 'required' => true ))
        ;
    }
 
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
             ->addIdentifier('name', 'text', array( 'label' => 'Название', 'required' => true ))
            ->add('bannershow', null, array( 'label' => 'Показывать', 'required' => false ))
            ->add('banner_url', null, array( 'label' => 'Ссылка', 'required' => false ))
            ->add('imgfilename', null, array('label' => 'Имя файла', 'required'=>false, 'data_class'=>null))
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
            ->add('name', 'text', array( 'label' => 'Название', 'required' => true ))
            ->add('bannershow', null, array( 'label' => 'Показывать', 'required' => false ))
            ->add('banner_url', null, array( 'label' => 'Ссылка', 'required' => false ))
            ->add('imgfilename', null, array('label' => 'Имя файла', 'required'=>false, 'data_class'=>null))
        ;
    }
    
}