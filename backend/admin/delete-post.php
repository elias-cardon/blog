<?php
// Inclure le fichier de configuration de la base de données
require '../config/database.php';

// Vérifier si l'ID de l'article est fourni dans l'URL
if (isset($_GET['id'])) {
    // Assainir l'ID pour éviter les injections de code
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Récupérer l'article de la base de données pour supprimer la miniature du dossier d'images
    $query = "SELECT * FROM posts WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->execute(['id' => $id]);

    // S'assurer qu'un seul article a été récupéré
    if ($stmt->rowCount() == 1) {
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        $thumbnail_name = $post['thumbnail'];
        $thumbnail_path = '../../frontend/assets/images/' . $thumbnail_name;

        // Vérifier si le fichier de la miniature existe
        if (file_exists($thumbnail_path)) {
            // Supprimer le fichier de la miniature
            unlink($thumbnail_path);

            // Supprimer l'article de la base de données
            $delete_post_query = "DELETE FROM posts WHERE id = :id LIMIT 1";
            $stmt = $connection->prepare($delete_post_query);
            $stmt->execute(['id' => $id]);

            // Vérifier si la suppression a réussi
            if ($stmt->rowCount() > 0) {
                // Enregistrer un message de succès dans la session
                $_SESSION['delete-post-success'] = "Article supprimé avec succès.";
            }
        }
    }
}

// Rediriger vers la page d'administration
header('Location: ' . ROOT_URL . 'backend/admin/');
die();
?>
