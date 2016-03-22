<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProgramType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

          ->add('school', 'text', array('label' => 'School/College','attr' => array('class' => 'form-control'),))
          ->add('program', 'text', array('label' => 'Major/Degree Program','attr' => array('class' => 'form-control'),))
          ->add('ugaid', 'text', array('label' => 'UGA ID ','attr' => array('class' => 'form-control',
            'placeholder'=>'811000000'),))
          ->add('level', 'choice', array(
            'choices'  => array(
              'Undergrad' => 'Undergrad',
              'Grad' => 'Grad'
            ),
              // *this line is important*
            'choices_as_values' => true,
            'expanded' => true,
          ))
          ->add('degree', 'text', array('required'=> false, 'label' => 'Previous degree(s)','attr' => array('class' =>
      'form-control'),))
          ->add('institution', 'text', array('required'=> false,'label' => 'Previous Institution(s)','attr' => array('class' => 'form-control'),))
          ->add('graddate', 'text', array('required'=> false,'label' => 'Expected Graduation Date','attr' => array('class' => 'form-control'),))
          ->add('address', 'text', array('required'=> false,'label' => 'Street','attr' => array('class' => 'form-control'),))
          ->add('cityst', 'text', array('required'=> false,'label' => 'City, State, Zip','attr' => array('class' => 'form-control'),))
          ->add('country', 'text', array('required'=> false,'label' => 'Country','attr' => array('class' =>
            'form-control'),))
          ->add('phone', 'text', array('required'=> false,'label' => 'Phone','attr' => array('class' => 'form-control'),))
          ->add('area', 'choice', array(
            'required'=> false,
              'multiple'=> true,
            'label' => 'Areas of Interest',
            'choices'  => array(
              'Energy' => 'Energy',
              'Water' => 'Water',
              'Transportation' => 'Transportation',
              'Food' => 'Food',
              'Waste' => 'Waste',
            ),
              // *this line is important*
            'choices_as_values' => true,
            'expanded' => true,
          ))
          ->add('interest', 'ckeditor', array('required'=> false,'label' => 'Details on your interest in Sustainability','config_name'
          =>
            'editor_simple',))
          ->add('experience', 'ckeditor', array('required'=> false,'label' => 'Experience in Sustainability','config_name'
          =>
            'editor_simple',))
          ->add('goals', 'ckeditor', array('required'=> false,'label' => 'What are your goals','config_name'
          =>
            'editor_simple',))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Program'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_program';
    }
}
