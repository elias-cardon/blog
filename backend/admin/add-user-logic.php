<?php
// Inclure le fichier de configuration de la base de données
require '../config/database.php';

// Récupérer les données du formulaire si le bouton de soumission est cliqué
if (isset($_POST['submit'])) {
    // Récupérer et assainir les données du formulaire pour éviter les injections de code
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];

    // Valider les valeurs d'entrée
    if (!$firstname) {
        // Si le prénom est vide, enregistrer un message d'erreur dans la session
        $_SESSION['add-user'] = "Veuillez renseigner le prénom.";
    } elseif (!$lastname) {
        // Si le nom de famille est vide, enregistrer un message d'erreur dans la session
        $_SESSION['add-user'] = "Veuillez renseigner le nom.";
    } elseif (!$username) {
        // Si le pseudonyme est vide, enregistrer un message d'erreur dans la session
        $_SESSION['add-user'] = "Veuillez renseigner le pseudonyme.";
    } elseif (!$email) {
        // Si l'email est invalide, enregistrer un message d'erreur dans la session
        $_SESSION['add-user'] = "Veuillez renseigner une adresse email valide.";
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        // Si le mot de passe est trop court, enregistrer un message d'erreur dans la session
        $_SESSION['add-user'] = "Le mot de passe doit contenir plus de 8 caractères.";
    } elseif (!$avatar['name']) {
        // Si l'avatar est vide, enregistrer un message d'erreur dans la session
        $_SESSION['add-user'] = "Veuillez ajouter un avatar.";
    } else {
        // Vérifier si les mots de passe ne correspondent pas
        if ($createpassword !== $confirmpassword) {
            // Si les mots de passe ne correspondent pas, enregistrer un message d'erreur dans la session
            $_SESSION['add-user'] = "Les mots de passe ne correspondent pas.";
        } else {
            // Hacher le mot de passe
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // Vérifier si le pseudonyme ou l'email existe déjà dans la base de données
            $user_check_query = "SELECT * FROM users WHERE username = :username OR email = :email";
            $stmt = $connection->prepare($user_check_query);
            $stmt->execute(['username' => $username, 'email' => $email]);

            if ($stmt->rowCount() > 0) {
                // Si le pseudonyme ou l'email existe déjà, enregistrer un message d'erreur dans la session
                $_SESSION['add-user'] = "Pseudonyme ou adresse email déjà existant";
            } else {
                // Travailler sur l'avatar
                // Renommer l'avatar pour rendre chaque image unique en utilisant le timestamp actuel
                $time = time();
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../../frontend/assets/images/' . $avatar_name;

                // S'assurer que le fichier est une image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
                if (in_array($extension, $allowed_files)) {
                    // S'assurer que le fichier n'est pas trop volumineux (1Mo)
                    if ($avatar['size'] < 1000000) {
                        // Télécharger l'avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        // Si l'image est trop volumineuse, enregistrer un message d'erreur dans la session
                        $_SESSION['add-user'] = 'Votre avatar est trop volumineux. Il doit faire moins de 1Mo.';
                    }
                } else {
                    // Si le fichier n'est pas une image valide, enregistrer un message d'erreur dans la session
                    $_SESSION['add-user'] = "Votre avatar doit être un JPG, un JPEG ou un PNG.";
                }
            }
        }
    }

    // Rediriger vers la page d'inscription en cas de problème
    if (isset($_SESSION['add-user'])) {
        // Passer les données du formulaire à la page d'inscription
        $_SESSION['add-user-data'] = $_POST;
        header('Location: ' . ROOT_URL . 'backend/admin/add-user.php');
        die();
    } else {
        // Insérer le nouvel utilisateur dans la table users
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) 
                              VALUES (:firstname, :lastname, :username, :email, :password, :avatar, :is_admin)";
        $stmt = $connection->prepare($insert_user_query);
        $stmt->execute([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'email' => $email,
            'password' => $hashed_password,
            'avatar' => $avatar_name,
            'is_admin' => $is_admin
        ]);

        // Vérifier si l'insertion a réussi
        if ($stmt->rowCount() > 0) {
            // Si l'insertion a réussi, enregistrer un message de succès dans la session
            $_SESSION['add-user-success'] = "$firstname $lastname a bien été ajouté.";
            // Rediriger vers la page de gestion des utilisateurs
            header('Location: ' . ROOT_URL . 'backend/admin/manage-user.php');
            die();
        }
    }
} else {
    // Si le bouton n'est pas cliqué, retourner à la page d'inscription
    header('Location: ' . ROOT_URL . 'backend/admin/add-user.php');
    die();
}
?>
