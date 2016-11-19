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
            ->add('pre_assess','date', array('attr' => array('class' => ''), 'label'  => 'Pre-Certificate Survey 
            Completed', 'required' => false,))
            ->add('orientation','date', array('attr' => array('class' => ''), 'label'  => 'Orientation 
            Completed', 'required' => false,))
            ->add('anchor', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
              'query_builder' => function (EntityRepository $er) {
                  return $er->createQueryBuilder('c')
                    ->andWhere('c.pillar = :pillar')
                      ->andWhere('c.status = :status1 or c.status = :status2')
                      ->setParameter('pillar', 'anchor')
                      ->setParameter('status1', 'approved')
                      ->setParameter('status2', 'exception')
                    ->orderBy('c.name ');
              },
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Anchor Course', 'attr' => array
              ('class' => 'form-control'),))
          ->add('sphere1', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                  ->andWhere('c.pillar = :pillar')
                    ->andWhere('c.status = :status1 or c.status = :status2')
                    ->setParameter('pillar', 'ecological')
                    ->setParameter('status1', 'approved')
                    ->setParameter('status2', 'exception')
                  ->orderBy('c.name ');
            },
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Ecological Sphere', 'attr' => array
            ('class' => 'form-control'),))
          ->add('sphere2', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                  ->andWhere('c.pillar = :pillar')
                    ->andWhere('c.status = :status1 or c.status = :status2')
                    ->setParameter('pillar', 'economic')
                    ->setParameter('status1', 'approved')
                    ->setParameter('status2', 'exception')
                  ->orderBy('c.name ');
            },
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Economic Sphere', 'attr' => array
            ('class' => 'form-control'),))
          ->add('sphere3', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                  ->andWhere('c.pillar = :pillar')
                    ->andWhere('c.status = :status1 or c.status = :status2')
                    ->setParameter('pillar', 'social')
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
            ('class' => 'form-control'),))
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
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Capstone', 'attr' => array
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
                )
            )
          ->add('portfolio', 'text', array('required'=> false,'attr' => array('class' => 'text form-control', 'placeholder' =>
            'https://uga.digication.com/'),))
          ->add('post_assess','date', array('attr' => array('class' => ''), 'label'  => 'Post-Certificate Survey 
            Completed', 'required' => false,))
            ->add('exceptions', 'ckeditor', array('label'  => 'Exceptions:  Please offer any exceptions to the above requirements and the reasons for them.','config_name' => 'editor_simple',))

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
