# Site pour vétérinaire - Vetelib

## Auteurs

- Maréchal Antoine (mare0055)
- Ledoux Simon (ledo0024)
- Nicolas Mossmann (moss0006)
- Timothe Larget (larg0015)
- Tom Raineri (rain0005)

## Objectif du projet

L'objectif est de créer un site web fonctionnel pour un vétérinaire, afin de lui faciliter différentes tâches. Le site regroupera différentes fonctionnalités, permettant de relier le client avec des professionnels de la santé.

### Lancer le serveur
- `composer start` : Pour démarrer le serveur web
- `bin/console messenger:consume async` : Pour l'envoi des mails

### Style de codage

Le code peut être contrôlé avec :

    composer test:cs

Il peut être reformaté automatiquement avec :
    
    composer fix:cs

### Données

Une base de données est créée sur le compte utilisateur mare0055. La base s'appelle mare0055_contact.

- On peut créer une nouvelle base de données en supprimant l'ancienne, et en y créant des données factices en utilisant la commande : `composer db`