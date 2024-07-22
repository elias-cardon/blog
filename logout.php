<?php
// Inclure le fichier de configuration
require 'backend/config/constants.php';

// Vérifie si une session est démarrée et détruit toutes les sessions
if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy(); // Détruire toutes les sessions actives
}

// Redirige vers la page d'accueil
header('Location: ' . ROOT_URL); // Redirection vers l'URL racine définie dans les constantes
die(); // Arrêter l'exécution du script
