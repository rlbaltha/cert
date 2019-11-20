<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, array('attr' => array('class' => 'text form-control'),))
            ->add('body', CkeditorType::class, array('config_name' => 'editor_page',))
            ->add('link',TextType::class, array('required' => false,'attr' => array('class' => 'text form-control'),))
            ->add('sortOrder',NumberType::class, array('required' => false,'attr' => array('class' => 'text form-control'),))
            ->add('section', EntityType::class, array('class' => 'AppBundle\Entity\Section',
            'choice_label' => 'title','expanded'=>false,'multiple'=>false,'label'  => 'Section', 'attr' => array('class' =>
                'form-control'),))
            ->add('access', ChoiceType::class, array(
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
