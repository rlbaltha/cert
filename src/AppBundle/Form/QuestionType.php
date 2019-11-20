<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class QuestionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question', CkeditorType::class, array('config_name' => 'editor_default',))
            ->add('position', TextType::class, array('attr' => array('class' => 'text form-control'),))
            ->add('questionset')
            ->add('questionset', EntityType::class, array('class' => 'AppBundle\Entity\Questionset',
                'choice_label' => 'title','expanded'=>false,'multiple'=>false,'label'  => 'Question Set', 'attr' => array('class' =>
                    'form-control'),))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Question'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_question';
    }
}
