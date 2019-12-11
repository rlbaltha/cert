<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class TagType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('attr' => array('class' => 'text form-control'),))
            ->add('color', TextType::class, array('attr' => array('class' => 'text form-control'),))
            ->add('top', EntityType::class, array('class' => 'AppBundle\Entity\Tag',
                'choice_label' => 'title','required'=>false,'expanded'=>false,'multiple'=>false,'label'  => 'Super', 'attr' => array('class' =>
                    'form-control'),))
            ->add('sortorder', NumberType::class, array('attr' => array('class' => 'text form-control'),))
            ->add('type', ChoiceType::class, array('choices' => array('resource' => 'resource', 'user' => 'user', 'content' => 'content'),
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
