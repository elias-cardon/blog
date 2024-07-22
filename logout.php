<?php
require 'backend/config/constants.php';

// Vérifie si une session est démarrée et détruit toutes les sessions
if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}

// Redirige vers la page d'accueil
header('Location: ' . ROOT_URL);
die();