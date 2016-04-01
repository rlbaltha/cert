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
            ->add('anchor', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
              'query_builder' => function (EntityRepository $er) {
                  return $er->createQueryBuilder('c')
                    ->andWhere('c.pillar = :pillar')
                    ->andWhere('c.status = :status')
                    ->setParameter('pillar', 'anchor')
                    ->setParameter('status', 'approved')
                    ->orderBy('c.name ');
              },
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Anchor Course', 'attr' => array
              ('class' => 'form-control'),))
          ->add('sphere1', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                  ->andWhere('c.pillar = :pillar')
                  ->andWhere('c.status = :status')
                  ->setParameter('pillar', 'ecological')
                  ->setParameter('status', 'approved')
                  ->orderBy('c.name ');
            },
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Ecological Sphere', 'attr' => array
            ('class' => 'form-control'),))
          ->add('sphere2', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                  ->andWhere('c.pillar = :pillar')
                  ->andWhere('c.status = :status')
                  ->setParameter('pillar', 'economic')
                  ->setParameter('status', 'approved')
                  ->orderBy('c.name ');
            },
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Economic Sphere', 'attr' => array
            ('class' => 'form-control'),))
          ->add('sphere3', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                  ->andWhere('c.pillar = :pillar')
                  ->andWhere('c.status = :status')
                  ->setParameter('pillar', 'social')
                  ->setParameter('status', 'approved')
                  ->orderBy('c.name ');
            },
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Social Sphere', 'attr' => array
            ('class' => 'form-control'),))
          ->add('seminar', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                  ->andWhere('c.pillar = :pillar')
                  ->andWhere('c.status = :status')
                  ->setParameter('pillar', 'seminar')
                  ->setParameter('status', 'approved')
                  ->orderBy('c.name ');
            },
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Seminar', 'attr' => array
            ('class' => 'form-control'),))
          ->add('capstone', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                  ->andWhere('c.pillar = :pillar')
                  ->andWhere('c.status = :status')
                  ->setParameter('pillar', 'capstone')
                  ->setParameter('status', 'approved')
                  ->orderBy('c.name ');
            },
            'property' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Capstone', 'attr' => array
            ('class' => 'form-control'),))
          ->add('portfolio', 'text', array('required'=> false,'attr' => array('class' => 'text form-control', 'placeholder' =>
            'https://uga.digication.com/'),))
            ->add('exceptions', 'ckeditor', array('config_name' => 'editor_simple',))

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
