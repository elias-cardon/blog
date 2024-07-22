<?php
// Inclure le fichier de configuration de la base de données
require './backend/config/database.php';

// Récupérer les données d'inscription si le bouton d'inscription est cliqué
if (isset($_POST['submit'])) {
    // Filtrer et sécuriser les données du formulaire
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // Valider les valeurs d'entrée
    if (!$firstname) {
        $_SESSION['signup'] = "Veuillez renseigner votre prénom.";
    } elseif (!$lastname) {
        $_SESSION['signup'] = "Veuillez renseigner votre nom.";
    } elseif (!$username) {
        $_SESSION['signup'] = "Veuillez renseigner votre pseudonyme.";
    } elseif (!$email) {
        $_SESSION['signup'] = "Veuillez renseigner une adresse email valide.";
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signup'] = "Le mot de passe doit contenir plus de 8 caractères.";
    } elseif (!$avatar['name']) {
        $_SESSION['signup'] = "Veuillez ajouter un avatar.";
    } else {
        // Vérifier si les mots de passe ne correspondent pas
        if ($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = "Les mots de passe ne correspondent pas.";
        } else {
            // Hacher le mot de passe
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // Vérifier si le pseudonyme ou l'email existe déjà dans la base de données
            $user_check_query = "SELECT * FROM users WHERE username = :username OR email = :email";
            $stmt = $connection->prepare($user_check_query); // Préparer la requête
            $stmt->execute(['username' => $username, 'email' => $email]); // Exécuter la requête avec les paramètres

            if ($stmt->rowCount() > 0) {
                $_SESSION['signup'] = "Pseudonyme ou adresse email déjà existant";
            } else {
                // Travailler sur l'avatar
                // Renommer l'avatar
                $time = time(); // rendre chaque image unique en utilisant le timestamp actuel
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'frontend/assets/images/' . $avatar_name;

                // S'assurer que le fichier est une image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
                if (in_array($extension, $allowed_files)) {
                    // S'assurer que le fichier n'est pas trop volumineux (1Mo)
                    if ($avatar['size'] < 1000000) {
                        // Télécharger l'avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['signup'] = 'Ce fichier est trop volumineux. Il doit faire moins de 1Mo.';
                    }
                } else {
                    $_SESSION['signup'] = "Ce fichier doit être un JPG, un JPEG ou un PNG.";
                }
            }
        }
    }

    // Rediriger vers la page d'inscription en cas de problème
    if (isset($_SESSION['signup'])) {
        // Passer les données du formulaire à la page d'inscription
        $_SESSION['signup-data'] = $_POST;
        header('Location: ' . ROOT_URL . 'signup.php');
        die(); // Arrêter l'exécution du script
    } else {
        // Insérer le nouvel utilisateur dans la table users
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES (:firstname, :lastname, :username, :email, :password, :avatar, 0)";
        $stmt = $connection->prepare($insert_user_query); // Préparer la requête
        $stmt->execute([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'email' => $email,
            'password' => $hashed_password,
            'avatar' => $avatar_name
        ]); // Exécuter la requête avec les paramètres

        if ($stmt->rowCount() > 0) {
            // Rediriger vers la page de connexion avec un message de succès
            $_SESSION['signup-success'] = "Inscription réussie. Vous pouvez vous connecter.";
            header('Location: ' . ROOT_URL . 'signin.php');
            die(); // Arrêter l'exécution du script
        }
    }
} else {
    // Si le bouton n'est pas cliqué, retourner à la page d'inscription
    header('Location: ' . ROOT_URL . 'signup.php');
    die(); // Arrêter l'exécution du script
}
?>
