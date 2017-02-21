<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use AppBundle\Form\OrganizationType;

class UserType extends BaseType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('firstname', 'text', array('attr' => array('class' => 'form-control', 'placeholder' => 'Firstname'),))
            ->add('lastname', 'text', array('attr' => array('class' => 'form-control', 'placeholder' => 'Lastname'),))
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
        return 'cert_user_registration';
    }
}
