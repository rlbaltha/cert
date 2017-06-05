<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\OrganizationType;
use SC\DatetimepickerBundle\Form\Type\DatetimeType;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('attr' => array('class' => 'text form-control', 'placeholder' => 'Title'),))
            ->add('body', 'ckeditor', array('config_name' => 'editor_default',))
            ->add('datetime', DatetimeType::class, array('pickerOptions' =>
                array('todayBtn' => true, 'format' => 'dd MM yyyy - HH:ii P', 'showMeridian' => true,
                ),
                'attr' => array('class' => 'form-control'),))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_event';
    }
}
