<?php

namespace AppBundle\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('name', TextType::class, array('attr' => array('class' => 'text form-control', 'placeholder' => 'Name'),))
            ->add('prefix', TextType::class, array('required' => false,'attr' => array('class' => 'text form-control',), 'label' => 'Prefix',))
            ->add('crosslisting', TextType::class, array('required' => false,'attr' => array('class' => 'text form-control',), 'label' => 'Cross Listing',))
            ->add('coursenumber', TextType::class, array('required' => false,'attr' => array('class' => 'text form-control',),'label' => 'Course Number',))
            ->add('split', TextType::class, array('required' => false,'attr' => array('class' => 'text form-control',),'label' => 'Split-level Number',))
            ->add('post', TextType::class, array('required' => false,'attr' => array('class' => 'text form-control',),'label' => 'Postfix',))
            ->add('title', TextType::class, array('required' => false,'attr' => array('class' => 'text form-control', 'placeholder' => 'Title'),))
            ->add('offered', TextType::class, array('required' => false,'attr' => array('class' => 'text form-control', 'placeholder' => 'Offered'),))
            ->add('prereqs', TextType::class, array('required' => false, 'attr' => array('class' => 'text form-control',
              'placeholder' => 'Prereqs'),))
            ->add('school', EntityType::class, array('required' => true,'class' => 'AppBundle\Entity\School',
                'choice_label' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'School/College', 'attr' => array('class' =>
                    'form-control'),))
            ->add('pillar', ChoiceType::class, array('choices' => array('Anchor' => 'Anchor','Seminar' => 'Seminar','Social' => 'Social', 'Economic'
                 => 'Economic', 'Ecological' => 'Ecological', 'Capstone' => 'Capstone', 'Any' => 'Anchor or Any Pillar'),
                'required' =>  true,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Pillar',
                'attr' => array('class' => 'radio'),))
            ->add('level', ChoiceType::class, array('choices' => array('Grad' => 'Grad', 'Undergrad' => 'Undergrad', 'Split' => 'Split'), 'required' =>
                true,
                'expanded' => true, 'multiple' => false, 'label' => 'Level',
                'attr' => array('class' => 'radio'),))
            ->add('location', ChoiceType::class, array('choices' => array('Campus' => 'Campus', 'Abroad' => 'Abroad'), 'required' =>
                true,
                'expanded' => true, 'multiple' => false, 'label' => 'Location',
                'attr' => array('class' => 'radio'),))
            ->add('status', ChoiceType::class, array('choices' => array('pending' => 'pending', 'approved' => 'approved','denied' => 'denied','substitution' => 'substitution'),
             'required' =>true,
            'expanded' => true, 'multiple' => false, 'label' => 'Status',
            'attr' => array('class' => 'radio'),))
            ->add('description', CKEditorType::class, array('config_name' => 'editor_default',))
            ->add('syllabus', CKEditorType::class, array('config_name' => 'editor_default',))
            ->add('notes', CKEditorType::class, array('config_name' => 'editor_default',))
            ->add('contact', TextType::class, array('required' =>false, 'attr' => array('label' => 'Contact', 'class' => 'text
            form-control'),))
            ->add('contact_email', TextType::class, array('required' =>false, 'attr' => array('label' => 'Contact Email', 'class' => 'text
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
