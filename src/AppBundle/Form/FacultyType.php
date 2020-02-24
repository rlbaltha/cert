<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
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
          ->add('firstname',TextType::class, array('attr' => array('label'=> 'Firstname','class' => 'text form-control'),))
          ->add('lastname',TextType::class, array('attr' => array('label'=> 'Lastname','class' => 'text form-control'),))
          ->add('status', ChoiceType::class, array(
                'required'=> true,
                'multiple'=> false,
                'label' => 'Status',
                'choices'  => array(
                    'Affiliate' => 'affiliate',
                    'Advisory Board' => 'advisory',
                    'Emeritus' => 'emeritus',
                ),
              // *this line is important*
              'choices_as_values' => true,
              'expanded' => true,
          ))
          ->add('mentor', ChoiceType::class, array(
                'required'=> true,
                'multiple'=> false,
                'label' => 'Capstone Mentor',
                'choices'  => array(
                    'no' => 'no',
                    'yes' => 'yes',
                ),
                // *this line is important*
                'choices_as_values' => true,
                'expanded' => true,
            ))
          ->add('dept',TextType::class, array('attr' => array('label'=> 'Department','class' => 'text form-control',
            'placeholder' => 'Dept'),'required'=>false))
          ->add('email',TextType::class, array('attr' => array('label'=> 'Email','class' => 'text form-control', 'placeholder'
          => 'email@uga.edu','required'=>false),'required'=>false))
          ->add('photo',TextType::class, array('label'=> 'Photo URL', 'attr' => array('class' => 'text form-control',
            'placeholder'=>'https://dept.uga.edu/photo.jpg'),'required'=>false))
          ->add('detail', CkeditorType::class, array('label'=> 'Bio and Reseach','config_name' => 'editor_default','required'=>false))
          ->add('courses', EntityType::class, array('required' => false, 'class' => 'AppBundle\Entity\Course',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.status = :status1 or c.status = :status2')
                        ->setParameter('status1', 'approved')
                        ->setParameter('status2', 'exception')
                        ->orderBy('c.name ');
                },
              'choice_label' => 'name','expanded'=>true,'multiple'=>true,'label'  => 'Courses', 'label_attr'=> array('class' => 'checkbox-inline'),))
            ->add('tags', EntityType::class, array('class' => 'AppBundle\Entity\Tag',
                'choice_label' => 'title','expanded'=>true,'multiple'=>true,'label'  => 'Tags', 'attr' => array('class' =>
                    'checkbox'),))
            ->add('user', EntityType::class, array('class' => 'AppBundle\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.lastname != :lastname')
                        ->setParameter('lastname', '')
                        ->orderBy('u.lastname ');
                },
                'choice_label' => 'name','expanded'=>false,'multiple'=>false,'label'  => 'Account', 'required'=>false, 'attr' => array('class' =>
                    'text form-control'),))
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
