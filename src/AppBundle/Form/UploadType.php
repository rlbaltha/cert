<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UploadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', array('label' => 'File to Upload', 'attr' => array('class' => '')))
            ->add('type', 'choice', array('choices' => array('Syllabus' =>
                'Syllabus', 'Image' =>
                'Image', 'iCal' =>
                'iCal'), 'required' => true,
                'expanded' => FALSE, 'multiple' => false, 'label' => 'Type',
                'attr' => array('class' => 'form-control'),))
            ->add('color', 'text', array('required' => false, 'label' => 'Calendar Color', 'attr' => array('class' => 'form-control'),))
            ->add('course', 'entity', array(
                'required' => false,
                'empty_data' => null,
                'class' => 'AppBundle:Course',
                'choice_label' => 'title',
                'label' => 'Course',
                'attr' => array('class' => 'form-control'),));;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Upload'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_upload';
    }
}
