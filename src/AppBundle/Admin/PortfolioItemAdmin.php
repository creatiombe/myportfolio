<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PortfolioItemAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('description')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name')
            ->add('description')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Name, url and description', array('class' => 'col-md-6'))
                ->add('name')
                ->add('url')
                ->add('description', 'ckeditor', array('config_name' => 'basic'))
            ->end()
            ->with('Client and categories', array('class' => 'col-md-6'))
                ->add('client', 'sonata_type_model_list',
                    array(
                        'btn_add' => true,
                        'btn_delete' => false,
                        'attr' => array(
                            'style' => 'width:100%'
                        ),
                        'required' => true
                    ), array('sd' => false)
                )
                ->add('categories', 'sonata_type_model',
                    array(
                        'required' => false,
                        'multiple' => true,
                        'compound' => false,
                        'attr' => array(
                            'style' => 'width:100%'
                        )
                    )
                )
            ->end()
            ->with('Images', array('class' => 'col-md-12'))
                ->add('images', 'sonata_type_collection',
                    array(
                        'by_reference' => true,
                        'label' => false,
                        'cascade_validation' => true,
                        'required' => true
                    ),
                    array(
                        'allow_delete' => true,
                        'multiple' => true,
                        'expanded' => false,
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                        'help' => 'At least one image is required for a portfolio item',
                    )
                )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('description')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    public function preUpdate($portfolioItem)
    {
        $images = $portfolioItem->getImages();
        foreach($images as $image) {
            $image->setPortfolioItem($portfolioItem);
        }
        $portfolioItem->setImages($images);
    }

    public function prePersist($portfolioItem)
    {
        $images = $portfolioItem->getImages();
        foreach($images as $image) {
            $image->setPortfolioItem($portfolioItem);
        }
        $portfolioItem->setImages($images);
    }
}
