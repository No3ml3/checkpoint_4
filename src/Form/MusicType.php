<?php

namespace App\Form;

use App\Entity\Music;
use App\Entity\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use function PHPSTORM_META\type;

class MusicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Veuillez écrire le nom de votre musique',
                    'class' => 'm-1 w-100'
                ],
                'label_attr' => [
                    'class' => 'text-dark form-label text-uppercase letter-spacing mt-5'
                ],
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'genre',
                'attr' => [
                    'class' => 'm-1 w-100'
                ],
                'label_attr' => [
                    'class' => 'text-dark form-label text-uppercase letter-spacing mt-4'
                ],
            ])
            ->add('audio', TextType::class, [
                'attr' => [
                    'class' => 'm-1 w-100 mb-4'
                ],
                'label_attr' => [
                    'class' => 'text-dark form-label text-uppercase letter-spacing mt-4'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Music::class,
        ]);
    }
}
