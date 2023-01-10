<?php

namespace App\Tests\Controller\ClientInformations;

use App\Entity\Client;
use App\Factory\ClientFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    // Vérifier le bon chargement de la page
    public function chargementPage(ControllerTester $I)
    {
        // Création d'un utilisateur Client
        $user = ClientFactory::createOne(['lastname' => 'Ledoux', 'firstname' => 'Simon', 'email' => 'simon@simon511000.fr', 'roles' => ['ROLE_CLIENT'], 'password' => 'password', 'phone' => '0654685216', 'birthdate' => new \DateTime('1970-01-01'), 'city' => 'Paris', 'zipcode' => '75000', 'address' => '1 rue de la paix']);

        /** @var(Client) */
        $user = $user->object();
        $I->amLoggedInAs($user);

        $I->amOnRoute('app_client_informations');
        $I->seeResponseCodeIs(200);
    }
}
