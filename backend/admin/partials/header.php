<?php
require __DIR__ . '/../../partials/header.php';

// Vérifier le statut de connexion
if (!isset($_SESSION['user-id'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}
?>
