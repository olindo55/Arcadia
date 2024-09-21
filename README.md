# Arcadia
Cette application web a été créée dans le cadre de l'ECF (Evaluation en Cours de Formation) organisé par le centre de formation [STUDI](https://www.studi.com/fr).
Elle a pour but de préparer à l’examen pour l’obtention du Titre Professionnel Développeur Web et Web Mobile ([RNCP 37674](https://www.francecompetences.fr/recherche/rncp/37674/)).

Retrouvez la version [en ligne](www.google.com)

## Le sujet
Arcadia, un zoo situé près de la forêt de Brocéliande en Bretagne, souhaite développer une application web pour améliorer l'expérience des visiteurs et promouvoir son engagement écologique. Dirigé par José, fier de l'indépendance énergétique du zoo, l'objectif est de créer une plateforme reflétant ces valeurs. Le zoo est organisé en habitats (savane, jungle, marais) avec des animaux répartis par environnement. Les vétérinaires effectuent des contrôles réguliers sur la santé des animaux, et ces informations doivent être accessibles via l'application ainsi que l'administration du site web et des informations relatives à la nourritures données aux animaux.

## Stack technique
- Coté Serveur :
  - PHP (vanilla)
  - Composer
  - Base de données :
    - MySQL
    - MongoDB
- Coté Client :
  - Javascript (vanilla)
  - [Bootstrap 5](https://getbootstrap.com/docs/5.0/getting-started/introduction/)
  - [Splide](https://splidejs.com/)
- SASS
- Docker

## Installation locale
### Prérequis :
Votre machine doit avoir ces logiciels installés :
- git
- docker (démarré)
- éditeur de texte

### Procédure :
1. Créer un repertoire sur votre machine
2. Dans un terminal, positionnez vous dans ce repertoire, exemple de commande :
    ```shell
    cd monRepertoire
3. Cloner le dépot GitHub dans un répertoire local 
   ```shell
    git clone https://github.com/olindo55/Arcadia.git  
4. Positionnez vous dans le repertoire `Arcadia` :
    ```shell
    cd Arcadia
5. Créez, à la racine du dossier `Arcadia`, un fichier nommé `.env`. Avec un éditeur de texte, collez les informations ci-dessous et modifier les variables d'environement. Remplacez le texte entre chevrons `<>` par vos propres paramêtres et modifiez, éventuellement, les ports selon votre installation.
   ```Plain Text
   # MySQL
    MYSQL_ROOT_PASSWORD=<motDePasseRoot> # Mot de passe pour l'utilisateur root
    MYSQL_DATABASE=olindo55_arcadia # Nom de la Database
    MYSQL_USER=<nomUser> # Nom de l'utilisateur
    MYSQL_PASSWORD=<motDePasseUser> # Mot de passe de l'utilisateur
    MYSQL_PORT=3306 # Port pour MySQL
    INIT_SQL_FILE=arcadia.sql # Pour initialisation de la base de données

    # PhpMyAdmin
    PMA_PORT=8898 # Port d'accès à PhpMyAdmin

    # Application
    SERVER_PORT=8000 # Port d'accès à l'application
6. Pour les possesseur de Mac et Linux, tapez cette commande :
   ```shell
   chmod +x init-scripts/init.sh
7. De retour sur le terminal, lancer cette commande :
   ```shell
   docker-compose up --build
8. Une fois le build executé (ca peux prendre plusieurs minutes),  accedez à l'application via votre navigateur à l'adresse : `http://localhost:8000`. Bien entendu, changez le port par celui que vous avez choisi dans `SERVER_PORT` du le fichier `.env` 
9. Vous pouvez accéder aussi à PhpMyAdmin : `http://localhost:8899` (ou selon le port si vous avez changer la variable d'environement `PMA_PORT`)

