<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class SourceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class, array('attr' => array('class' => 'text form-control'),))
            ->add('type', ChoiceType::class, array(
                'choices'  => array(
                    'Person' => 'Person',
                    'Organization:Campus' => 'Organization:Campus',
                    'Organization:Community' => 'Organization:Community',
                    'Website' => 'Website'
                ),
                // *this line is important*
                'choices_as_values' => true,
                'required' => true,'expanded'=>false,'multiple'=>false,'label'  => 'Type', 'attr' => array('class' =>
                    'form-control'),
            ))
            ->add('name', TextType::class, array('attr' => array('class' => 'text form-control'), 'required' => false,))
            ->add('title', TextType::class, array('attr' => array('class' => 'text form-control'),'required' => false,))
            ->add('organization', TextType::class, array('attr' => array('class' => 'text form-control'),'required' => false,))
            ->add('contact', TextType::class, array('attr' => array('class' => 'text form-control'),'required' => false,))
            ->add('description', CkeditorType::class, array('config_name' => 'editor_default',))
            ->add('tags', EntityType::class, array('class' => 'AppBundle\Entity\Tag',
                'choice_label' => 'title','expanded'=>true,'multiple'=>true,'label'  => 'Tags', 'attr' => array('class' =>
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
