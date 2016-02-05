<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CourseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('attr' => array('class' => 'text form-control', 'placeholder' => 'Name'),))
            ->add('title', 'text', array('attr' => array('class' => 'text form-control', 'placeholder' => 'Title'),))
            ->add('offered', 'text', array('attr' => array('class' => 'text form-control', 'placeholder' => 'Offered'),))
            ->add('prereqs', 'text', array('attr' => array('class' => 'text form-control', 'placeholder' => 'Prereqs'),))
            ->add('instructor', 'text', array('attr' => array('class' => 'text form-control', 'placeholder' =>
                'Instructor'),))
            ->add('school', 'text', array('required' => false, 'attr' => array('class' => 'text form-control',
              'placeholder' => 'School'),))
            ->add('pillar', 'choice', array('choices' => array('Anchor' => 'Anchor','Social' => 'Social', 'Economoic'
                 => 'Economoic', 'Ecological' => 'Ecological'),
                'required' =>  true,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Pillar',
                'attr' => array('class' => 'radio'),))
            ->add('level', 'choice', array('choices' => array('Grad' => 'Grad', 'Undergrad' => 'Undergrad'), 'required' =>
                true,
                'expanded' => true, 'multiple' => false, 'label' => 'Level',
                'attr' => array('class' => 'radio'),))
            ->add('description', 'ckeditor', array('config_name' => 'editor_default',));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Course'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_course';
    }
}
