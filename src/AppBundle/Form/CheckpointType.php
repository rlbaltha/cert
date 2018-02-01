<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use SC\DatetimepickerBundle\Form\Type\DatetimeType;

class CheckpointType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', 'text', array('attr' => array('class' => 'text form-control'),))
            ->add('description', 'ckeditor', array('config_name' => 'editor_simple',))
            ->add('deadline', DatetimeType::class, array('pickerOptions' =>
                array('todayBtn' => true, 'format' => 'dd MM yyyy - HH:ii P', 'showMeridian' => true,
                ),
                'attr' => array('class' => 'form-control'),))
            ->add('status', 'choice', array('choices' => array('Opened' => 'Open', 'Complete' => 'Complete'),
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Status',
                'attr' => array('class' => ''),))
            ->add('lead', 'text', array('required' => false,'label' => 'Lead Person', 'attr' => array('class' => 'text form-control'),));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Checkpoint'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_checkpoint';
    }
}
