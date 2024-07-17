<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch user from database
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Make sure we got back only one user
    if ($stmt->rowCount() == 1) {
        $avatar_name = $user['avatar'];
        $avatar_path = '../../frontend/assets/images/' . $avatar_name;
        // Delete image if available
        if (file_exists($avatar_path)) {
            unlink($avatar_path);
        }
    }

    // Fetch all thumbnails of user's posts and delete them
    $thumbnails_query = "SELECT thumbnail FROM posts WHERE author_id = :id";
    $stmt = $connection->prepare($thumbnails_query);
    $stmt->execute(['id' => $id]);
    $thumbnails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($thumbnails as $thumbnail) {
        $thumbnail_path = '../../frontend/assets/images/' . $thumbnail['thumbnail'];
        // Delete thumbnail from images folder if it exists
        if (file_exists($thumbnail_path)) {
            unlink($thumbnail_path);
        }
    }

    // Delete user from database
    $delete_user_query = "DELETE FROM users WHERE id = :id";
    $stmt = $connection->prepare($delete_user_query);
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['delete-user'] = "Suppression de {$user['firstname']} {$user['lastname']} effectuée.";
    } else {
        $_SESSION['delete-user'] = "Suppression de {$user['firstname']} {$user['lastname']} impossible.";
    }
}

header('Location: ' . ROOT_URL . 'backend/admin/manage-user.php');
die();
?>
