<?php
require __DIR__ . '/../../partials/header.php'; // Inclure l'en-tête

// Vérifier le statut de connexion
if (!isset($_SESSION['user-id'])) {
    // Rediriger vers la page de connexion si non connecté
    header('location: ' . ROOT_URL . 'signin.php');
    die(); // Arrêter le script
}
?>
