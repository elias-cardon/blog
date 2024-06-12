<?php
require '../admin/config/database.php';
//Fetch current user from database
if (isset($_SESSION['user-id'])){
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
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
    <meta name="keywords" content="HTML, CSS, JavaScript, blog, Jobba, meilleur, Elias, Menace, Article, Star Wars">
    <meta name="author" content="Elias Cardon aka Jobba">
    <title>Le blog de Jobba</title>
    <!--C'est le CSS-->
    <link rel="icon" type="image/png" href="frontend/assets/images/logo.png"/>
    <link rel="stylesheet" href="<?= ROOT_URL?>frontend/assets/style.css">
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
        <a href="<?= ROOT_URL?>" class="nav__logo">Le blog de Jobba</a>
        <ul class="nav__items">
            <li><a href="<?= ROOT_URL?>blog.php">Blog</a></li>
            <li><a href="<?= ROOT_URL?>about.php">A propos</a></li>
            <li><a href="<?= ROOT_URL?>services.php">Services</a></li>
            <li><a href="<?= ROOT_URL?>contact.php">Contact</a></li>
            <?php if (isset($_SESSION['user-id'])) : ?>
            <li class="nav__profile">
                <div class="avatar">
                    <img src="<?= ROOT_URL . 'frontend/assets/images/' . $avatar['avatar'] ?>" alt="Un avatar">
                </div>
                <ul>
                    <li><a href="<?= ROOT_URL?>backend/admin/index.php">Dashboard</a></li>
                    <li><a href="<?= ROOT_URL?>logout.php">Déconnexion</a></li>
                </ul>
            </li>
            <?php else : ?>
            <li><a href="<?= ROOT_URL?>signin.php">Se connecter</a></li>
            <?php endif ?>
        </ul>

        <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
        <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
    </div>
</nav>
<!--==============================END OF NAVBAR=========================================-->

