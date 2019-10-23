<?php

namespace AppBundle\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class CapstoneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Project Title', 'attr' => array('class' => 'text form-control'),))
            ->add('tags', EntityType::class, array('class' => 'AppBundle\Entity\Tag',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->andWhere("t.type = 'resource'");
                },
                'choice_label' => 'title', 'expanded' => true, 'multiple' => true, 'label' => 'Tags: Please select up to 5', 'attr' => array('class' =>
                    'checkbox'),))
            ->add(
                'description',
                CKEditorType::class,
                array(
                    'required' => false,
                    'label' => 'Project Description:  What will you do and how does the project relate to all three spheres of sustainability?',
                    'config_name' => 'editor_simple',
                )
            )
            ->add('users', EntityType::class, array('class' => 'AppBundle\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.checklist', 'c')
                        ->andWhere("c.capstonedate IS NOT NULL")
                        ->addOrderBy('u.lastname', 'ASC')
                        ->addOrderBy('u.firstname', 'ASC');
                },
                'required' => false, 'choice_label' => 'name', 'expanded' => true, 'multiple' => true, 'label' => 'Team Members', 'attr' => array('class' =>
                    ''),))
            ->add('capstoneMentor', EntityType::class, array('class' => 'AppBundle\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.facultylisting', 'f')
                        ->andWhere("f.mentor = 'Yes'")
                        ->addOrderBy('u.lastname', 'ASC')
                        ->addOrderBy('u.firstname', 'ASC');
                },
                'required' => false, 'choice_label' => 'name', 'expanded' => true, 'multiple' => true, 'label' => 'Faculty Mentor / Sustainability Rep', 'attr' => array('class' =>
                    ''),))
            ->add(
                'purpose',
                CKEditorType::class,
                array(
                    'required' => false,
                    'label' => 'Main Purpose',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'background',
                CKEditorType::class,
                array(
                    'required' => false,
                    'label' => 'Background and Context',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'contribution',
                CKEditorType::class,
                array(
                    'required' => false,
                    'label' => 'Contribution to Sustainability',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'considerations',
                CKEditorType::class,
                array(
                    'required' => false,
                    'label' => 'Special Considerations',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'sources',
                CKEditorType::class,
                array(
                    'required' => false,
                    'label' => 'Potential Information Sources',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'qualifications',
                CKEditorType::class,
                array(
                    'required' => false,
                    'label' => 'Desired Team Qualifications',
                    'config_name' => 'editor_simple',
                )
            )
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Capstone',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_capstone';
    }
}
