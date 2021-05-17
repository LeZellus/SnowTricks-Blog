<?php

namespace App\Form;

use App\Entity\Thumb;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ThumbType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('thumb', FileType::class, [
                'label' => 'Image à la une',
                'mapped' => false,
                'required' => true,
            ])
            ->add('isMain', CheckboxType::class, [
                'label'=> 'photo à la une',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Thumb::class,
        ]);
    }
}
