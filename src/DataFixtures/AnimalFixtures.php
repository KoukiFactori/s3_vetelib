<?php

namespace App\DataFixtures;

use Factory\AnimalFactory;
use Factory\EspeceFactory;
use Factory\ClientFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnimalFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       AnimalFactory::createMany(150, function () { 
        return ['espece' => EspeceFactory::random(),
        'client' => ClientFactory::random()];
       });

    }
    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            ClientFixtures::class,
        ];
    }
}
