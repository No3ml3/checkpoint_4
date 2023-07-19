<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\DataFixtures\MusicFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public const ARTISTS = 50;
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::ARTISTS; $i++) {
            $user = new User();
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->email());
            $user->setRoles(['ROLE_USER']);
            $user->setCountry($faker->country());
            $user->setBirthday($faker->dateTimeThisCentury());

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                'userpassword'
            );
            $user->setPassword($hashedPassword);

            for ($j = 0; $j < $faker->numberBetween(1, 300); $j++) {
                $user->addMusic($this->getReference('music_' . $faker->numberBetween(0, MusicFixtures::MUSIC_COUNT - 1)));
            }

            for ($k = 0; $k < $faker->numberBetween(1, 30); $k++) {
                $user->addFavorite($this->getReference('music_' . $faker->numberBetween(0, MusicFixtures::MUSIC_COUNT - 1)));
            }
            

            $this->addReference('user_' . $i, $user);

            $manager->persist($user);
        }

        $user = new User();
        $user->setFirstName('Noémie');
        $user->setLastName('BARRÉ');
        $user->setEmail('nbarre14@sfr.fr');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setCountry('FRANCE');
        $user->setBirthday($faker->dateTimeThisCentury());
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'adminpassword'
        );
        $user->setPassword($hashedPassword);

        $manager->persist($user);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            MusicFixtures::class,
        ];
    }
}
