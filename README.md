# virtual_spies

#### Pour le routage
* Installation de altorouter avec  la commande :

```bash
composer require altorouter/altorouter
```
* Mise en place de l'autoloader dans le composer

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    },
    "require": {
        "altorouter/altorouter": "^2.0"
    }
}
```

#### Pour le débugage en mode dev

* Rechargement de l'autoloader de composer et prise en compte des nouvelles configurations au fur et à mesure que l'on en ajoute avec la commande :
```bash
composer dump-autoload
```
* Installation du var-dumper de symfony avec la commande :
```bash
composer require symfony/var-dumper  
```
* Installation de l'outil whoops pour permettre de debugger plus "facilement" avec la commande :
```bash
composer require filp/whoops 
```
#### Pour le mettre en place des fichiers .env

* Mise en place de fichier .env et .env.local avec la commande :
```bash
composer require vlucas/phpdotenv 
```

#### Faker pour remplir la bdd
* Installation de Faker pour générer de fausse donnée dans la base de donnée avec la commande :
```bash
composer require fakerphp/faker 
```

#### Système de validation des données avec Valitron
```bash
composer require vlucas/valitron
```
