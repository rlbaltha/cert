<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
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
            ->add('title', 'text', array('label' => 'Project Title', 'attr' => array('class' => 'text form-control'),))
            ->add('tags', 'entity', array('class' => 'AppBundle\Entity\Tag',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->andWhere("t.type = 'resource'");
                },
                'property' => 'title', 'expanded' => true, 'multiple' => true, 'label' => 'Tags: Please select up to 5', 'attr' => array('class' =>
                    'checkbox'),))
            ->add(
                'description',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Project Description:  What will you do and how does the project relate to all three spheres of sustainability?',
                    'config_name' => 'editor_simple',
                )
            )
            ->add('users', 'entity', array('class' => 'AppBundle\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.checklist', 'c')
                        ->andWhere("c.capstonedate IS NOT NULL")
                        ->addOrderBy('u.lastname', 'ASC')
                        ->addOrderBy('u.firstname', 'ASC');
                },
                'required' => false, 'property' => 'name', 'expanded' => true, 'multiple' => true, 'label' => 'Team Members', 'attr' => array('class' =>
                    ''),))
            ->add('capstoneMentor', 'entity', array('class' => 'AppBundle\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.facultylisting', 'f')
                        ->andWhere("f.mentor = 'Yes'")
                        ->addOrderBy('u.lastname', 'ASC')
                        ->addOrderBy('u.firstname', 'ASC');
                },
                'required' => false, 'property' => 'name', 'expanded' => true, 'multiple' => true, 'label' => 'Faculty Mentor / Sustainability Rep', 'attr' => array('class' =>
                    ''),))
            ->add(
                'purpose',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Main Purpose',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'background',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Background and Context',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'contribution',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Contribution to Sustainability',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'details',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Project Outline',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'outcomes',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Anticipated Outcomes',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'considerations',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Special Considerations',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'sources',
                'ckeditor',
                array(
                    'required' => false,
                    'label' => 'Potential Information Sources',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'qualifications',
                'ckeditor',
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
