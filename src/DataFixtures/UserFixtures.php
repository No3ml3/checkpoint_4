<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\DataFixtures\MusicFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public const ARTISTS = 10;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::ARTISTS; $i++) {
            $user = new User();
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->firstName());
            $user->setEmail($faker->email());

            for ($j = 0; $j < $faker->numberBetween(1, 300); $j++) {
                $user->addMusic($this->getReference('music_' . $faker->numberBetween(1, MusicFixtures::MUSIC - 1)));
            }

            $this->addReference('user_' . $i, $user);

            $manager->persist($user);
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            MusicFixtures::class,
        ];
    }
}
