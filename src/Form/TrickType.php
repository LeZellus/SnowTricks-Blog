<?php

namespace App\Form;

use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mainThumb', FileType::class, [
                'mapped' => false,
                'required' => false,
                "constraints" => [
                    new File([
                        "maxSize" => "3M",
                        "mimeTypes" => [
                            "image/png",
                            "image/jpg",
                            "image/jpeg",
                            "image/gif"
                        ],
                        "mimeTypesMessage" => "Veuillez envoyer une image au format png, jpg, jpeg ou gif, de 10 mégas octets maximum"
                    ])
                ]
            ])
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => [
                    'label' => false
                ],
                'label' => false,
                'required' => false,
                'prototype' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}