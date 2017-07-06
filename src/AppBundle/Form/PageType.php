<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','text', array('attr' => array('class' => 'text form-control'),))
            ->add('body', 'ckeditor', array('config_name' => 'editor_page',))
            ->add('link','text', array('required' => false,'attr' => array('class' => 'text form-control'),))
            ->add('sortOrder','number', array('required' => false,'attr' => array('class' => 'text form-control'),))
            ->add('section', 'entity', array('class' => 'AppBundle\Entity\Section',
            'property' => 'title','expanded'=>false,'multiple'=>false,'label'  => 'Section', 'attr' => array('class' =>
                'form-control'),))
            ->add('access', 'choice', array(
                'required' => true,
                'multiple' => false,
                'label' => 'Access',
                'choices' => array(
                    'public' => 'public',
                    'admin' => 'admin',
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
            'data_class' => 'AppBundle\Entity\Page'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_page';
    }
}
