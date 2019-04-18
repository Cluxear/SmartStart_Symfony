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
use Symfony\Component\Validator\Constraints as Assert;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => true,
                'constraints' => [new Length(['max' => 50])],
                'attr' => [
                    'class' => 'with-border',
                    'placeholder' => 'e.g. build me a website'
                ]
            ])
            ->add('secteur', ChoiceType::class, [
                'choices' => [
                    'Web Development' => 'Web Development',
                    'Mobile Development' => 'Mobile Development',
                    'Data Analytics' => 'Data Analytics',
                    'Design & Creative' => 'Design & Creative',
                    'Software Developing' => 'Software Developing',
                    'IT & Networking' => 'IT & Networking',
                ],
                'attr' => [
                    'class' => 'selectpicker with-border',
                    'data-size' => '4',
                    'title' => 'Select Category'
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
            ->add('budget', NumberType::class, [
                'required' => true,
                'constraints' => [new Assert\Range([
                    'min' => 10.000,
                    'max' => 5000.000,
                    'minMessage' => 'Vous devez entrer un budget superieur a 10',
                    'maxMessage' => 'Vous devez entrer un budget inferieur a 5000',
                ])],
                'attr' => [
                    'class' => 'with-border',
                    'type' => 'text',
                    'placeholder' => 'Budget'
                ]
                ])
            ->add('date_debut', DateType::class, [
                'required' => true,
                'constraints' => [new Assert\Range([
                    'min' => 'now',
                    'minMessage' => 'Vous devez entrer une date superieur a aujourdhui',
                ])],
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'with-border',
                ]
            ])
            ->add('duree',NumberType::class, [
                'required' => true,
                'constraints' => [new Assert\Range([
                    'min' => 1,
                    'max' => 7,
                    'minMessage' => 'Vous devez entrer une duree superieur a 1',
                    'maxMessage' => 'Vous devez entrer une duree inferieur a 7'
                ])],
                'attr' => [
                    'class' => 'with-border',
                    'type' => 'number',
                    'placeholder' => 'Duration'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Post an Event',
                'attr' => [
                    'href' => '#',
                    'class' => 'button ripple-effect big margin-top-30',
                ]
            ])
        ;
    }
}