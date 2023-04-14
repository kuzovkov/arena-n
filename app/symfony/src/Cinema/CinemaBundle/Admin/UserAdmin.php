<?php
namespace Cinema\CinemaBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
 
class UserAdmin extends Admin
{
    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'username'
    );
 
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username', 'text', array('label'=>'Логин'))
            ->add('password', 'text', array('label'=>'Пароль'))
            ->add('email', 'text', array('label'=>'Email', 'required' => false))
            ->add('roles','choice', array( 'label'=>'Роли', 'multiple'=>true,
                                'choices'=>array
                                                (
                                                    'ROLE_SUPER_ADMIN' => 'СуперАдмин',
                                                    'ROLE_ADMIN' => 'Админ',
                                                    'ROLE_EDITOR' =>'Редактор',
                                                    'ROLE_VIEWER' => 'Читатель', 
                                                    'ROLE_USER' => 'Пользователь'
                                                )
                                            )
                 )
        ;
    }
 
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username',null,array('label'=>'Логин'))
            ->add('password',null,array('label'=>'Пароль'))
            ->add('email',null,array('label'=>'Email'))
            ->add('roles', null, array('label'=>'Роли'))
        ;
     
    }
 
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username', 'text', array('label'=>'Логин'))
            ->add('email', 'text', array('label'=>'Email', 'required' => false))
            ->add('roles', 'choice', array('label'=>'Роли', 'multiple'=>true, 'delimiter'=>',',
                                'choices' => array(
                                                    'ROLE_SUPER_ADMIN' => 'СуперАдмин',
                                                    'ROLE_ADMIN' => 'Админ',
                                                    'ROLE_EDITOR' =>'Редактор',
                                                    'ROLE_VIEWER' => 'Читатель', 
                                                    'ROLE_USER' => 'Пользователь')
                                                     ))
            
        ;
    }
    
}