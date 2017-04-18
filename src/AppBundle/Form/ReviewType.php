<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReviewType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', 'choice', array('choices' => array('Complete' => 'Complete','Incomplete' => 'Incomplete','Close' => 'Closed',),
                'required' =>  true,
                'expanded' => false,
                'multiple' => false,
                'label' => 'Status',
                'attr' => array('class' => 'form-control'),))
            ->add('body', 'ckeditor', array('config_name' => 'editor_simple',))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Review'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_review';
    }
}
