<?php

namespace App\DataFixtures;

use App\Factory\TypeEventFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeEventFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
        TypeEventFactory::createOne([['typeEvent' => 0],[ 'typeEvent' => 1]]);    // 0 = Non urgent ; 1 = Urgent
    }
}
