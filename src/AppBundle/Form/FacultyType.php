<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class FacultyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('firstname','text', array('attr' => array('label'=> 'Firstname','class' => 'text form-control'),))
          ->add('lastname','text', array('attr' => array('label'=> 'Lastname','class' => 'text form-control'),))
          ->add('status', 'choice', array(
                'required'=> true,
                'multiple'=> false,
                'label' => 'Status',
                'choices'  => array(
                    'Affliate' => 'affliate',
                    'Advisory Board' => 'advisory',
                    'Emeritus' => 'emeritus',
                ),
              // *this line is important*
              'choices_as_values' => true,
              'expanded' => true,
          ))
          ->add('dept','text', array('attr' => array('label'=> 'Department','class' => 'text form-control',
            'placeholder' => 'Dept'),'required'=>false))
          ->add('email','text', array('attr' => array('label'=> 'Email','class' => 'text form-control', 'placeholder'
          => 'email@uga.edu','required'=>false),'required'=>false))
          ->add('photo','text', array('label'=> 'Photo URL', 'attr' => array('class' => 'text form-control',
            'placeholder'=>'https://dept.uga.edu/photo.jpg'),'required'=>false))
          ->add('detail', 'ckeditor', array('label'=> 'Bio and Reseach','config_name' => 'editor_default','required'=>false))
          ->add('courses', 'entity', array('required' => false, 'class' => 'AppBundle\Entity\Course',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.status = :status')
                        ->setParameter('status', 'approved')
                        ->orderBy('c.name ');
                },
              'property' => 'name','expanded'=>true,'multiple'=>true,'label'  => 'Courses', 'label_attr'=> array('class' => 'checkbox-inline'),))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Faculty'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_faculty';
    }
}
