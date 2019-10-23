<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class SubstitutionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('requirement', ChoiceType::class, array(
                'required' => true,
                'multiple' => false,
                'label' => 'Requirement',
                'choices' => array(
                    'Anchor' => 'Anchor',
                    'Seminar' => 'Seminar',
                    'Social Sphere' => 'Social Sphere',
                    'Economic Sphere' => 'Economic Sphere',
                    'Ecological Sphere' => 'Ecological Sphere',
                    'Capstone' => 'Capstone',
                ),
                // *this line is important*
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('description', CkeditorType::class, array('label'  => 'Exception:  Please offer your exception to the above requirement and the reason for it.','config_name' => 'editor_simple',))
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
