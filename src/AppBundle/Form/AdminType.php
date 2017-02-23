<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\Status;

class AdminType extends AbstractType
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
            ->add('progress', 'entity', array('required' => true, 'class' => 'AppBundle\Entity\Status',
                'property' => 'name', 'expanded' => false, 'multiple' => false, 'label' => 'Status', 'attr' => array
                ('class' => 'form-control'),))
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
