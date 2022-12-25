<?php

namespace App\DataFixtures;

use App\Entity\Espece;
use App\Factory\EspeceFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EspeceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $especeFile = file_get_contents(__DIR__.'/data/Espece.json', false ,null, 0);
        $especes = json_decode($especeFile, true);

        foreach ($especes as $element) {
            $espece = EspeceFactory::createOne($element);
            $manager->persist($espece);
        }
        $manager->flush();        
        
    }
}
