<?php
// Inclure le fichier de configuration
require './backend/config/constants.php';

// Récupérer les données de session si elles existent
$username_email = $_SESSION['signin-data']['username_email'] ?? ''; // Récupérer l'email ou le pseudonyme de la session
$password = $_SESSION['signin-data']['password'] ?? ''; // Récupérer le mot de passe de la session

// Supprimer les données de session après les avoir récupérées
unset($_SESSION['signin-data']);
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
        <?php if (isset($_SESSION['signup-success'])) : ?> <!-- Vérifier s'il y a un message de succès d'inscription -->
            <div class="alert__message success">
                <p>
                    <?= $_SESSION['signup-success']; // Afficher le message de succès
                    unset($_SESSION['signup-success']); // Supprimer le message de la session
                    ?>
                </p>
            </div>
        <?php elseif(isset($_SESSION['signin'])): ?> <!-- Vérifier s'il y a un message d'erreur de connexion -->
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['signin']; // Afficher le message d'erreur
                    unset($_SESSION['signin']); // Supprimer le message de la session
                    ?>
                </p>
            </div>
        <?php endif; ?>
        <form action="<?= ROOT_URL ?>signin-logic.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="username_email" value="<?= htmlspecialchars($username_email) ?>" placeholder="Adresse email ou pseudonyme"> <!-- Champ pour l'email ou le pseudonyme -->
            <input type="password" name="password" value="<?= htmlspecialchars($password) ?>" placeholder="Mot de passe"> <!-- Champ pour le mot de passe -->
            <button type="submit" name="submit" class="btn">Se connecter</button> <!-- Bouton de soumission -->
            <small>Pas déjà inscrit ? <a href="signup.php">Inscrivez-vous</a>.</small> <!-- Lien vers la page d'inscription -->
        </form>
    </div>
</section>
</body>
</html>
