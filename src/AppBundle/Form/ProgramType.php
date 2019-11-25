<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProgramType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('school1', EntityType::class, array('required' => true,'class' => 'AppBundle\Entity\School',
                'choice_label' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'School/College', 'attr' => array('class' =>
                    'form-control'),))
            ->add('major1', EntityType::class, array('required' => true,'class' => 'AppBundle\Entity\Major',
                'choice_label' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Major/Degree Program', 'attr' => array('class' =>
                    'form-control'),))
            ->add('school2', EntityType::class, array('required' => false,'class' => 'AppBundle\Entity\School',
                'choice_label' => 'name','expanded'=>false,'multiple'=>false,'label'  => '2nd School/College', 'attr' => array('class' =>
                    'form-control'),))
            ->add('major2', EntityType::class, array('required' => false,'class' => 'AppBundle\Entity\Major',
                'choice_label' => 'name','expanded'=>false,'multiple'=>false,'label'  => '2nd Major/Degree Program', 'attr' => array('class' =>
                    'form-control'),))
            ->add('minors', TextType::class, array('label' => 'Minor(s) ', 'attr' => array('class' => 'form-control'),))
            ->add('ugaid', TextType::class, array('label' => 'UGA ID ', 'attr' => array('class' => 'form-control',
                'placeholder' => '811000000'),))
            ->add('level', ChoiceType::class, array(
                'choices' => array(
                    'Undergrad' => 'Undergrad',
                    'Grad' => 'Grad'
                ),
                // *this line is important*
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('degree', TextType::class, array('required' => false, 'label' => 'Previous degree(s)', 'attr' => array('class' =>
                'form-control'),))
            ->add('institution', TextType::class, array('required' => false, 'label' => 'Previous Institution(s)', 'attr' => array('class' => 'form-control'),))
            ->add('address', TextType::class, array('required' => false, 'label' => 'Street', 'attr' => array('class' => 'form-control'),))
            ->add('cityst', TextType::class, array('required' => false, 'label' => 'City, State, Zip', 'attr' => array('class' => 'form-control'),))
            ->add('country', TextType::class, array('required' => false, 'label' => 'Country', 'attr' => array('class' =>
                'form-control'),))
            ->add('phone', TextType::class, array('required' => false, 'label' => 'Phone', 'attr' => array('class' => 'form-control'),))
            ->add('area', ChoiceType::class, array(
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
            ->add('interest', CkeditorType::class, array('required' => false, 'label' => 'Details on your interest in Sustainability', 'config_name'
            =>
                'editor_simple',))
            ->add('experience', CkeditorType::class, array('required' => false, 'label' => 'Experience in Sustainability', 'config_name'
            =>
                'editor_simple',))
            ->add('goals', CkeditorType::class, array('required' => false, 'label' => 'What are your goals', 'config_name'
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
