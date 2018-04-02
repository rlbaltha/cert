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
            ->add('cross', 'text', array('attr' => array('class' => 'text form-control',), 'label' => 'Cross Listing',))
            ->add('number', 'text', array('attr' => array('class' => 'text form-control',),'label' => 'Course Number',))
            ->add('split', 'text', array('attr' => array('class' => 'text form-control',),'label' => 'Split-level Number',))
            ->add('post', 'text', array('attr' => array('class' => 'text form-control',),'label' => 'Postfix',))
            ->add('title', 'text', array('attr' => array('class' => 'text form-control', 'placeholder' => 'Title'),))
            ->add('offered', 'text', array('attr' => array('class' => 'text form-control', 'placeholder' => 'Offered'),))
            ->add('prereqs', 'text', array('required' => false, 'attr' => array('class' => 'text form-control',
              'placeholder' => 'Prereqs'),))
            ->add('school', 'entity', array('required' => true,'class' => 'AppBundle\Entity\School',
                'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'School/College', 'attr' => array('class' =>
                    'form-control'),))
            ->add('pillar', 'choice', array('choices' => array('Anchor' => 'Anchor','Seminar' => 'Seminar','Social' => 'Social', 'Economic'
                 => 'Economic', 'Ecological' => 'Ecological', 'Capstone' => 'Capstone', 'Any' => 'Anchor or Any Pillar'),
                'required' =>  true,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Pillar',
                'attr' => array('class' => 'radio'),))
            ->add('level', 'choice', array('choices' => array('Grad' => 'Grad', 'Undergrad' => 'Undergrad', 'Split' => 'Split'), 'required' =>
                true,
                'expanded' => true, 'multiple' => false, 'label' => 'Level',
                'attr' => array('class' => 'radio'),))
            ->add('location', 'choice', array('choices' => array('Campus' => 'Campus', 'Abroad' => 'Abroad'), 'required' =>
                true,
                'expanded' => true, 'multiple' => false, 'label' => 'Location',
                'attr' => array('class' => 'radio'),))
            ->add('status', 'choice', array('choices' => array('pending' => 'pending', 'approved' => 'approved','denied' => 'denied',
              'exception' => 'exception'),
             'required' =>true,
            'expanded' => true, 'multiple' => false, 'label' => 'Status',
            'attr' => array('class' => 'radio'),))
            ->add('description', 'ckeditor', array('config_name' => 'editor_default',))
            ->add('syllabus', 'ckeditor', array('config_name' => 'editor_default',))
            ->add('notes', 'ckeditor', array('config_name' => 'editor_default',))
            ->add('contact', 'text', array('required' =>false, 'attr' => array('label' => 'Contact', 'class' => 'text
            form-control'),))
            ->add('contact_email', 'text', array('required' =>false, 'attr' => array('label' => 'Contact Email', 'class' => 'text
            form-control'),));
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
