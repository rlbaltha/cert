<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\Status;
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
            ->add('firstname', 'text', array('label' => 'First Name', 'attr' => array('class' => 'form-control'),))
            ->add('lastname', 'text', array('label' => 'Last Name','attr' => array('class' => 'form-control'),))
            ->add('progress', 'entity', array('required' => true, 'class' => 'AppBundle\Entity\Status',
                'property' => 'name', 'expanded' => false, 'multiple' => false, 'label' => 'Status', 'attr' => array
                ('class' => 'form-control'),))
            ->add('altemail', 'text', array('required' => false, 'label' => 'Alternative Email Account','attr' => array('class' => 'form-control'),))
            ->add('notes', 'ckeditor', array('config_name' => 'editor_simple',))
            ->add('peermentor', 'entity', array('class' => 'AppBundle\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.progress', 'p')
                        ->join('u.program', 'pr')
                        ->andWhere(':tag MEMBER OF u.tags')
                        ->setParameter('tag', '103')
                        ->addOrderBy('u.lastname', 'ASC')
                        ->addOrderBy('u.firstname', 'ASC');
                },
                'required' => false, 'property' => 'name', 'expanded' => true, 'multiple' => false, 'label' => 'Mentor', 'attr' => array('class' =>
                    'checkbox'),))
            ->add('tags', 'entity', array('class' => 'AppBundle\Entity\Tag',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->andWhere("t.type = 'user'")
                        ->addOrderBy('t.sortorder', 'ASC');
                },
                'required' => false, 'property' => 'title', 'expanded' => true, 'multiple' => true, 'label' => 'Status/Progress', 'attr' => array('class' =>
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
