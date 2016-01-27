<?php

namespace AppBundle\Admin;

use Liip\ImagineBundle\Controller\ImagineController;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;

class PortfolioImageAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('imageName')
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
            ->add('imageName')
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
        $imageName = "";
        if($this->getSubject()) {
            $imageName = $this->getSubject()->getImageName();
        }

        $fileFieldOptions = array('label'=>'Upload file');
        if ($imageName) {
            $container = $this->getConfigurationPool()->getContainer();
            $cacheManager = $container->get('liip_imagine.cache.manager');

            $helper = $container->get('vich_uploader.templating.helper.uploader_helper');
            $path = $helper->asset($this->getSubject(), 'imageFile');

            $srcPath = $cacheManager->getBrowserPath($path, 'preview_thumb');
            $fileFieldOptions['help'] = '<img src="'.$srcPath.'" class="admin-preview" />';
        }

        $formMapper
            ->add('imageName')
            ->add('imageFile', 'file', $fileFieldOptions)
            ->add('position', null, array('required' => false));
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('image')
            ->add('position')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
