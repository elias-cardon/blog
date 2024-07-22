<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Récupère l'article de la base de données pour supprimer la miniature du dossier d'images
    $query = "SELECT * FROM posts WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->execute(['id' => $id]);

    // S'assure qu'un seul article a été récupéré
    if ($stmt->rowCount() == 1) {
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        $thumbnail_name = $post['thumbnail'];
        $thumbnail_path = '../../frontend/assets/images/' . $thumbnail_name;

        if (file_exists($thumbnail_path)) {
            unlink($thumbnail_path);

            // Supprime l'article de la base de données
            $delete_post_query = "DELETE FROM posts WHERE id = :id LIMIT 1";
            $stmt = $connection->prepare($delete_post_query);
            $stmt->execute(['id' => $id]);

            // Vérifie si la suppression a réussi
            if ($stmt->rowCount() > 0) {
                $_SESSION['delete-post-success'] = "Article supprimé avec succès.";
            }
        }
    }
}

// Redirige vers la page d'administration
header('Location: ' . ROOT_URL . 'backend/admin/');
die();
?>
