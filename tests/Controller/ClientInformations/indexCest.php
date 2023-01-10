<?php

namespace App\Tests\Controller\ClientInformations;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class indexCest
{
    // Vérifier le bon chargement de la page
    public function chargementPage(ControllerTester $I)
    {
        // Création d'un utilisateur Client
        $user = UserFactory::createOne(['lastname' => 'Ledoux', 'firstname' => 'Simon', 'email' => 'simon@simon511000.fr', 'roles' => ['ROLE_CLIENT'], 'password' => 'password','phone' => '0654685216', 'birthdate' => new \cr, 'city' => 'Paris', 'zipcode' => '75000', 'address' => '1 rue de la paix']);

        $user = $user->object();
        $I->amLoggedInAs($user);

        $I->amOnPage('/client-informations');
        $I->seeResponseCodeIs(200);
    }
}
