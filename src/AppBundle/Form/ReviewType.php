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
            ->add('status', 'choice', array('choices' => array('Needs Improvement' => 'Needs Improvement','Incomplete' => 'Incomplete','Complete' => 'Complete'),
                'required' =>  true,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Recommended Status for this Checkpoint',
                'attr' => array('class' => ''),))
            ->add('body', 'ckeditor', array('config_name' => 'editor_simple','label' => 'Notes on the progress of this checkpoint.',))

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
