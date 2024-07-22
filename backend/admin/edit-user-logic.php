<?php
// Inclure le fichier de configuration de la base de données
require 'config/database.php';

// Vérifier si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérer et assainir les données mises à jour du formulaire
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_VALIDATE_INT);
    $avatar = $_FILES['avatar'];

    // Vérifier la validité des entrées
    if (!$firstname || !$lastname) {
        // Enregistrer un message d'erreur dans la session si les champs sont invalides
        $_SESSION['edit-user'] = "Entrée de formulaire invalide sur la page d'édition";
    } else {
        try {
            // Préparer la requête de mise à jour de l'utilisateur
            $query = "UPDATE users SET firstname = :firstname, lastname = :lastname, is_admin = :is_admin";

            // Ajouter le mot de passe à la requête si fourni
            if ($password) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query .= ", password = :password";
            }

            // Ajouter l'avatar à la requête si fourni
            if ($avatar['name']) {
                $avatar_name = time() . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../../frontend/assets/images/' . $avatar_name;

                // S'assurer que le fichier est une image
                $allowed_files = ['jpg', 'jpeg', 'png'];
                $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
                if (in_array($extension, $allowed_files)) {
                    // S'assurer que l'image n'est pas trop volumineuse (moins de 2MB)
                    if ($avatar['size'] < 2000000) {
                        // Déplacer l'image vers le chemin de destination
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                        $query .= ", avatar = :avatar";
                    } else {
                        // Enregistrer un message d'erreur dans la session si l'image est trop volumineuse
                        $_SESSION['edit-user'] = "L'image est trop volumineuse. Elle doit faire moins de 2MB.";
                    }
                } else {
                    // Enregistrer un message d'erreur dans la session si le fichier n'est pas une image valide
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

            // Enregistrer un message de succès dans la session
            $_SESSION['edit-user-success'] = "Modification de l'utilisateur $firstname $lastname réussie";
        } catch (PDOException $e) {
            // Enregistrer un message d'erreur dans la session en cas d'échec de la mise à jour
            $_SESSION['edit-user'] = "Modification de l'utilisateur non reconnue : " . $e->getMessage();
        }
    }
}

// Rediriger vers la page de gestion des utilisateurs
header('Location: ' . ROOT_URL . 'backend/admin/manage-user.php');
die();
?>
