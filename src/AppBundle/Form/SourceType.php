<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SourceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'text', array('attr' => array('class' => 'text form-control'),))
            ->add('name', 'text', array('attr' => array('class' => 'text form-control'),))
            ->add('title', 'text', array('attr' => array('class' => 'text form-control'),))
            ->add('organization', 'text', array('attr' => array('class' => 'text form-control'),))
            ->add('contact', 'text', array('attr' => array('class' => 'text form-control'),))
            ->add('description', 'ckeditor', array('config_name' => 'editor_default',))
            ->add('tags', 'entity', array('class' => 'AppBundle\Entity\Tag',
                'property' => 'title','expanded'=>true,'multiple'=>true,'label'  => 'Tags', 'attr' => array('class' =>
                    'checkbox'),))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Source'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_source';
    }
}
