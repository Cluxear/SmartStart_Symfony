<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 4/14/2019
 * Time: 3:04 PM
 */

namespace EvenementBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => true,
                'constraints' => [new Length(['max' => 50])]
            ])
            ->add('secteur', ChoiceType::class, [
                'choices' => [
                    'DevWeb' => 'DevWeb',
                    'DevMobile' => 'DevMobile',
                    'Design' => 'Design',

                ],
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'constraints' => [new Length(['min' => 100])]
            ])
            ->add('budget', NumberType::class)
            ->add('date_debut', DateType::class)
            ->add('duree',NumberType::class)
            ->add('save', SubmitType::class)
        ;
    }
}