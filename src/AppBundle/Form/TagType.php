<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('attr' => array('class' => 'text form-control'),))
            ->add('color', 'text', array('attr' => array('class' => 'text form-control'),))
            ->add('top', 'entity', array('class' => 'AppBundle\Entity\Tag',
                'property' => 'title','required'=>false,'expanded'=>false,'multiple'=>false,'label'  => 'Super', 'attr' => array('class' =>
                    'form-control'),))
            ->add('sortorder', 'number', array('attr' => array('class' => 'text form-control'),))
            ->add('type', 'choice', array('choices' => array('resource' => 'resource', 'user' => 'user', 'content' => 'content'),
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Tag Type',
                'attr' => array('class' => ''),))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tag'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_tag';
    }
}
