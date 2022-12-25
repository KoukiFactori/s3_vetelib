<?php

namespace App\DataFixtures;

use App\Factory\EventFactory;
use App\Factory\TypeEventFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
        EventFactory::createMany(140, function () {
            return ['typeEvent' => TypeEventFactory::random()];
        });
    }

    public function getDependencies(): array
    {
        return [
            TypeEventFixture::class,
        ];
    }
}
