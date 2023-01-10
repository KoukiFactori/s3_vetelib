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

    // Vérifier que le formulaire est bien rempli
    public function remplissageFormulaire(ControllerTester $I)
    {
        // Création d'un utilisateur Client
        $user = ClientFactory::createOne(['lastname' => 'Ledoux', 'firstname' => 'Simon', 'email' => 'simon2@simon511000.fr', 'roles' => ['ROLE_CLIENT'], 'password' => 'password', 'phone' => '0654685216', 'birthdate' => new \DateTime('1970-01-01'), 'city' => 'Paris', 'zipcode' => '75000', 'address' => '1 rue de la paix']);

        /** @var(Client) */
        $user = $user->object();
        $I->amLoggedInAs($user);

        $I->amOnRoute('app_client_informations');
        $I->seeInField('form input#user_lastname.champs', 'Ledoux');
        $I->seeInField('form input#user_firstname.champs', 'Simon');
        $I->seeInField('form input#user_email.champs', 'simon2@simon511000.fr');
        $I->seeInField('form input#user_phone', '0654685216');
        $I->seeInField('form input#user_city', 'Paris');
        $I->seeInField('form input#user_zipcode', '75000');
        $I->seeInField('form input#user_address', '1 rue de la paix');
        //$I->seeInField('#user_birthdate_day option[selected]', 16);
    }
}
