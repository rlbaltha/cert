<?php

namespace AppBundle\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class AdminType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array('label' => 'First Name', 'attr' => array('class' => 'form-control'),))
            ->add('lastname', TextType::class, array('label' => 'Last Name','attr' => array('class' => 'form-control'),))
            ->add('progress', EntityType::class, array('required' => true, 'class' => 'AppBundle\Entity\Status',
                'choice_label' => 'name', 'expanded' => false, 'multiple' => false, 'label' => 'Status', 'attr' => array
                ('class' => 'form-control'),))
            ->add('altemail', TextType::class, array('required' => false, 'label' => 'Alternative Email Account','attr' => array('class' => 'form-control'),))
            ->add('gradterm', ChoiceType::class, array(
                'required' => true,
                'multiple' => false,
                'label' => 'Expected Graduation Term',
                'choices' => array(
                    'Spring' => 'Spring',
                    'Fall' => 'Fall',
                ),
                // *this line is important*
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('graddate', ChoiceType::class, array(
                'required' => true,
                'multiple' => false,
                'label' => 'Expected Graduation Year',
                'choices' => array(
                    '2018' => '2018',
                    '2019' => '2019',
                    '2020' => '2020',
                    '2021' => '2021',
                    '2022' => '2022',
                    '2023' => '2023',
                    '2024' => '2024',
                    '2025' => '2025',
                ),
                // *this line is important*
                'choices_as_values' => true,
                'expanded' => false,
                'attr' => array('class' =>'form-control'),
            ))
            ->add('placement', TextType::class, array('required' => false, 'label' => 'After Graduation Placement','attr' => array('class' => 'form-control'),))
            ->add('notes', CKEditorType::class, array('config_name' => 'editor_simple',))
            ->add('tags', EntityType::class, array('class' => 'AppBundle\Entity\Tag',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->andWhere("t.type = 'user'")
                        ->addOrderBy('t.sortorder', 'ASC');
                },
                'required' => false, 'choice_label' => 'title', 'expanded' => true, 'multiple' => true, 'label' => 'Status/Progress', 'attr' => array('class' =>
                    'checkbox'),))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_user';
    }
}
