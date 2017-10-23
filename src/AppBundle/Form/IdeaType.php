<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IdeaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('attr' => array('class' => 'text form-control'),))
            ->add('summary', 'ckeditor', array('config_name' => 'editor_simple',))
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
            'data_class' => 'AppBundle\Entity\Idea'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_idea';
    }
}
