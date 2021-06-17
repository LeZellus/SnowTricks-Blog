<?php

namespace App\Form;

use App\Entity\Thumb;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MultipleImagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'label' => 'Ajouter une image',
                'required' => false,
                'label_attr' => ['class' => 'block text-sm font-medium text-gray-700'],
                'attr' => ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm'],
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
