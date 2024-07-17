<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    // Get updated form data
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // Check for valid input
    if (!$firstname || !$lastname || !$username) {
        $_SESSION['edit-profile'] = "Invalid form input sur la page d'édition";
    } else {
        try {
            // Update user
            $query = "UPDATE users SET firstname = :firstname, lastname = :lastname, username = :username";

            // Add password to query if provided
            if ($password) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query .= ", password = :password";
            }

            // Add avatar to query if provided
            if ($avatar['name']) {
                $avatar_name = time() . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../../frontend/assets/images/' . $avatar_name;

                // Make sure file is an image
                $allowed_files = ['jpg', 'jpeg', 'png'];
                $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
                if (in_array($extension, $allowed_files)) {
                    // Make sure image is not too large (2MB+)
                    if ($avatar['size'] < 2000000) {
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                        $query .= ", avatar = :avatar";
                    } else {
                        $_SESSION['edit-profile'] = "L'image est trop volumineuse. Elle doit faire moins de 2MB.";
                    }
                } else {
                    $_SESSION['edit-profile'] = "Le fichier doit être un jpg, jpeg ou png.";
                }
            }

            $query .= " WHERE id = :id LIMIT 1";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($password) {
                $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            }

            if ($avatar['name']) {
                $stmt->bindParam(':avatar', $avatar_name, PDO::PARAM_STR);
            }

            $stmt->execute();

            $_SESSION['edit-profile-success'] = "Modification du profil réussie";
        } catch (PDOException $e) {
            $_SESSION['edit-profile'] = "Modification du profil non reconnue : " . $e->getMessage();
        }
    }
}

header('Location: ' . ROOT_URL . 'backend/admin/');
die();
?>
