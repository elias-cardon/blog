<?php
// Inclure le fichier de configuration
require './backend/config/constants.php';

// Récupérer les données de session si elles existent
$firstname = $_SESSION['signup-data']['firstname'] ?? ''; // Récupérer le prénom de la session
$lastname = $_SESSION['signup-data']['lastname'] ?? ''; // Récupérer le nom de famille de la session
$email = $_SESSION['signup-data']['email'] ?? ''; // Récupérer l'email de la session
$username = $_SESSION['signup-data']['username'] ?? ''; // Récupérer le pseudonyme de la session
$createpassword = $_SESSION['signup-data']['createpassword'] ?? ''; // Récupérer le mot de passe de la session
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? ''; // Récupérer la confirmation du mot de passe de la session

// Supprimer les données de session après les avoir récupérées
unset($_SESSION['signup-data']);
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
    <link rel="icon" type="image/png" href="<?= ROOT_URL ?>frontend/assets/images/logo.png"/>
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
        <h2>Inscription</h2>
        <?php if (isset($_SESSION['signup'])) : ?> <!-- Vérifier s'il y a un message d'erreur d'inscription -->
            <div class="alert__message error">
                <p>
                    <?= $_SESSION['signup']; // Afficher le message d'erreur
                    unset($_SESSION['signup']); // Supprimer le message de la session
                    ?>
                </p>
            </div>
        <?php endif; ?>
        <form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="firstname" value="<?= htmlspecialchars($firstname) ?>" placeholder="Prénom"> <!-- Champ pour le prénom -->
            <input type="text" name="lastname" value="<?= htmlspecialchars($lastname) ?>" placeholder="Nom de famille"> <!-- Champ pour le nom de famille -->
            <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" placeholder="Pseudonyme"> <!-- Champ pour le pseudonyme -->
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Adresse email"> <!-- Champ pour l'email -->
            <input type="password" name="createpassword" value="<?= htmlspecialchars($createpassword) ?>" placeholder="Mot de passe"> <!-- Champ pour le mot de passe -->
            <input type="password" name="confirmpassword" value="<?= htmlspecialchars($confirmpassword) ?>" placeholder="Confirmation du mot de passe"> <!-- Champ pour la confirmation du mot de passe -->
            <div class="form__control">
                <label for="avatar">Avatar</label>
                <input type="file" name="avatar" id="avatar"> <!-- Champ pour l'avatar -->
            </div>
            <button type="submit" name="submit" class="btn">S'inscrire</button> <!-- Bouton de soumission -->
            <small>Déjà inscrit ? <a href="signin.php">Connectez-vous</a>.</small> <!-- Lien vers la page de connexion -->
        </form>
    </div>
</section>
</body>
</html>
