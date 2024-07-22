<?php
// Inclure le fichier de configuration de la base de données
require './backend/config/database.php';

if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Filtrer et sécuriser l'email ou le pseudonyme
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Filtrer et sécuriser le mot de passe

    if (!$username_email) {
        $_SESSION['signin'] = "Veuillez entrer votre pseudo ou votre email."; // Message d'erreur si le champ est vide
    } elseif (!$password) {
        $_SESSION['signin'] = "Veuillez entrer votre mot de passe."; // Message d'erreur si le champ est vide
    } else {
        // Requête pour récupérer l'utilisateur de la base de données
        $fetch_user_query = "SELECT * FROM users WHERE username = :username_email OR email = :username_email";
        $stmt = $connection->prepare($fetch_user_query); // Préparer la requête
        $stmt->execute(['username_email' => $username_email]); // Exécuter la requête avec le paramètre

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
                die(); // Arrêter l'exécution du script
            } else {
                $_SESSION['signin'] = "Mot de passe erroné."; // Message d'erreur si le mot de passe est incorrect
            }
        } else {
            $_SESSION['signin'] = "Utilisateur inexistant."; // Message d'erreur si l'utilisateur n'existe pas
        }
    }

    // En cas de problème, rediriger vers la page de connexion avec les données de connexion
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST; // Sauvegarder les données de connexion dans la session
        header("Location: " . ROOT_URL . "signin.php");
        die(); // Arrêter l'exécution du script
    }
} else {
    header('Location: ' . ROOT_URL . 'signin.php'); // Rediriger vers la page de connexion si le formulaire n'est pas soumis
    die(); // Arrêter l'exécution du script
}
?>
