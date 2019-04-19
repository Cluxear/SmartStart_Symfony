<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 4/19/2019
 * Time: 3:02 AM
 */

namespace EvenementBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;

class ParticipationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => true,
                'constraints' => [new Length(['max' => 50])],
                'attr' => [
                    'class' => 'with-border',
                    'placeholder' => 'e.g. Responsive website'
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'constraints' => [new Length(['min' => 100])],
                'attr' =>  [
                    'cols' => '30',
                    'rows' => '5',
                    'class' => 'with-border'
                ]
            ])
            ->add('fichier', FileType::class, [
                'label' => 'Brochure (PDF file)'

            ])
            ->add('save', SubmitType::class, [
                'label' => 'Participate Now',
                'attr' => [
                    'class' => 'button margin-top-35 full-width button-sliding-icon ripple-effect',
                ]
            ])
            ;
    }
}