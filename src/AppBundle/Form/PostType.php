<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'choice', array(
                'required'=> true,
                'multiple'=> false,
                'label' => 'Category',
                'choices'  => array(
                    'New Student' => 'New Student',
                    'Continuing Student' => 'Continuing Student',
                    'Pre-Capstone' => 'Pre-Capstone',
                    'Capstone' => 'Capstone',
                    'Mentor' => 'Mentor',
                    'Director' => 'Director',
                ),
                // *this line is important*
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('title','text', array('attr' => array('class' => 'text form-control'),))
            ->add('email', 'ckeditor', array('label'  => 'Email','config_name' => 'editor_default',))
            ->add('body', 'ckeditor', array('label'  => 'Notification', 'config_name' => 'editor_default',))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_post';
    }
}
