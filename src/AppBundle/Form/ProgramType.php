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
            'placeholder'=>'81xxxxxxxx'),))
          ->add('level', 'text', array('label' => 'Grad or Undergrad','attr' => array('class' => 'form-control'),))
          ->add('level', 'choice', array(
            'choices'  => array(
              'Undergrad' => 'Undergrad',
              'Grad' => 'Grad'
            ),
              // *this line is important*
            'choices_as_values' => true,
            'expanded' => true,
          ))
          ->add('degree', 'text', array('label' => 'Previous degree(s)','attr' => array('class' => 'form-control'),))
          ->add('institution', 'text', array('label' => 'Previous Institution(s)','attr' => array('class' => 'form-control'),))
          ->add('graddate', 'text', array('label' => 'Expected Graduation Date','attr' => array('class' => 'form-control'),))
          ->add('address', 'text', array('label' => 'Street','attr' => array('class' => 'form-control'),))
          ->add('cityst', 'text', array('label' => 'City, State, Zip','attr' => array('class' => 'form-control'),))
          ->add('country', 'text', array('label' => 'County','attr' => array('class' => 'form-control'),))
          ->add('phone', 'text', array('label' => 'Phone','attr' => array('class' => 'form-control'),))
          ->add('area', 'text', array('label' => 'Area of Interest','attr' => array('class' => 'form-control'),))
          ->add('area', 'choice', array(
            'label' => 'Area of Interest',
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
          ->add('interest', 'ckeditor', array('label' => 'Details on your interesting in Sustainability','config_name'
          =>
            'editor_simple',))
          ->add('experience', 'ckeditor', array('label' => 'Experience in Sustainability','config_name'
          =>
            'editor_simple',))
          ->add('goals', 'ckeditor', array('label' => 'What are your goals','config_name'
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
