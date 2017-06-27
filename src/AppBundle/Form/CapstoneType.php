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
                        'Independent/Group Project' => 'Independent/Group Project',
                    ),
                    // *this line is important*
                    'choices_as_values' => true,
                    'label' => 'Type of Project',
                    'attr' => array('class' => 'text form-control', 'placeholder' => 'Title'),
                )
            )
            ->add('tags', 'entity', array('class' => 'AppBundle\Entity\Tag',
                'property' => 'title', 'expanded' => true, 'multiple' => true, 'label' => 'Tags: Please select as many as are appropriate (limit 5)', 'attr' => array('class' =>
                    'checkbox'),))
            ->add(
                'description',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Project Description:  What will you do and how does the project relate to all three spheres of sustainability?',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'mentor',
                'text',
                array(
                    'required' => false,
                    'label' => 'Campus/Community mentor',
                    'attr' => array('class' => 'text form-control'),
                )
            )
            ->add(
                'mentor_email',
                'text',
                array(
                    'required' => false,
                    'label' => 'Mentor email',
                    'attr' => array('class' => 'text form-control'),
                )
            )
            ->add(
                'mentor_expectations',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Mentor Involvement: Outline the nature and amount of invovlement in your project you expect from your mentor?',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'group_project',
                'choice',
                array(
                    'choices' => array(
                        'Yes' => 'Yes',
                        'No' => 'No',
                    ),
                    // *this line is important*
                    'choices_as_values' => true,
                    'label' => 'Are you working in a group?',
                    'attr' => array('class' => 'text form-control'),
                )
            )
            ->add(
                'group_members',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'If so, please list your group members and describe your role on the team.',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'partners',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Resources and Project Partners: What and who will help you complete your project and achieve your goals? ',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'funding',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Funding:  Will you need funding to purchase materials? If so, what is your estimated budget? What are your funding sources?',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'objectives',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Project Goals: What are at least 3 long-term, concrete goals? Project goals should be Specific, Measurable, Attainable, Relevant, and Timely (SMART).',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'personal_objectives',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Personal Objectives:  What are the job skills, experience, and knowledge that you hope to gain in the course of your project?
',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'success_metrics',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Success Metrics: How will you know that your project was a success? What qualitative/quantitative metrics will you use to demonstrate this?',
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
                'timeframe',
                'text',
                array(
                    'required' => false,
                    'label' => 'Expected completion date',
                    'attr' => array('class' => 'text form-control'),
                )
            )
            ->add(
                'completion',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Completion: At the end of this semester, will your project be complete or will it have future needs? What future needs should be addressed? 
                        Will the project require upkeep? If so, who will maintain it? 
                        If the project will be complete, how will it be wrapped up and documented?
                        ',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'repeatable',
                'choice',
                array(
                    'choices' => array(
                        'Yes' => 'Yes',
                        'No' => 'No',
                    ),
                    // *this line is important*
                    'choices_as_values' => true,
                    'label' => 'Could your project be extended or repeated by a student in the future?',
                    'attr' => array('class' => 'text form-control'),
                )
            )
        ;
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
