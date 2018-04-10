<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\Status;

class ProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', array('label' => 'First Name', 'attr' => array('class' => 'form-control'),))
            ->add('lastname', 'text', array('label' => 'Last Name','attr' => array('class' => 'form-control'),))
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
            ->add('graddate', 'choice', array(
                'required' => true,
                'multiple' => false,
                'label' => 'Expected Graduation Year',
                'choices' => array(
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
            ->add('altemail', 'text', array('required' => false, 'label' => 'Alternative Email Account','attr' => array('class' => 'form-control'),))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_user';
    }
}
