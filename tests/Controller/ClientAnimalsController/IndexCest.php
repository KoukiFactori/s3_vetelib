<?php


namespace App\Tests\Controller\ClientAnimalsController;

use App\Factory\ClientFactory;
use App\Tests\Support\ControllerTester;
use App\Factory\AnimalFactory;

class IndexCest
{
    // Vérifier le bon chargement de la page
    public function chargementPage(ControllerTester $I)
    {
        // Création d'un utilisateur Client
        $user = ClientFactory::createOne(['lastname' => 'Ledoux', 'firstname' => 'Simon', 'email' => 'simon@simon511000.fr', 'roles' => ['ROLE_CLIENT'], 'password' => 'password', 'phone' => '0654685216', 'birthdate' => new \DateTime('1970-01-01'), 'city' => 'Paris', 'zipcode' => '75000', 'address' => '1 rue de la paix']);

        //Creation de plusieurs animal pour l'utilisateur 
        $animals = AnimalFactory::createMany(3, ['client' => $user]);
        /** @var(Client) */
        $user = $user->object();
        $I->amLoggedInAs($user);

        $I->amOnRoute('app_client_animals');
        $I->seeResponseCodeIs(200);
        $I->seeNumberOfElements('.animal', 3);


    }

}
