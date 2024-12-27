## Docker-compose of a LAMP stack ##

* Actuellement on peut changer la PHP version: Avant d'executer le docker-compose, definir dans un fichier .env la version PHP (PHP_VERSION=XX)

## Explication du docker-compose.yml ##


Ce fichier `docker-compose.yml` permet de définir et de lancer trois services Docker : PHP avec Apache, MySQL, et phpMyAdmin. Chaque service est configuré pour interagir avec les autres via un réseau commun.

### 1. Version de Docker Compose

```yaml
version: '3.8'
```
Cette instruction Spécifie la version de Docker Compose utilisée

### 2. Services

#### Service PHP

```yaml
php:
  container_name: php${PHP_VERSION:-8.2}
  ports:
    - 8000:80
  volumes:
    - ./php:/var/www/html
  build:
    context: .
    dockerfile: Dockerfile
    args:
      PHP_VERSION: "${PHP_VERSION:-8.2}"
  networks:
    - my_network
```
* container_name : Définit le nom du conteneur. Utilise la version de PHP spécifiée dans la variable d'environnement PHP_VERSION, avec une valeur par défaut de 8.2.
* ports : Le port 80 du conteneur (Apache) est lié au port 8000 de l'hôte. Vous pouvez accéder au serveur PHP via http://localhost:8000.
* volumes : Le dossier local ./php est monté dans le conteneur à /var/www/html, permettant d'accéder et de modifier les fichiers du site web.
* build : Le conteneur est construit à partir d'un Dockerfile. Le fichier Dockerfile permet de personnaliser l'image PHP.
* networks : Le service est connecté au réseau my_network

#### Service MySQL

Ce service lance un conteneur MySQL pour la gestion des bases de données.

Configuration:

```yaml
db:
  image: mysql:8.0
  container_name: mysql8
  command: --default-authentication-plugin=caching_sha2_password
  environment:
    MYSQL_ROOT_PASSWORD: pass
    MYSQL_DATABASE: demo
    MYSQL_USER: test
    MYSQL_PASSWORD: pass
  ports:
    - 3307:3306
  networks:
    - my_network
```

* image : Utilise l'image officielle MySQL version 8.0.
* container_name : Le conteneur sera nommé mysql8.
* command : Définit un plugin d'authentification pour MySQL (caching_sha2_password).
* environment : Configure des variables d'environnement pour MySQL :

   - MYSQL_ROOT_PASSWORD : Mot de passe pour l'utilisateur root.
   - MYSQL_DATABASE : Crée une base de données appelée demo.
   - MYSQL_USER et MYSQL_PASSWORD : Crée un utilisateur test avec un mot de passe pass.

* ports : Le port 3306 du conteneur (port MySQL par défaut) est lié au port 3307 de l'hôte. Vous pouvez accéder à MySQL via le port 3307.
* networks : Le service est connecté au réseau my_network

#### Service phpmyadmin

Ce service lance phpMyAdmin, une interface web pour gérer MySQL.

```yaml
phpma:
  image: phpmyadmin/phpmyadmin
  container_name: phpmyadmin
  environment:
    PMA_ARBITRARY: 1
    PMA_HOST: db
    PMA_USER: root
    PMA_PASSWORD: pass
    UPLOAD_LIMIT: 20M
  ports:
    - 8899:80
  networks:
    - my_network
```
* image : Utilise l'image officielle phpMyAdmin.
* container_name : Le conteneur sera nommé phpmyadmin.
* environment : Configure des variables d'environnement pour phpMyAdmin :

   - PMA_ARBITRARY: 1 : Permet de se connecter à n'importe quel serveur MySQL.
   - PMA_HOST : Le nom d'hôte du serveur MySQL, ici db.
   - PMA_USER et PMA_PASSWORD : Identifiants pour se connecter à MySQL.

* ports : Le port 80 du conteneur (port phpMyAdmin) est lié au port 8899 de l'hôte. Vous pouvez accéd a phpMyAdmin via http://localhost:8899.
networks : Le service est connecté au réseau my_network

### Network

```yaml
networks:
  my_network:
    driver: bridge
```
Ce fichier docker-compose.yml permet de créer une pile complète pour le développement d'une application PHP avec MySQL et phpMyAdmin, tous les services étant interconnectés via un réseau commun. Vous pouvez ainsi facilement gérer votre application et votre base de données dans des conteneurs Docker isolés et configurables.

