<?php

namespace App\DataFixtures;

use App\Entity\Music;
use App\DataFixtures\TypeFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MusicFixtures extends Fixture implements DependentFixtureInterface
{
    public const MUSIC = 100;
    public function load(ObjectManager $manager): void
    {
            $faker = Factory::create('fr_FR');
    
            for($i=0; $i < self::MUSIC; $i++){
                $music = new Music();
                $music->setName($faker->word(). $faker->firstName());
    
                $music->setType($this->getReference('type_' . $faker->numberBetween(1, TypeFixtures::TYPE -1)));

                $this->addReference('music_' . $i, $music);

                $manager->persist($music);
            }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            TypeFixtures::class,
        ];
    }
}

