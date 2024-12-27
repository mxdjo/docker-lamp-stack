<?php

const DBHOST = 'db';
const DBUSER = 'test';
const DBPASS = 'pass';
const DBNAME = 'demo';

$dsn = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME . ';charset=utf8';

try {
    // Création de l'instance PDO avec options
    $db = new PDO($dsn, DBUSER, DBPASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Activer les exceptions pour les erreurs SQL
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Définir le mode de récupération par défaut
        PDO::ATTR_EMULATE_PREPARES => false, // Désactiver les requêtes préparées émulées
    ]);

    echo 'Connecté à la base de données avec succès.';
} catch (PDOException $exception) {
    // Gérer les exceptions et afficher un message d'erreur clair
    echo 'Une erreur est survenue lors de la connexion : ' . $exception->getMessage();
    die;
}

