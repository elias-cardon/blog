<?php
require './backend/config/database.php';

if (isset($_POST['submit'])) {
    // Get form data
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$username_email) {
        $_SESSION['signin'] = "Veuillez entrer votre pseudo ou votre email.";
    } elseif (!$password) {
        $_SESSION['signin'] = "Veuillez entrer votre mot de passe.";
    } else {
        // Fetch user from database
        $fetch_user_query = "SELECT * FROM users WHERE username = :username_email OR email = :username_email";
        $stmt = $connection->prepare($fetch_user_query);
        $stmt->execute(['username_email' => $username_email]);

        if ($stmt->rowCount() == 1) {
            // Convert record into assoc array
            $user_record = $stmt->fetch(PDO::FETCH_ASSOC);
            $db_password = $user_record['password'];
            // Compare password with database password
            if (password_verify($password, $db_password)) {
                // Set session for access control
                $_SESSION['user-id'] = $user_record['id'];
                // Set session if user is admin
                if ($user_record['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }

                // Log user in
                header("Location: " . ROOT_URL . "backend/admin/");
                die();
            } else {
                $_SESSION['signin'] = "Mot de passe erroné.";
            }
        } else {
            $_SESSION['signin'] = "Utilisateur inexistant.";
        }
    }

    // If any problem, redirect back to signin page with login data
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
