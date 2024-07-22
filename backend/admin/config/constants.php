<?php
// Démarrer la session
// La fonction session_start() initialise une nouvelle session ou reprend une session existante.
// Elle est nécessaire pour utiliser les variables de session dans votre application.
session_start();

// Définir l'URL racine du site
// La constante ROOT_URL est définie pour contenir l'URL de base de votre site web.
// Cela permet de gérer plus facilement les liens internes en utilisant cette constante.
define('ROOT_URL', 'http://localhost/blog/');

// Définir les constantes de connexion à la base de données
// Les constantes suivantes sont définies pour stocker les informations de connexion à la base de données.
define('DB_HOST', 'localhost');
define('DB_USER', 'jobba');
define('DB_PASS', '9i51o9vT?');
define('DB_NAME', 'blog');
?>
