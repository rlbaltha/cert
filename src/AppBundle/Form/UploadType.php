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
            ->add('file','file', array('label'  => 'File to Upload', 'attr' =>array('class' => '')))
            ->add('type', 'choice', array('choices'   => array('NA' =>
              'NA', 'Course' => 'Course', 'Faculty' => 'Faculty'),'required' => true,
              'expanded'=>FALSE,'multiple'=>false,'label'  => 'Type',
              'attr' => array('class' => 'form-control'),))
        ;
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
