<?php
// Inclure le fichier de configuration contenant les constantes
require './config/constants.php';

try {
    // Établir une connexion à la base de données en utilisant PDO
    // Ici, on crée une nouvelle instance de PDO en utilisant les constantes définies pour l'hôte, le nom de la base de données, l'utilisateur et le mot de passe.
    $connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);

    // Définir le mode d'erreur de PDO sur Exception
    // Cette ligne configure PDO pour qu'il lance une exception chaque fois qu'une erreur de base de données se produit.
    // Cela permet de gérer les erreurs de manière plus propre et plus sécurisée.
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'échec de la connexion, afficher un message d'erreur
    // Si la connexion échoue, PDO lance une exception qui est capturée ici.
    // La fonction die() arrête l'exécution du script et affiche le message d'erreur.
    die("Connection failed: " . $e->getMessage());
}
?>
