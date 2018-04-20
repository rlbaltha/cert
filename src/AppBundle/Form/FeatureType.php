<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeatureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('required' => false, 'attr' => array('class' => 'text form-control'),))
            ->add('body', 'ckeditor', array('config_name' => 'editor_page',))
            ->add('image', 'text', array('required' => false, 'label'=>'Image (2000 x 750 px)', 'attr' => array('class' => 'text form-control'),))
            ->add('url', 'text', array('required' => false, 'attr' => array('class' => 'text form-control'),))
            ->add('position', 'text', array('attr' => array('class' => 'text form-control'),))
            ->add('type', 'choice', array(
                'choices'  => array(
                    'carousel' => 'carousel',
                    'column' => 'column',
                    'feature' => 'feature',
                    'archive' => 'archive',
                ),
                // *this line is important*
                'choices_as_values' => true,
                'attr' => array('class' => 'form-control'),
            ));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Feature'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_feature';
    }
}
