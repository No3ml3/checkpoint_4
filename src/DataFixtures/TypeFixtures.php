<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TypeFixtures extends Fixture
{        
    public const TYPE = 10;
    public function load(ObjectManager $manager): void
    {


            $faker = Factory::create('fr_FR');
    
            for($i=0; $i < self::TYPE; $i++){
                $type = new Type();
                $type->setName($faker->word());
    
                $this->addReference('type_' . $i, $type);

                $manager->persist($type);
            }

        $manager->flush();
    }
}
