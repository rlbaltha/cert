<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TermType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('attr' => array('class' => 'text form-control'),))
            ->add('year', 'text', array('attr' => array('class' => 'text form-control'),))
            ->add('term', 'text', array('attr' => array('class' => 'text form-control'),))
            ->add('status', 'choice', array(
                'choices' => array(
                    'Current' => 'Current',
                    'Archive' => 'Archive',
                    'Display' => 'Display',
                    'Default' => 'Default'
                ),
                // *this line is important*
                'choices_as_values' => true,
                'expanded' => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Term'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_term';
    }
}
