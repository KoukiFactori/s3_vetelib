<?php

namespace App\DataFixtures;

use App\Factory\EventFactory;
use App\Factory\TypeEventFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EventFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Tableau stoquant les évennements déjà présents
        $datetimes = [];

        EventFactory::createMany(150, function () use ($datetimes){
            
            // Tant que les évennements se chevauchent, on regénère une nouvelle date
            do {
                $start = EventFactory::faker()->dateTimeThisMonth();
                $start->setTime(
                    EventFactory::faker()->numberBetween(8, 18),
                    EventFactory::faker()->boolean() ? 0 : 30
                );

                $end = clone $start;
                $end->modify('+30 minutes');

                $overlapping = false;
                foreach ($datetimes as $datetime) {
                    if ($start >= $datetime['start'] && $start < $datetime['end']) {
                        $overlapping = true;
                        break;
                    }
                    if ($end > $datetime['start'] && $end <= $datetime['end']) {
                        $overlapping = true;
                        break;
                    }
                }
            } while ($overlapping);

            $events[] = [
                'start' => $start,
                'end' => $end,
            ];

            return ['typeEvent' => TypeEventFactory::random(), 'date' => $start];
        });
    }

    public function getDependencies(): array
    {
        return [
            TypeEventFixture::class,
        ];
    }
}
