<?php

namespace App\DataFixtures;

use App\Entity\Music;
use App\DataFixtures\TypeFixtures;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MusicFixtures extends Fixture implements DependentFixtureInterface
{
    public const MUSIC_COUNT = 100;
    public array $musicArray = [
        'music1.mp3',
        'music2.mp3',
        'music3.mp3',
        'music4.mp3',
        'music5.mp3',
        'music6.mp3',
        'music7.mp3',
        'music8.mp3',
        'music9.mp3',
        'music10.mp3',
        'music11.mp3',
        'music12.mp3',
        'music13.mp3',
    ];
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $type = new TypeFixtures;

        for ($i = 0; $i < self::MUSIC_COUNT; $i++) {
            $music = new Music();
            $music->setName($faker->word() . $faker->firstName());
            $music->setAudio($this->musicArray[$faker->numberBetween(0, (count($this->musicArray)-1))]);

            $music->setType($this->getReference('type_' . $faker->numberBetween(1, $type->getNumberType()- 1)));

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
