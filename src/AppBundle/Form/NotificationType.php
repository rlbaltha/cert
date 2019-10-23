<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SC\DatetimepickerBundle\Form\Type\DatetimeType;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NotificationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('post', EntityType::class, array('class' => 'AppBundle\Entity\Post',
                'property' => 'title','required' => false,'expanded'=>false,'multiple'=>false,'label'  => 'Post', 'attr' => array('class' =>
                    'form-control'),))
            ->add('body', CkeditorType::class, array('config_name' => 'editor_default', 'label'  => 'Additional Text',))
            ->add('date', DatetimeType::class, array('pickerOptions' =>
                array('todayBtn' => true, 'format' => 'dd MM yyyy - HH:ii P', 'showMeridian' => true,
                ),
                'attr' => array('class' => 'form-control'), 'label'  => 'Event Date',))
            ->add('display_start', DatetimeType::class, array('label'  => 'Start Display','pickerOptions' =>
                array('todayBtn' => true, 'format' => 'dd MM yyyy - HH:ii P', 'showMeridian' => true,
                ),
                'attr' => array('class' => 'form-control'),))
            ->add('display_end', DatetimeType::class, array('label'  => 'End Display','pickerOptions' =>
                array('todayBtn' => true, 'format' => 'dd MM yyyy - HH:ii P', 'showMeridian' => true,
                ),
                'attr' => array('class' => 'form-control'),))
            ->add('status', ChoiceType::class, array(
                'attr' => array('class' => 'form-control'),
                'choices'  => array(
                    'Individual' => "New",
                    'Dismissed' => "Dismissed",
                    'Everyone' => "Shared",
                ),
                // *this line is important*
                'choices_as_values' => true,))
            ->add('tags', EntityType::class, array('class' => 'AppBundle\Entity\Tag',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->andWhere('t.type = :type')
                        ->setParameter('type', 'user')
                        ;
                },
                'property' => 'title','expanded'=>true,'multiple'=>true,'label'  => 'Tags', 'required'=>false, 'attr' => array('class' =>
                    'checkbox'),))
            ->add('user', EntityType::class, array('class' => 'AppBundle\Entity\User',
                'property' => 'name','required' => false,'expanded'=>false,'multiple'=>false,'label'  => 'User', 'attr' => array('class' =>
                    'form-control'),))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Notification'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_notification';
    }
}
