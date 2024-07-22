<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Récupère l'utilisateur de la base de données
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // S'assure qu'un seul utilisateur a été récupéré
    if ($stmt->rowCount() == 1) {
        $avatar_name = $user['avatar'];
        $avatar_path = '../../frontend/assets/images/' . $avatar_name;
        // Supprime l'image si elle existe
        if (file_exists($avatar_path)) {
            unlink($avatar_path);
        }
    }

    // Récupère toutes les miniatures des articles de l'utilisateur et les supprime
    $thumbnails_query = "SELECT thumbnail FROM posts WHERE author_id = :id";
    $stmt = $connection->prepare($thumbnails_query);
    $stmt->execute(['id' => $id]);
    $thumbnails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($thumbnails as $thumbnail) {
        $thumbnail_path = '../../frontend/assets/images/' . $thumbnail['thumbnail'];
        // Supprime la miniature du dossier d'images si elle existe
        if (file_exists($thumbnail_path)) {
            unlink($thumbnail_path);
        }
    }

    // Supprime l'utilisateur de la base de données
    $delete_user_query = "DELETE FROM users WHERE id = :id";
    $stmt = $connection->prepare($delete_user_query);
    $stmt->execute(['id' => $id]);

    // Vérifie si la suppression a réussi
    if ($stmt->rowCount() > 0) {
        $_SESSION['delete-user'] = "Suppression de {$user['firstname']} {$user['lastname']} effectuée.";
    } else {
        $_SESSION['delete-user'] = "Suppression de {$user['firstname']} {$user['lastname']} impossible.";
    }
}

// Redirige vers la page de gestion des utilisateurs
header('Location: ' . ROOT_URL . 'backend/admin/manage-user.php');
die();
?>
