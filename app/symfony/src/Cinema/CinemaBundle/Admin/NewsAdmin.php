<?php
namespace Cinema\CinemaBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
 
class NewsAdmin extends Admin
{
    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'id'
    );
    
 
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        $formMapper
            ->add('title', 'text', array( 'label' => 'Заголовок', 'required' => true ))
            ->add('content', 'textarea', array( 'label' => 'Контент', 'required' => false ))
            ->add('img', 'file', array('label' => 'Картинка', 'required'=>false, 'data_class'=>null))
            ->add('type', 'choice',array('required' => true, 'label' => 'Тип', 
                                                'choices'=>array
                                                (
                                                    'CINEMA_NEWS' => 'Новости и акции кинотеатра',
                                                    'RB_NEWS' => 'Новости Ретро-Бара',
                                                    'RB_ACTION' =>'Акции Ретро-Бара',
                                                    'RB_ACTIVITY' => 'Мероприятия Ретро-Бара'
                                                )))
            ->add('user_id', 'hidden')
            
        ;
    }
 
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, array( 'label' => 'Заголовок', 'required' => true ))
            //->add('content', 'textarea', array( 'label' => 'Контент', 'required' => false ))
            //->add('img', 'text',array('required' => false))
            //->add('type', null,array('required' => false))
            //->add('user_id', null,array('required' => false))
        ;
    }
 
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, array( 'label' => 'Заголовок', 'required' => true ))
            ->add('content', 'html', array( 'label' => 'Контент', 'required' => false ))
            ->add('img', null,array('label' =>'Изображение'))
            ->add('type', 'choice',array('required' => true, 'label' => 'Тип', 
                                                'choices'=>array
                                                (
                                                    'CINEMA_NEWS' => 'Новости и акции кинотеатра',
                                                    'RB_NEWS' => 'Новости Ретро-Бара',
                                                    'RB_ACTION' =>'Акции Ретро-Бара',
                                                    'RB_ACTIVITY' => 'Мероприятия Ретро-Бара'
                                                )))
            ->add('user_id', null,array('label' => 'Опубликовал'))
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
            ->add('title', 'text', array( 'label' => 'Заголовок', 'required' => true ))
            ->add('content', 'textarea', array( 'label' => 'Контент', 'required' => false ))
            ->add('img', 'text',array('required' => false))
            ->add('type', 'choice',array('required' => false, 'label' => 'Тип'))
            ->add('user_id', null, array('label' => 'Опубликовал'))
        ;
    }
    
    public function prePersist($image) {
        $this->manageFileUpload($image);
        $sql = 'SET NAMES cp"1251"';
        $conn = $this->getEntityManager()->getConnection();
        $conn->executeQuery($sql);
        
    }

    public function preUpdate($image) {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload($image) {
        if ($image->getImg()) {
        }
    }

    
}