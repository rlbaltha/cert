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
            ->add('status', 'choice', array('choices' => array('Opened' => 'Opened', 'Complete' => 'Complete'),
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Status',
                'attr' => array('class' => ''),))
            ->add('reviewers', 'entity', array('class' => 'AppBundle\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.progress', 'p')
                        ->andWhere("u.progress = '15' or u.progress = '16'  or u.progress = '7'")
                        ->addOrderBy('u.lastname', 'ASC')
                        ->addOrderBy('u.firstname', 'ASC');
                },
                'property' => 'name', 'expanded' => true, 'multiple' => true, 'label' => 'Reviewers', 'attr' => array('class' =>
                    'checkbox'),));
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
