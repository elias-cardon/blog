<?php
require './backend/config/database.php';

if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$username_email) {
        $_SESSION['signin'] = "Veuillez entrer votre pseudo ou votre email.";
    } elseif (!$password) {
        $_SESSION['signin'] = "Veuillez entrer votre mot de passe.";
    } else {
        // Récupérer l'utilisateur de la base de données
        $fetch_user_query = "SELECT * FROM users WHERE username = :username_email OR email = :username_email";
        $stmt = $connection->prepare($fetch_user_query);
        $stmt->execute(['username_email' => $username_email]);

        if ($stmt->rowCount() == 1) {
            // Convertir l'enregistrement en tableau associatif
            $user_record = $stmt->fetch(PDO::FETCH_ASSOC);
            $db_password = $user_record['password'];
            // Comparer le mot de passe avec celui de la base de données
            if (password_verify($password, $db_password)) {
                // Définir la session pour le contrôle d'accès
                $_SESSION['user-id'] = $user_record['id'];
                // Définir la session si l'utilisateur est administrateur
                if ($user_record['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }

                // Connecter l'utilisateur
                header("Location: " . ROOT_URL . "backend/admin/");
                die();
            } else {
                $_SESSION['signin'] = "Mot de passe erroné.";
            }
        } else {
            $_SESSION['signin'] = "Utilisateur inexistant.";
        }
    }

    // En cas de problème, rediriger vers la page de connexion avec les données de connexion
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header("Location: " . ROOT_URL . "signin.php");
        die();
    }
} else {
    header('Location: ' . ROOT_URL . 'signin.php');
    die();
}
?>
