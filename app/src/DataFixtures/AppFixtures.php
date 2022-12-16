<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\CarCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\CarData;
use Faker\Provider\Fakecar;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // faker
        $faker = Factory::create();
        $faker->addProvider(new Fakecar($faker));

        $suvCategory = new CarCategory();
        $suvCategory->setName("SUV");

        $berlineCategory = new CarCategory();
        $berlineCategory->setName("Berline");

        $citadineCategory = new CarCategory();
        $citadineCategory->setName("Citadine");

        $manager->persist($suvCategory);
        $manager->persist($berlineCategory);
        $manager->persist($citadineCategory);


        for($i=0; $i<50; $i++){
            $car = new Car();
            $car->setName($faker->vehicle);
            $car->setCost(rand(1000, 8000)); // a random cost between 1000 and 8000 euros
            $car->setNbSeats($faker->vehicleSeatCount);
            $car->setNbDoors($faker->vehicleDoorCount);

            $car->setCategory(
                rand(0, 1) === 1 ? $suvCategory : $berlineCategory
            );

            $manager->persist($car);
        }
        $manager->flush();

    }
}
