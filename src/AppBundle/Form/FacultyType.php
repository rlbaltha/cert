<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FacultyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('name','text', array('attr' => array('class' => 'text form-control', 'placeholder' => 'Name'),))
          ->add('dept','text', array('attr' => array('class' => 'text form-control', 'placeholder' => 'Name'),))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Faculty'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_faculty';
    }
}
