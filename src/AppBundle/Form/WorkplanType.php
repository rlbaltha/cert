<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class WorkplanType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'mentor_expectations',
                CkeditorType::class,
                array(
                    'required' => false,
                    'label' => 'Mentor Involvement: Outline the nature and amount of invovlement in your project you expect from your mentor?',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'partners',
                CkeditorType::class,
                array(
                    'required' => false,
                    'label' => 'Resources and Project Partners: What and who will help you complete your project and achieve your goals? ',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'funding',
                CkeditorType::class,
                array(
                    'required' => false,
                    'label' => 'Funding:  Will you need funding to purchase materials? If so, what is your estimated budget? What are your funding sources?',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'objectives',
                CkeditorType::class,
                array(
                    'required' => false,
                    'label' => 'Targets: What are at least 3 long-term, concrete targets? Targets should be Specific, Measurable, Attainable, Relevant, and Timely (SMART).',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'deliverables',
                CkeditorType::class,
                array(
                    'required' => false,
                    'label' => 'Deliverables:  What particular products will this capstone produce?',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'success_metrics',
                CkeditorType::class,
                array(
                    'required' => false,
                    'label' => 'Indicators: How will you know that your project was a success? What qualitative/quantitative metrics will you use to demonstrate this?',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'timeframe',
                TextType::class,
                array(
                    'required' => false,
                    'label' => 'Expected completion date',
                    'attr' => array('class' => 'text form-control'),
                )
            )
            ->add(
                'completion',
                CkeditorType::class,
                array(
                    'required' => false,
                    'label' => 'Completion: At the end of this semester, will your project be complete or will it have future needs? What future needs should be addressed? 
                        Will the project require upkeep? If so, who will maintain it? 
                        If the project will be complete, how will it be wrapped up and documented?
                        ',
                    'config_name' => 'editor_simple',
                )
            )
            ->add(
                'repeatable',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'Yes' => 'Yes',
                        'No' => 'No',
                    ),
                    // *this line is important*
                    'choices_as_values' => true,
                    'label' => 'Could your project be extended or repeated by a student in the future?',
                    'attr' => array('class' => 'text form-control'),
                )
            )
            ->add(
                'repeatinfo',
                CkeditorType::class,
                array(
                    'required' => false,
                    'label' => 'If extendable or repeatable, please explain how.',
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
