<?php
// Inclure le fichier de configuration de la base de données
require __DIR__ . '/../config/database.php';

// Récupérer l'utilisateur actuel de la base de données
if (isset($_SESSION['user-id'])) {
    // Filtrer et sécuriser l'ID de l'utilisateur
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);

    // Préparer la requête pour récupérer l'avatar et le statut admin de l'utilisateur
    $query = "SELECT avatar, is_admin FROM users WHERE id = :id";
    $stmt = $connection->prepare($query); // Préparer la requête
    $stmt->execute(['id' => $id]); // Exécuter la requête avec le paramètre
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Récupérer le résultat
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="C'est le blog de Jobba, le meilleur de France.">
    <meta name="keywords" content="HTML, CSS, JavaScript, blog, Jobba, meilleur, Elias, Article, Star Wars">
    <meta name="author" content="Elias Cardon aka Jobba">
    <title>Le blog de Jobba</title>
    <!--C'est le CSS-->
    <link rel="icon" type="image/png" href="<?= ROOT_URL ?>frontend/assets/images/logo.png"/>
    <link rel="stylesheet" href="<?= ROOT_URL ?>frontend/assets/style.css">
    <!--Iconscout CDN-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
</head>
<body>
<!--==============================NAVBAR=========================================-->
<nav>
    <div class="container nav__container">
        <a href="<?= ROOT_URL ?>" class="nav__logo">Le blog de Jobba</a> <!-- Lien vers la page d'accueil -->
        <ul class="nav__items">
            <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li> <!-- Lien vers la page du blog -->
            <li><a href="<?= ROOT_URL ?>about.php">A propos</a></li> <!-- Lien vers la page à propos -->
            <li><a href="<?= ROOT_URL ?>services.php">Services</a></li> <!-- Lien vers la page des services -->
            <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li> <!-- Lien vers la page de contact -->
            <?php if (isset($_SESSION['user-id'])) : ?> <!-- Vérifier si l'utilisateur est connecté -->
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?= ROOT_URL . 'frontend/assets/images/' . $user['avatar'] ?>" alt="Un avatar"> <!-- Afficher l'avatar de l'utilisateur -->
                    </div>
                    <ul>
                        <li><a href="<?= ROOT_URL ?>backend/admin/index.php">Dashboard</a></li> <!-- Lien vers le tableau de bord -->
                        <?php if ($user['is_admin']) : ?> <!-- Vérifier si l'utilisateur est administrateur -->
                            <li><a href="<?= ROOT_URL ?>backend/admin/edit-profile.php">Modif. profil</a></li> <!-- Lien vers la modification du profil -->
                        <?php endif; ?>
                        <li><a href="<?= ROOT_URL ?>logout.php">Déconnexion</a></li> <!-- Lien pour se déconnecter -->
                    </ul>
                </li>
            <?php else : ?> <!-- Si l'utilisateur n'est pas connecté -->
                <li><a href="<?= ROOT_URL ?>signin.php">Se connecter</a></li> <!-- Lien vers la page de connexion -->
            <?php endif ?>
        </ul>

        <button id="open__nav-btn"><i class="uil uil-bars"></i></button> <!-- Bouton pour ouvrir la navigation -->
        <button id="close__nav-btn"><i class="uil uil-multiply"></i></button> <!-- Bouton pour fermer la navigation -->
    </div>
</nav>
<!--==============================FIN DE LA NAVBAR=========================================-->
