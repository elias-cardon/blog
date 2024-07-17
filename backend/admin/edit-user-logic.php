<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    // Get updated form data
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_VALIDATE_INT);

    // Check for valid input
    if (!$firstname || !$lastname) {
        $_SESSION['edit-user'] = "Invalid form input sur la page d'édition";
    } else {
        try {
            // Update user
            $query = "UPDATE users SET firstname = :firstname, lastname = :lastname, is_admin = :is_admin WHERE id = :id LIMIT 1";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $stmt->bindParam(':is_admin', $is_admin, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $_SESSION['edit-user-success'] = "Modification de l'utilisateur $firstname $lastname réussie";
        } catch (PDOException $e) {
            $_SESSION['edit-user'] = "Modification de l'utilisateur non reconnue : " . $e->getMessage();
        }
    }
}

header('Location: ' . ROOT_URL . 'backend/admin/manage-user.php');
die();
?>
