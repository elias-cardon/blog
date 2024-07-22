<?php
require './config/constants.php';

try {
    // Établir une connexion à la base de données en utilisant PDO
    $connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    // Définir le mode d'erreur de PDO sur Exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'échec de la connexion, afficher un message d'erreur
    die("Connection failed: " . $e->getMessage());
}