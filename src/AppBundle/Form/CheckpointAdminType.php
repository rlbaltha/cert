<?php

namespace AppBundle\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use SC\DatetimepickerBundle\Form\Type\DatetimeType;

class CheckpointAdminType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, array('attr' => array('class' => 'text form-control'),))
            ->add('description', CKEditorType::class, array('config_name' => 'editor_simple',))
            ->add('deadline', DatetimeType::class, array('pickerOptions' =>
                array('todayBtn' => true, 'format' => 'dd MM yyyy - HH:ii P', 'showMeridian' => true,
                ),
                'attr' => array('class' => 'form-control'),))
            ->add('status', ChoiceType::class, array('choices' => array('Opened' => 'Open', 'Complete' => 'Complete'),
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Status',
                'attr' => array('class' => ''),))
            ->add('reviewers', EntityType::class, array('class' => 'AppBundle\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.progress', 'p')
                        ->andWhere("u.progress = '15' or u.progress = '16'  or u.progress = '7'")
                        ->addOrderBy('u.lastname', 'ASC')
                        ->addOrderBy('u.firstname', 'ASC');
                },
                'choice_label' => 'name', 'expanded' => true, 'multiple' => true, 'label' => 'Reviewers', 'attr' => array('class' =>
                    'checkbox'),))
            ->add('lead', TextType::class, array('required' => false,'label' => 'Lead Person', 'attr' => array('class' => 'text form-control'),))
            ->add('posts', EntityType::class, array('class' => 'AppBundle\Entity\Post',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->addOrderBy('p.title', 'ASC');
                },
                'choice_label' => 'title', 'expanded' => true, 'multiple' => true, 'label' => 'Posts', 'attr' => array('class' =>
                    ''),));
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
