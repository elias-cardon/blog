<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //fetch post from database in order to delete thumbnail from image folder
    $query = "SELECT * FROM posts WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->execute(['id' => $id]);

    //make sure only one record/post was fetched
    if ($stmt->rowCount() == 1) {
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        $thumbnail_name = $post['thumbnail'];
        $thumbnail_path = '../../frontend/assets/images/' . $thumbnail_name;

        if (file_exists($thumbnail_path)) {
            unlink($thumbnail_path);

            //delete post from database
            $delete_post_query = "DELETE FROM posts WHERE id = :id LIMIT 1";
            $stmt = $connection->prepare($delete_post_query);
            $stmt->execute(['id' => $id]);

            if ($stmt->rowCount() > 0) {
                $_SESSION['delete-post-success'] = "Article supprimé avec succès.";
            }
        }
    }
}

header('Location: ' . ROOT_URL . 'backend/admin/');
die();
?>
