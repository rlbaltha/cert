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
          ->add('title', 'text', array('label' => 'Project Title', 'attr' => array('class' => 'text form-control'),))
          ->add(
            'type',
            'choice',
            array(
              'choices' => array(
                'Research' => 'Research',
                'Internship' => 'Internship',
                'Other' => 'Other',
              ),
                // *this line is important*
              'choices_as_values' => true,
              'label' => 'Type of Project',
              'attr' => array('class' => 'text form-control', 'placeholder' => 'Title'),
            )
          )
          ->add(
            'description',
            'ckeditor',
            array(
              'required' => false,
              'label' => 'Project Description:  What will you do and how does the project relate to sustainability?',
              'config_name' => 'editor_simple',
            )
          )
          ->add(
            'goals',
            'ckeditor',
            array(
              'required' => false,
              'label' => 'Project Goals for the semester:  What is your
          concrete and measureable long term goal?  Project goals should be specific, measureable, attainable,
          relevant, and timely.',
              'config_name' => 'editor_simple',
            )
          )
          ->add(
            'objectives',
            'ckeditor',
            array(
              'required' => false,
              'label' => 'Key Objectives:  What are 3 objectives that
          you will accomplish as you work towards achieving your overall goal?',
              'config_name' => 'editor_simple',
            )
          )
          ->add(
            'timeline',
            'ckeditor',
            array(
              'required' => false,
              'label' => 'Timeline:  Break down your project into
          smaller segments.   What do you plan to accomplish in the first weeks, the first half of the term, etc.?',
              'config_name' => 'editor_simple',
            )
          )
          ->add(
            'partners',
            'ckeditor',
            array(
              'required' => false,
              'label' => 'Resources and Project Partners: What and who
          will help you complete your project and achieve your goals?',
              'config_name' => 'editor_simple',
            )
          )
          ->add(
            'personal_objectives',
            'ckeditor',
            array(
              'required' => false,
              'label' => 'Personal Objectives:  What are the job skills,
          experience, and knowledge that you hope to gain in the course of your project?',
              'config_name' => 'editor_simple',
            )
          )
          ->add(
            'success_metrics',
            'ckeditor',
            array(
              'required' => false,
              'label' => 'Success Metrics:  How will you know that your project was
           a success?  What are the metrics you will use to decide whether you accomplished your goals?',
              'config_name' => 'editor_simple',
            )
          )
          ->add(
            'steps',
            'ckeditor',
            array(
              'required' => false,
              'label' => 'What are the specific steps you will take to complete your capstone project?',
              'config_name' => 'editor_simple',
            )
          )
          ->add(
            'application',
            'ckeditor',
            array(
              'required' => false,
              'label' => 'How will this project apply to and extend your course of study?',
              'config_name' => 'editor_simple',
            )
          )
          ->add(
            'mentor',
            'text',
            array(
              'required' => false,
              'label' => 'Faculty/Community mentor',
              'attr' => array('class' => 'text form-control'),
            )
          )
          ->add(
            'timeframe',
            'text',
            array(
              'required' => false,
              'label' => 'Projected completion date',
              'attr' => array('class' => 'text form-control'),
            )
          );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
          array(
            'data_class' => 'AppBundle\Entity\Capstone',
          )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_capstone';
    }
}
