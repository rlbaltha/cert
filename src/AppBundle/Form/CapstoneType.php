<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CapstoneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label'=>'Project Title', 'attr' => array('class' => 'text form-control'),))
            ->add('type', 'choice', array(
                'choices'  => array(
                    'Research' => 'Research',
                    'Internship' => 'Internship',
                    'Other' => 'Other',
                ),
                // *this line is important*
                'choices_as_values' => true,
                'label'=>'Type of Project', 'attr' => array('class' => 'text form-control', 'placeholder' => 'Title'),))
            ->add('description', 'ckeditor', array('required'=> false,'label'=>'Please give a brief description of your project, including its main goals and objectives and how they relate to sustainability:', 'config_name' => 'editor_simple',))
            ->add('steps', 'ckeditor', array('required'=> false,'label'=>'What are the specific steps you will take to complete your capstone project?', 'config_name' => 'editor_simple',))
            ->add('application', 'ckeditor', array('required'=> false,'label'=>'How will this project apply to and extend your course of study?', 'config_name' => 'editor_simple',))
            ->add('mentor', 'text', array('required'=> false,'label'=>'Faculty/Community mentor', 'attr' => array('class' => 'text form-control'),))
            ->add('timeframe', 'text', array('required'=> false,'label'=>'Projected completion date', 'attr' => array('class' => 'text form-control'),))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Capstone'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_capstone';
    }
}
