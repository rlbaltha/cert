<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ChecklistType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('athena','date', array('attr' => array('class' => ''), 'label'  => 'Date Certificate was added in Athena', 'required' => false,))
            ->add('pre_assess','date', array('attr' => array('class' => ''), 'label'  => 'Pre-Certificate Survey 
            Completed', 'required' => false,))
            ->add('orientation','date', array('attr' => array('class' => ' hr'), 'label'  => 'Orientation 
            Completed', 'required' => false,))
            ->add('anchor', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
              'query_builder' => function (EntityRepository $er) {
                  return $er->createQueryBuilder('c')
                    ->andWhere('c.pillar = :pillar1 or c.pillar = :pillar2')
                      ->andWhere('c.status = :status1 or c.status = :status2')
                      ->setParameter('pillar1', 'anchor')
                      ->setParameter('pillar2', 'any')
                      ->setParameter('status1', 'approved')
                      ->setParameter('status2', 'exception')
                    ->orderBy('c.name ');
              },
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Anchor Course', 'attr' => array
              ('class' => 'form-control'),))
          ->add('sphere1', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->andWhere('c.pillar = :pillar1 or c.pillar = :pillar2')
                    ->andWhere('c.status = :status1 or c.status = :status2')
                    ->setParameter('pillar1', 'ecological')
                    ->setParameter('pillar2', 'any')
                    ->setParameter('status1', 'approved')
                    ->setParameter('status2', 'exception')
                  ->orderBy('c.name ');
            },
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Ecological Sphere', 'attr' => array
            ('class' => 'form-control'),))
          ->add('sphere2', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->andWhere('c.pillar = :pillar1 or c.pillar = :pillar2')
                    ->andWhere('c.status = :status1 or c.status = :status2')
                    ->setParameter('pillar1', 'economic')
                    ->setParameter('pillar2', 'any')
                    ->setParameter('status1', 'approved')
                    ->setParameter('status2', 'exception')
                  ->orderBy('c.name ');
            },
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Economic Sphere', 'attr' => array
            ('class' => 'form-control'),))
          ->add('sphere3', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->andWhere('c.pillar = :pillar1 or c.pillar = :pillar2')
                    ->andWhere('c.status = :status1 or c.status = :status2')
                    ->setParameter('pillar1', 'social')
                    ->setParameter('pillar2', 'any')
                    ->setParameter('status1', 'approved')
                    ->setParameter('status2', 'exception')
                  ->orderBy('c.name ');
            },
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Social Sphere', 'attr' => array
            ('class' => 'form-control'),))
          ->add('seminar', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                  ->andWhere('c.pillar = :pillar')
                    ->andWhere('c.status = :status1 or c.status = :status2')
                    ->setParameter('pillar', 'seminar')
                    ->setParameter('status1', 'approved')
                    ->setParameter('status2', 'exception')
                  ->orderBy('c.name ');
            },
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Seminar', 'attr' => array
            ('class' => 'form-control hr'),))
            ->add('capstoneterm', 'choice', array(
                'required' => true,
                'multiple' => false,
                'label' => 'Expected Capstone Term',
                'choices' => array(
                    'Spring' => 'Spring',
                    'Summer' => 'Summer',
                    'Fall' => 'Fall',
                ),
                // *this line is important*
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('capstonedate', 'choice', array(
                'required' => true,
                'multiple' => false,
                'label' => 'Expected Capstone Year',
                'choices' => array(
                    '2017' => '2017',
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
            ->add('capstone', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.pillar = :pillar')
                        ->andWhere('c.status = :status1 or c.status = :status2')
                        ->setParameter('pillar', 'capstone')
                        ->setParameter('status1', 'approved')
                        ->setParameter('status2', 'exception')
                        ->orderBy('c.name ');
                },
                'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Capstone Course', 'attr' => array
                ('class' => 'form-control'),))
            ->add(
                'presentation',
                'choice',
                array(
                    'choices' => array(
                        'Seminar' => 'Seminar',
                        'Semester In Review' => 'Semester In Review',
                        'Sustainability Slam' => 'Sustainability Slam',
                        'Conference' => 'Conference',
                        'Other' => 'Other',
                    ),
                    // *this line is important*
                    'choices_as_values' => true,
                    'label' => 'Where did you present your capstone?',
                    'attr' => array('class' => 'text form-control'),
                    'required' => false,
                )
            )
          ->add('portfolio', 'text', array('required'=> false,'attr' => array('class' => 'text form-control hr', 'placeholder' =>
            'https://ctlsites.uga.edu/sustainability-/'),))

            ->add('gradterm', 'choice', array(
                'required' => true,
                'multiple' => false,
                'label' => 'Expected Graduation Term',
                'choices' => array(
                    'Spring' => 'Spring',
                    'Summer' => 'Summer',
                    'Fall' => 'Fall',
                ),
                // *this line is important*
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('graddate', 'choice', array(
                'required' => true,
                'multiple' => false,
                'label' => 'Expected Graduation Year',
                'choices' => array(
                    '2017' => '2017',
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
                'attr' => array('class' =>'form-control hr'),
            ))
            ->add('exceptions', 'ckeditor', array('label'  => 'Exceptions:  Please offer any exceptions to the above requirements and the reasons for them.','config_name' => 'editor_simple',))
            ->add('post_assess','date', array('attr' => array('class' => ' hr'), 'label'  => 'Post-Certificate Survey 
            Completed', 'required' => false,))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Checklist'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_checklist';
    }
}
