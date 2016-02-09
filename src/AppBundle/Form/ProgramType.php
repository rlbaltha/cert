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
            ->add('school', 'text', array('label'=>'School or College','attr' => array('class' => 'text form-control'),))
            ->add('major', 'text', array('label'=>'Major(s)','attr' => array('class' => 'text form-control'),))
            ->add('graddate', 'text', array('label'=>'Expected Graduation Date (Term, Year)','attr' => array('class' => 'text form-control'),))
            ->add('interest', 'ckeditor', array('label'=>'Interest in Sustainability','config_name' => 'editor_default',))
        ;
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
