<?php
namespace Cinema\CinemaBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
 
class FilmAdmin extends Admin
{
    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'date_first_arena'
    );
 
    public $entityname = 'film';
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        $formMapper
            ->add('url','text', array( 'label' => 'URL с кинопоиска', 'required' => false ))
            ->add('name', 'text', array( 'label' => 'Название', 'required' => false ))
            ->add('name_en', 'text', array( 'label' => 'Английское название', 'required' => false ))
            ->add('slug', 'text', array( 'label' => 'slug', 'required' => false ))
            ->add('country', 'text', array( 'label' => 'Страна', 'required' => false ))
            ->add('year', 'text', array( 'label' => 'Год', 'required' => false ))
            ->add('director', 'text', array( 'label' => 'Директор', 'required' => false ))
            ->add('genre', 'text', array( 'label' => 'Жанр', 'required' => false ))
            ->add('is3d',null, array('label'=>'3D фильм'))
            ->add('agelimit','text', array( 'label' => 'Ограничение по возрасту', 'required' => false ))
            ->add('duration', 'text', array('label' => 'Продолжительность', 'required' => false))
            ->add('date_first', 'date', array( 'label' => 'Начало показа', 'widget' => 'single_text', 'attr' => array('class' => 'datepicker'), 'required'=>false))
            ->add('date_last', 'date', array('label' => 'Окончание показа',  'widget' => 'single_text', 'attr' => array('class' => 'datepicker'), 'required' => false,))
            ->add('date_first_world', 'date', array('label' => 'Мировая премьера',  'widget' => 'single_text', 'attr' => array('class' => 'datepicker'), 'required' => false,))
            ->add('date_first_arena', 'date', array('label' => 'Премьера в Арена',  'widget' => 'single_text', 'attr' => array('class' => 'datepicker'), 'required' => false,))
            ->add('budget', 'text', array( 'label' => 'Бюджет', 'required' => false ))
            ->add('rating', 'text', array( 'label' => 'Рейтинг', 'required' => false ))
            ->add('trailer_link', 'text', array( 'label' => 'Ссылка на трейлер', 'required' => false ))
            ->add('poster_big','text', array( 'label' => 'Большой постер', 'required' => false ))
            ->add('wall_url','text', array( 'label' => 'URL обоев', 'required' => false ))
            ->add('onbackground',null, array('label'=>'Фон сайта'))
            ->add('poster_small','text', array( 'label' => 'Малый постер', 'required' => false ))
            ->add('description','textarea', array( 'label' => 'Описание', 'required' => false ))
            ->add('end_key','date', array('label'=>'Дата окончания ключа от фильма', 'widget' => 'single_text', 'attr' => array('class' => 'datepicker'), 'required' => false ))
            ->add('avail_key',null,array('label'=>'Ключ в наличии'))
            ->add('avail_film',null, array('label'=>'Фильм в наличии'))
        ;
    }
 
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        
        $datagridMapper
            ->add('name',null,array('label'=>'Название'))
            ->add('name_en', null, array( 'label' => 'Английское название', 'required' => false ))
            //->add('country',null,array('label'=>'Страна'))
            //->add('year',null,array('label'=>'Год'))
            //->add('director',null,array('label'=>'Режиссер'))
            //->add('genre',null,array('label'=>'Жанр'))
            ->add('is3d',null,array('label'=>'3D фильм'))
            ->add('agelimit',null,array('label'=>'Ограничение по возрасту'))
            //->add('poster_big',null,array('label'=>'Большой постер'))
            //->add('poster_small',null,array('label'=>'Малый постер'))
            //->add('url',null,array('label'=>'URL'))
            //->add('description',null,array('label'=>'Описание'))
            ->add('duration', null, array('label' => 'Продолжительность', 'required' => false))
            ->add('date_first', 'doctrine_orm_date', array('label' => 'Начало показа', 'attr' => array('class' => 'datepicker'), 'required' => false ), null, array('widget' => 'single_text'))
            //->add('date_last', null, array('label' => 'Окончание показа', 'required' => false))
        ;
    }
 
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name','text', array( 'label' => 'Название' ))
            //->add('name_en', 'text', array( 'label' => 'Английское название', 'required' => false ))
            //->add('country','text', array( 'label' => 'Страна' ))
            //->add('year','text', array( 'label' => 'Год' ))
            //->add('director','text', array( 'label' => 'Директор' ))
            ->add('genre','text', array( 'label' => 'Жанр' ))
            ->add('duration','text', array( 'label' => 'Длительность' ))
            ->add('date_first_arena','date', array('label' => 'Премьера в Арена'))
            ->add('is3d', 'boolean', array('label'=> '3D фильм'))
            ->add('agelimit','text', array( 'label' => 'Ограничение по возрасту' ))
            ->add('onbackground',null, array('label'=>'Фон сайта'))
            //->add('poster_big','text', array( 'label' => 'Большой постер' ))
            //->add('poster_small','text', array( 'label' => 'Малый постер' ))
            //->add('url','text', array( 'label' => 'URL с кинопоиска' ))
            //->add('description','text', array( 'label' => 'Описание' ))
            ->add('end_key','date', array('label'=>'Дата окончания ключа от фильма', 'widget' => 'single_text', 'attr' => array('class' => 'datepicker'), 'required' => false ))
            ->add('avail_key',null,array('label'=>'Ключ в наличии'))
            ->add('avail_film',null, array('label'=>'Фильм в наличии'))
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
            ->add('name','text', array( 'label' => 'Название' ))
            ->add('name_en', 'text', array( 'label' => 'Английское название', 'required' => false ))
            ->add('slug', 'text', array( 'label' => 'slug'))
            ->add('country','text', array( 'label' => 'Страна' ))
            ->add('year','text', array( 'label' => 'Год' ))
            ->add('director','text', array( 'label' => 'Директор' ))
            ->add('genre','text', array( 'label' => 'Жанр' ))
            ->add('is3d', 'boolean', array('label'=> '3D фильм'))
            ->add('agelimit','text', array( 'label' => 'Ограничение по возрасту' ))
            ->add('duration', 'text', array('label' => 'Продолжительность', 'required' => false))
            ->add('date_first', 'date', array('label' => 'Начало показа', 'required' => false))
            ->add('date_last', 'date', array('label' => 'Окончание показа', 'required' => false))
            ->add('date_first_world', 'date', array('label' => 'Мировая премьера',  'widget' => 'single_text', 'attr' => array('class' => 'datepicker'), 'required' => false,))
            ->add('date_first_arena', 'date', array('label' => 'Премьера в Арена',  'widget' => 'single_text', 'attr' => array('class' => 'datepicker'), 'required' => false,))
            ->add('budget', 'text', array( 'label' => 'Бюджет', 'required' => false ))
            ->add('rating', 'text', array( 'label' => 'Рейтинг', 'required' => false ))
            ->add('trailer_link', 'text', array( 'label' => 'Ссылка на трейлер', 'required' => false ))
            ->add('poster_big','text', array( 'label' => 'Большой постер' ))
            ->add('wall_url','text', array( 'label' => 'URL обоев', 'required' => false ))
            ->add('onbackground',null, array('label'=>'Фон сайта'))
            ->add('poster_small','text', array( 'label' => 'Малый постер' ))
            ->add('url','text', array( 'label' => 'URL с кинопоиска' ))
            ->add('description','html', array( 'label' => 'Описание' ))
            ->add('end_key','date', array('label'=>'Дата окончания ключа от фильма', 'widget' => 'single_text', 'attr' => array('class' => 'datepicker'), 'required' => false ))
            ->add('avail_key',null,array('label'=>'Ключ в наличии'))
            ->add('avail_film',null, array('label'=>'Фильм в наличии'))
    
        ;
    }
}