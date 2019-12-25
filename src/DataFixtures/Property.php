<?php

namespace App\DataFixtures;

use App\Entity\Property as EntityProperty;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class Property extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=0; $i<100; $i++){
            $property =new EntityProperty();
            $faker = Factory::create('fr_FR');
            $property->setTitle($faker->words(3,true))
                     ->setDescription($faker->sentences(3,true))
                     ->setFloor($faker->numberBetween(3,25))
                     ->setSold($faker->numberBetween(3,25))
                     ->setSurface($faker->numberBetween(3,25))
                     ->setBedrooms($faker->numberBetween(3,25))
                     ->setRooms($faker->numberBetween(3,25))
                     ->setHeat($faker->numberBetween(344,2889))
                     ->setCity( $faker->sentences(3,true))
                     ->setPostalCode($faker->numberBetween(377,2588))
                     ->setPrice($faker->numberBetween(3000,250000))
                      ->setCreatedAt($faker->dateTime())
                     ->setAddress($faker->numberBetween(3,25));

         
                     $manager->persist($property);
                     

        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
