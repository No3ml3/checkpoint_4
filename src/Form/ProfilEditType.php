<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProfilEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'm-1 w-100'
                ],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mt-4'
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'm-1 w-100'
                ],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mt-4'
                ],
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Anniversaire',
                'attr' => [
                    'class' => 'm-1 w-100'
                ],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mt-4'
                ],
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays',
                'attr' => [
                    'class' => 'm-1 w-100'
                ],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mt-4'
                ],
            ])
            ->add('speudo', TextType::class, [
                'label' => 'Pseudo',
                'attr' => [
                    'class' => 'm-1 w-100'
                ],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mt-4'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'm-1 w-100'
                ],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mt-4'
                ],
            ])
            ->add('imagesUser', VichFileType::class, [
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
                'label' => 'Image',
                'attr' => [
                    'class' => 'm-1 w-100'
                ],
                'label_attr' => [
                    'class' => 'form-label text-uppercase letter-spacing mt-4'
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
