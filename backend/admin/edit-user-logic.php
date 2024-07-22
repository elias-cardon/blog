<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    // Récupère les données mises à jour du formulaire
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_VALIDATE_INT);
    $avatar = $_FILES['avatar'];

    // Vérifie la validité des entrées
    if (!$firstname || !$lastname) {
        $_SESSION['edit-user'] = "Entrée de formulaire invalide sur la page d'édition";
    } else {
        try {
            // Met à jour l'utilisateur
            $query = "UPDATE users SET firstname = :firstname, lastname = :lastname, is_admin = :is_admin";

            // Ajoute le mot de passe à la requête si fourni
            if ($password) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query .= ", password = :password";
            }

            // Ajoute l'avatar à la requête si fourni
            if ($avatar['name']) {
                $avatar_name = time() . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../../frontend/assets/images/' . $avatar_name;

                // S'assure que le fichier est une image
                $allowed_files = ['jpg', 'jpeg', 'png'];
                $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
                if (in_array($extension, $allowed_files)) {
                    // S'assure que l'image n'est pas trop volumineuse (moins de 2MB)
                    if ($avatar['size'] < 2000000) {
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                        $query .= ", avatar = :avatar";
                    } else {
                        $_SESSION['edit-user'] = "L'image est trop volumineuse. Elle doit faire moins de 2MB.";
                    }
                } else {
                    $_SESSION['edit-user'] = "Le fichier doit être un jpg, jpeg ou png.";
                }
            }

            $query .= " WHERE id = :id LIMIT 1";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $stmt->bindParam(':is_admin', $is_admin, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($password) {
                $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            }

            if ($avatar['name']) {
                $stmt->bindParam(':avatar', $avatar_name, PDO::PARAM_STR);
            }

            $stmt->execute();

            // Message de succès
            $_SESSION['edit-user-success'] = "Modification de l'utilisateur $firstname $lastname réussie";
        } catch (PDOException $e) {
            // Message d'erreur en cas d'échec de la mise à jour
            $_SESSION['edit-user'] = "Modification de l'utilisateur non reconnue : " . $e->getMessage();
        }
    }
}

// Redirige vers la page de gestion des utilisateurs
header('Location: ' . ROOT_URL . 'backend/admin/manage-user.php');
die();
?>
