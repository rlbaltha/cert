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
            ->add('organizations', 'entity', array('class' => 'AppBundle\Entity\Organization',
                'property' => 'title','expanded'=>true,'multiple'=>true,'label'  => 'Organizations', 'attr' => array('class' =>
                    ''),))
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
