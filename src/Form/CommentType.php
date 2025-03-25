<?php

namespace MyBasicModule\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    "placeholder" => "The name",
                ]
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    "placeholder" => "The description"
                ]
            ])
            ->add('price', NumberType::class, [
                'attr' => [
                    "placeholder" => "The price"
                ]
            ]);
            // ->add('save', SubmitType::class, [
            //     'attr' => [
            //         "class" => "btn-primary",
            //         'label' => 'Save'
            //     ]
            // ]);
    }
}