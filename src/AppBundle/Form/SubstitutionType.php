<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubstitutionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('requirement', 'choice', array(
                'required' => true,
                'multiple' => false,
                'label' => 'Requirement',
                'choices' => array(
                    'Anchor' => 'Anchor',
                    'Social Sphere' => 'Social Sphere',
                    'Economic Sphere' => 'Economic Sphere',
                    'Ecological Sphere' => 'Ecological Sphere',
                    'Capstone' => 'Capstone',
                ),
                // *this line is important*
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('description', 'ckeditor', array('label'  => 'Exception:  Please offer your exception to the above requirement and the reason for it.','config_name' => 'editor_simple',))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Substitution'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_substitution';
    }
}
