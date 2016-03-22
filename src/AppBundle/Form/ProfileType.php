<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('firstname', 'text', array('attr' => array('class' => 'form-control', 'placeholder' => 'Firstname'),))
          ->add('lastname', 'text', array('attr' => array('class' => 'form-control', 'placeholder' => 'Lastname'),))
            ->add('status', 'choice', array('attr' => array('class' => 'form-control',),
                'choices'  => array(
                    'Administration' => 'Administration',
                    'Faculty' => 'Faculty',
                    'Account Created' => 'Account Created',
                    'Application Submitted' => 'Application Submitted',
                    'Application Approved' => 'Application Approved',
                    'Checklist Created' => 'Checklist Created',
                    'Capstone Created' => 'Capstone Created',
                    'Capstone Approved' => 'Capstone Approved',
                    'Portfolio Approved' => 'Portfolio Approved',
                    'Certificate Complete' => 'Certificate Complete' ,
                ),
                // *this line is important*
                'choices_as_values' => true,
            ))
            ->add('notes', 'ckeditor', array('config_name' => 'editor_simple',))
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
