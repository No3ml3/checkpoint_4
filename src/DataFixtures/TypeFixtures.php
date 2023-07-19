<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TypeFixtures extends Fixture
{        
    protected array $types = [
        'Hip-Hop',
        'Pop',
        'Variété française',
        'Été',
        'Latino',
        'Rock',
        'Ambiance',
        'Dance',
        'Électro',
        'Indie',
        'Sport',
        'RnB',
        'Afro',
        'K-pop',
        'Dancehall',
        'Zouk',
        'Reggae',
        'Alternatif',
        'Metal',
        'Jazz',
        'Equal',
        'Classique',
        'Folk',
        'Acoustique',
        'Focus',
        'Soul',
        'Enfant',
        'Punk',
        'Country',
        'Ambient',
        'Blues',
        'Arabe',
        'Voyage',
        'Caraïbe',
        'Nature et son',
        'Funk',
        'Frequency',
        'Glow',
        'Animé',
    ];

    protected array $pictures = [
        'https://mdbootstrap.com/img/new/standard/nature/101.webp',
        'https://mdbootstrap.com/img/new/standard/nature/102.webp',
        'https://mdbootstrap.com/img/new/standard/nature/103.webp',
        'https://mdbootstrap.com/img/new/standard/nature/104.webp',
        'https://mdbootstrap.com/img/new/standard/nature/105.webp',
        'https://mdbootstrap.com/img/new/standard/nature/106.webp',
        'https://mdbootstrap.com/img/new/standard/nature/107.webp',
        'https://mdbootstrap.com/img/new/standard/nature/108.webp',
        'https://mdbootstrap.com/img/new/standard/nature/109.webp',
        'https://mdbootstrap.com/img/new/standard/nature/110.webp',
        'https://mdbootstrap.com/img/new/standard/nature/111.webp',
        'https://mdbootstrap.com/img/new/standard/nature/112.webp',
        'https://mdbootstrap.com/img/new/standard/nature/113.webp',
        'https://mdbootstrap.com/img/new/standard/nature/114.webp',
        'https://mdbootstrap.com/img/new/standard/nature/115.webp',
        'https://mdbootstrap.com/img/new/standard/nature/116.webp',
        'https://mdbootstrap.com/img/new/standard/nature/117.webp',
        'https://mdbootstrap.com/img/new/standard/nature/118.webp',
        'https://mdbootstrap.com/img/new/standard/nature/119.webp',
        'https://mdbootstrap.com/img/new/standard/nature/120.webp',
        'https://mdbootstrap.com/img/new/standard/nature/121.webp',
        'https://mdbootstrap.com/img/new/standard/nature/122.webp',
        'https://mdbootstrap.com/img/new/standard/nature/123.webp',
        'https://mdbootstrap.com/img/new/standard/nature/124.webp',
        'https://mdbootstrap.com/img/new/standard/nature/125.webp',
        'https://mdbootstrap.com/img/new/standard/nature/126.webp',
        'https://mdbootstrap.com/img/new/standard/nature/128.webp',
        'https://mdbootstrap.com/img/new/standard/nature/129.webp',
        'https://mdbootstrap.com/img/new/standard/nature/130.webp',
        'https://mdbootstrap.com/img/new/standard/nature/131.webp',
        'https://mdbootstrap.com/img/new/standard/nature/132.webp',
        'https://mdbootstrap.com/img/new/standard/nature/133.webp',
        'https://mdbootstrap.com/img/new/standard/nature/134.webp',
        'https://mdbootstrap.com/img/new/standard/nature/135.webp',
        'https://mdbootstrap.com/img/new/standard/nature/136.webp',
        'https://mdbootstrap.com/img/new/standard/nature/137.webp',
        'https://mdbootstrap.com/img/new/standard/nature/138.webp',
        'https://mdbootstrap.com/img/new/standard/nature/139.webp',
        'https://mdbootstrap.com/img/new/standard/nature/140.webp',
        'https://mdbootstrap.com/img/new/standard/nature/141.webp',
        'https://mdbootstrap.com/img/new/standard/nature/142.webp',
        'https://mdbootstrap.com/img/new/standard/nature/143.webp',
        'https://mdbootstrap.com/img/new/standard/nature/144.webp',
        'https://mdbootstrap.com/img/new/standard/nature/145.webp',
        'https://mdbootstrap.com/img/new/standard/nature/146.webp',
        'https://mdbootstrap.com/img/new/standard/nature/147.webp',
        'https://mdbootstrap.com/img/new/standard/nature/148.webp',
        'https://mdbootstrap.com/img/new/standard/nature/149.webp',
        'https://mdbootstrap.com/img/new/standard/nature/150.webp',
        'https://mdbootstrap.com/img/new/standard/nature/151.webp',
        'https://mdbootstrap.com/img/new/standard/nature/151.webp',
    ];
    public function load(ObjectManager $manager): void
    {
            $faker = Factory::create('fr_FR');
    
            foreach($this->types as $key => $name){
                $type = new Type();
                $type->setName($name);
                $type->setPicture($this->pictures[$faker->numberBetween(0, (count($this->pictures)-1))]);
    
                $this->addReference('type_' . $key, $type);

                $manager->persist($type);
            }

        $manager->flush();
    }
    public function getNumberType(): ?int
    {
        return count($this->types);
    }
}
