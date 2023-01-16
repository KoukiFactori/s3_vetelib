<?php


namespace App\Tests\Repository;

use App\Factory\AnimalFactory;
use App\Factory\ClientFactory;
use App\Factory\EspeceFactory;
use App\Factory\EventFactory;
use App\Factory\TypeEventFactory;
use App\Factory\VeterinaireFactory;
use App\Tests\Support\RepositoryTester;
use DateTime;

class VeterinaireCest
{
    public function getEventsOn()
    {
        // Génération des données nécessaires pour ce test
        $espece = EspeceFactory::createOne();
        $client = ClientFactory::createOne();
        AnimalFactory::createOne([
            'espece' => $espece,
            'client' => $client
        ]);

        $veto = VeterinaireFactory::createOne();

        $typeEvent = TypeEventFactory::createOne([
            'libType' => 'Non Urgent'
        ]);

        // Création des évènements
        EventFactory::createOne([
            'typeEvent' => $typeEvent,
            'date' => date_create_from_format('d/m/Y G:i', '01/01/2023 08:00'),
            'veterinaire' => $veto
        ]);
        EventFactory::createOne([
            'typeEvent' => $typeEvent,
            'date' => date_create_from_format('d/m/Y G:i', '01/01/2023 08:30'),
            'veterinaire' => $veto
        ]);

        
    }
}
