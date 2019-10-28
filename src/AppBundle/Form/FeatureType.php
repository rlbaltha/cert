<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class FeatureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('required' => false, 'attr' => array('class' => 'text form-control'),))
            ->add('body', CkeditorType::class, array('config_name' => 'editor_page',))
            ->add('image', TextType::class, array('required' => false, 'label'=>'Image (2000 x 750 px)', 'attr' => array('class' => 'text form-control'),))
            ->add('url', TextType::class, array('required' => false, 'attr' => array('class' => 'text form-control'),))
            ->add('position', TextType::class, array('attr' => array('class' => 'text form-control'),))
            ->add('type', ChoiceType::class, array(
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
