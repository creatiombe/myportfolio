<?php
namespace AppBundle\Form\Type;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class ImagePreviewType extends AbstractType implements ContainerAwareInterface
{
    protected $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function getName()
    {
        return 'imagepreview';
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $data = $form->getParent()->getData();

        $imageThumb = "";
        $imageSrc = "";
        if($data && $data->getImageName()) {
            $cacheManager = $this->container->get('liip_imagine.cache.manager');

            $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
            $imageSrc = $helper->asset($data, 'imageFile');

            $imageThumb = $cacheManager->getBrowserPath($imageSrc, 'preview_thumb');
        }
        $view->vars['imageSrc'] = $imageSrc;
        $view->vars['imageThumb'] = $imageThumb;

    }
}