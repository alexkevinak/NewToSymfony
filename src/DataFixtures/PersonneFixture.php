<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PersonneFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 100; $i++){
            $personne = new Personne();
            $personne->setName($faker->name);
            $personne->setFirstname($faker->firstName);
            $personne->setAge($faker->numberBetween(16,52));
            $personne->setJob($faker->company);

            $manager->persist($personne);
        }

        $manager->flush();
    }
}
