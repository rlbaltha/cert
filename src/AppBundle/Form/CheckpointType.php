<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class CheckpointType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name','text', array('attr' => array('class' => 'text form-control'),))
            ->add('description', 'ckeditor', array('config_name' => 'editor_simple',))
            ->add('type', 'choice', array('choices' => array('Admin' => 'Admin','Capstone' => 'Capstone'),
                'required' =>  true,
                'expanded' => false,
                'multiple' => false,
                'label' => 'Type',
                'attr' => array('class' => 'form-control'),))
            ->add('timeframe', 'choice', array('choices' => array('Once' => 'Once','Semester' => 'Semester','Annual' => 'Annual'),
                'required' =>  true,
                'expanded' => false,
                'multiple' => false,
                'label' => 'Timeframe',
                'attr' => array('class' => 'form-control'),))
            ->add('deadline')
            ->add('status', 'choice', array('choices' => array('Opened' => 'Opened','Assigned' => 'Assigned','Reviewed' => 'Reviewed','Approved' => 'Approved'),
                'required' =>  true,
                'expanded' => false,
                'multiple' => false,
                'label' => 'Status',
                'attr' => array('class' => 'form-control'),))
            ->add('reviewers', 'entity', array('class' => 'AppBundle\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere("u.status = :status")
                        ->setParameter('status', 'Administration');
                },
                'property' => 'name','expanded'=>true,'multiple'=>true,'label'  => 'Reviewers', 'attr' => array('class' =>
                    'checkbox'),))
        ;
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
