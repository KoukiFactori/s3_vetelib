<?php

namespace App\Tests\Controller\ClientInformations;

use App\Entity\Client;
use App\Factory\ClientFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function login(ControllerTester $I) {
        $user = ClientFactory::createOne([
            'lastname' => 'Ledoux',
            'firstname' => 'Simon',
            'email' => 'simon@simon511000.fr',
            'roles' => ['ROLE_CLIENT'],
            'password' => 'password',
            'phone' => '0654685216',
            'birthdate' => new \DateTime('1970-01-01'),
            'city' => 'Paris',
            'zipcode' => '75000',
            'address' => '1 rue de la paix'
        ]);

        $I->amLoggedInAs($user->object());
    }

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
        // $I->seeInField('#user_birthdate_day option[selected]', 16);
    }

    // Modifier les données et vérifier que celles-ci sont bien modifiés
    public function checkPersistanceDonnées(ControllerTester $I)
    {
        // Création d'un utilisateur Client
        $user = ClientFactory::createOne(['lastname' => 'Ledoux', 'firstname' => 'Simon', 'email' => 'simon3@simon511000.fr', 'roles' => ['ROLE_CLIENT'], 'password' => 'password', 'phone' => '0654685216', 'birthdate' => new \DateTime('1970-01-01'), 'city' => 'Paris', 'zipcode' => '75000', 'address' => '1 rue de la paix']);

        /** @var(Client) */
        $user = $user->object();

        $I->amLoggedInAs($user);
        $I->amOnRoute('app_client_informations');

        // Modifier le client avec de nouvelles données
        $I->submitForm('form[name=user]', [
            'user[lastname]' => 'Leroi',
            'user[firstname]' => 'Michel',
            'user[email]' => 'leroi.michel@example.com',
            'user[phone]' => '0614756412',
            'user[birthdate]' => '1985-12-31',
            'user[city]' => 'MichelCity',
            'user[zipcode]' => '17645',
            'user[address]' => '8 rue des Michels',
        ]);

        // Regarder si les modifications ont été effectuées
        $I->seeInField('form input#user_lastname.champs', 'Leroi');
        $I->seeInField('form input#user_firstname.champs', 'Michel');
        $I->seeInField('form input#user_email.champs', 'leroi.michel@example.com');
        $I->seeInField('form input#user_phone', '0614756412');
        $I->seeInField('form input#user_city', 'MichelCity');
        $I->seeInField('form input#user_zipcode', '17645');
        $I->seeInField('form input#user_address', '8 rue des Michels');
    }

    // Vérifier bonne deconnexion

    public function deconnexion(ControllerTester $I)
    {
        // Création d'un utilisateur Client
        $user = ClientFactory::createOne(['lastname' => 'Ledoux', 'firstname' => 'Simon', 'email' => 'simon3@simon511000.fr', 'roles' => ['ROLE_CLIENT'], 'password' => 'password', 'phone' => '0654685216', 'birthdate' => new \DateTime('1970-01-01'), 'city' => 'Paris', 'zipcode' => '75000', 'address' => '1 rue de la paix']);

        /** @var(Client) */
        $user = $user->object();

        $I->amLoggedInAs($user);
        $I->amOnRoute('app_client_informations');

        // Le prénom et nom sont bien affiché en haut à droite -> on est bien connecté
        $I->see('Simon Ledoux', 'li.nav--primary');

        // On se déconnecte et on vérifie qu'on arrive bien sur la page de connexion
        $I->click('.bouton_deconnexion a');
        $I->amOnRoute('app_login');
    }
}
