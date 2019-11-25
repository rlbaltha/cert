<?php

namespace AppBundle\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class PartnerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Project Title', 'attr' => array('class' => 'text form-control'),))
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
                'details',
                CKEditorType::class,
                array(
                    'required' => false,
                    'label' => 'Project Outline',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'deliverables',
                CKEditorType::class,
                array(
                    'required' => false,
                    'label' => 'Deliverables',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'outcomes',
                CKEditorType::class,
                array(
                    'required' => false,
                    'label' => 'Anticipated Outcomes',
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
            ->add('users', EntityType::class, array('class' => 'AppBundle\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.checklist', 'c')
                        ->andWhere('c.id IS NOT NULL')
                        ->addOrderBy('u.lastname', 'ASC');
                },
                'required' => false, 'choice_label' => 'name', 'expanded' => true, 'multiple' => true, 'label' => 'Team Members', 'attr' => array('class' =>
                    'checkbox'),))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Partner'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_partner';
    }
}
