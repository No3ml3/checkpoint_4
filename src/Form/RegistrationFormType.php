<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichFileType;

class RegistrationFormType extends AbstractType
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
                    'class' => 'text-dark form-label text-uppercase letter-spacing mt-4'
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'm-1 w-100'
                ],
                'label_attr' => [
                    'class' => 'text-dark form-label text-uppercase letter-spacing mt-4'
                ],
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Anniversaire',
                'attr' => [
                    'class' => 'm-1 w-100'
                ],
                'label_attr' => [
                    'class' => 'text-dark form-label text-uppercase letter-spacing mt-4'
                ],
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays',
                'attr' => [
                    'class' => 'm-1 w-100'
                ],
                'label_attr' => [
                    'class' => 'text-dark form-label text-uppercase letter-spacing mt-4'
                ],
            ])
            ->add('speudo', TextType::class, [
                'label' => 'Pseudo',
                'attr' => [
                    'class' => 'm-1 w-100'
                ],
                'label_attr' => [
                    'class' => 'text-dark form-label text-uppercase letter-spacing mt-4'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'm-1 w-100'
                ],
                'label_attr' => [
                    'class' => 'text-dark form-label text-uppercase letter-spacing mt-4'
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
                    'class' => 'text-dark form-label text-uppercase letter-spacing mt-4'
                ],
            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'm-1 w-100 mb-3'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'text-dark form-label text-uppercase letter-spacing mt-4'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
