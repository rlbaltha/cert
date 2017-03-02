<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ForumType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('attr' => array('class' => 'text form-control'),))
            ->add('body', 'ckeditor', array('config_name' => 'editor_default',))
            ->add('parent', 'entity', array(
                'required'    => false,
                'empty_data'  => null,
                'class' => 'AppBundle:Forum',
                'choice_label' => 'title',
                'label' => 'Forum',
                'attr' => array('class' => 'form-control'),))
            ->add('network', 'choice', array(
                'attr' => array('class' => 'form-control'),
                'choices'  => array(
                    'Yes' => 0,
                    'No' => 1,
                ),
                // *this line is important*
                'choices_as_values' => true,))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Forum'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_forum';
    }
}
