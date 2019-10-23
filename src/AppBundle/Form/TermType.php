<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class TermType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('attr' => array('class' => 'text form-control'),))
            ->add('year', TextType::class, array('attr' => array('class' => 'text form-control'),))
            ->add('term', TextType::class, array('attr' => array('class' => 'text form-control'),))
            ->add('status', ChoiceType::class, array(
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
