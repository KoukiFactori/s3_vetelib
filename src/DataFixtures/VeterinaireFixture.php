<?php

namespace App\DataFixtures;

use App\Factory\VeterinaireFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VeterinaireFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
        VeterinaireFactory::createMany(5);
    }
}
