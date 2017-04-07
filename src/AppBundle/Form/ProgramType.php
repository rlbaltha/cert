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
//            ->add('school', 'choice', array(
//                'required' => true,
//                'multiple' => false,
//                'label' => 'School/College',
//                'choices' => array(
//                    'Franklin' => 'Franklin',
//                    'CAES' => 'CAES',
//                    'Terry' => 'Terry',
//                    'Ecology' => 'Ecology',
//                    'Engineering' => 'Engineering',
//                    'CE+D' => 'CE+D',
//                    'FACS' => 'FACS',
//                    'Warnell' => 'Warnell',
//                    'Social Work' => 'Social Work',
//                    'Grady' => 'Grady',
//                    'SPIA' => 'SPIA',
//                    'Public Health' => 'Public Health',
//                ),
//                // *this line is important*
//                'choices_as_values' => true,
//                'expanded' => false,
//                'attr' => array('class' =>'form-control'),
//            ))
//            ->add('program', 'text', array('label' => 'Major/Degree Program', 'attr' => array('class' => 'form-control'),))
// Migrating to explicit school and major from drop down for data integrity
            ->add('school1', 'entity', array('required' => true,'class' => 'AppBundle\Entity\School',
                'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'School/College', 'attr' => array('class' =>
                    'form-control'),))
            ->add('major1', 'entity', array('required' => true,'class' => 'AppBundle\Entity\Major',
                'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Major/Degree Program', 'attr' => array('class' =>
                    'form-control'),))
            ->add('school2', 'entity', array('required' => false,'class' => 'AppBundle\Entity\School',
                'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => '2nd School/College', 'attr' => array('class' =>
                    'form-control'),))
            ->add('major2', 'entity', array('required' => false,'class' => 'AppBundle\Entity\Major',
                'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => '2nd Major/Degree Program', 'attr' => array('class' =>
                    'form-control'),))
            ->add('ugaid', 'text', array('label' => 'UGA ID ', 'attr' => array('class' => 'form-control',
                'placeholder' => '811000000'),))
            ->add('level', 'choice', array(
                'choices' => array(
                    'Undergrad' => 'Undergrad',
                    'Grad' => 'Grad'
                ),
                // *this line is important*
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('degree', 'text', array('required' => false, 'label' => 'Previous degree(s)', 'attr' => array('class' =>
                'form-control'),))
            ->add('institution', 'text', array('required' => false, 'label' => 'Previous Institution(s)', 'attr' => array('class' => 'form-control'),))
            ->add('graddate', 'choice', array(
                'required' => true,
                'multiple' => false,
                'label' => 'Expected Graduation Year',
                'choices' => array(
                    '2016' => '2016',
                    '2017' => '2017',
                    '2018' => '2018',
                    '2019' => '2019',
                    '2020' => '2020',
                    '2021' => '2021',
                    '2022' => '2022',
                    '2023' => '2023',
                    '2024' => '2024',
                    '2025' => '2025',
                ),
                // *this line is important*
                'choices_as_values' => true,
                'expanded' => false,
                'attr' => array('class' =>'form-control'),
            ))
            ->add('gradterm', 'choice', array(
                'required' => true,
                'multiple' => false,
                'label' => 'Expected Graduation Term',
                'choices' => array(
                    'Spring' => 'Spring',
                    'Summer' => 'Summer',
                    'Fall' => 'Fall',
                ),
                // *this line is important*
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('address', 'text', array('required' => false, 'label' => 'Street', 'attr' => array('class' => 'form-control'),))
            ->add('cityst', 'text', array('required' => false, 'label' => 'City, State, Zip', 'attr' => array('class' => 'form-control'),))
            ->add('country', 'text', array('required' => false, 'label' => 'Country', 'attr' => array('class' =>
                'form-control'),))
            ->add('phone', 'text', array('required' => false, 'label' => 'Phone', 'attr' => array('class' => 'form-control'),))
            ->add('area', 'choice', array(
                'required' => false,
                'multiple' => true,
                'label' => 'Areas of Interest',
                'choices' => array(
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
            ->add('interest', 'ckeditor', array('required' => false, 'label' => 'Details on your interest in Sustainability', 'config_name'
            =>
                'editor_simple',))
            ->add('experience', 'ckeditor', array('required' => false, 'label' => 'Experience in Sustainability', 'config_name'
            =>
                'editor_simple',))
            ->add('goals', 'ckeditor', array('required' => false, 'label' => 'What are your goals', 'config_name'
            =>
                'editor_simple',));
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
