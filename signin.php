<?php
require './backend/config/constants.php';
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
    <link rel="stylesheet" href="frontend/assets/style.css">
    <!--Iconscout CDN-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
</head>
<body>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Connexion</h2>
        <?php if (isset($_SESSION['signup-success'])) : ?>
            <div class="alert__message success">
                <p>
                    <?= $_SESSION['signup-success'];
                    unset($_SESSION['signup-success']);
                    ?>
                </p>
            </div>
        <?php endif; ?>
        <form action="<?= ROOT_URL ?>signin-logic.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="username_email" placeholder="Adresse email ou pseudonyme">
            <input type="password" name="password" placeholder="Mot de passe">
            <button type="submit" name="submit" class="btn">Se connecter</button>
            <small>Pas déjà inscrit ? <a href="signup.php">Inscrivez-vous</a>.</small>
        </form>
    </div>
</section>
</body>
</html>