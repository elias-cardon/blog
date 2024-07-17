<?php
require 'config/database.php';

// Make sure the edit post button was clicked
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // Set is_featured to 0 if it was unchecked
    $is_featured = $is_featured == 1 ? 1 : 0;

    if (!$title) {
        $_SESSION['edit-post'] = "Modification impossible. Renseignez le titre.";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Modification impossible. Données invalides.";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Modification impossible. Renseignez le texte de l'article.";
    } else {
        // Delete existing thumbnail if new thumbnail is available
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../../frontend/assets/images/' . $previous_thumbnail_name;
            if (file_exists($previous_thumbnail_path)) {
                unlink($previous_thumbnail_path);
            }

            // Work on thumbnail
            // Rename image
            $time = time(); // Make each image name unique
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../../frontend/assets/images/' . $thumbnail_name;

            // Make sure file is an image
            $allowed_files = ['jpg', 'jpeg', 'png'];
            $extension = pathinfo($thumbnail_name, PATHINFO_EXTENSION);
            if (in_array($extension, $allowed_files)) {
                // Make sure image is not too large (2MB+)
                if ($thumbnail['size'] < 2000000) {
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit-post'] = "L'image est trop volumineuse. Elle doit faire moins de 2MB.";
                }
            } else {
                $_SESSION['edit-post'] = "Le fichier doit être un jpg, jpeg ou png.";
            }
        }
    }

    if (isset($_SESSION['edit-post'])) {
        // Redirect to manage form page if form data is invalid
        header('Location: ' . ROOT_URL . 'backend/admin/');
        die();
    } else {
        // Set is_featured of all posts to 0 if is_featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
            $stmt = $connection->prepare($zero_all_is_featured_query);
            $stmt->execute();
        }

        // Set thumbnail name if new one was uploaded, else keep old one
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        $query = "UPDATE posts SET title = :title, body = :body, thumbnail = :thumbnail, category_id = :category_id, is_featured = :is_featured WHERE id = :id LIMIT 1";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':body', $body, PDO::PARAM_STR);
        $stmt->bindParam(':thumbnail', $thumbnail_to_insert, PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':is_featured', $is_featured, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount()) {
            $_SESSION['edit-post-success'] = "Article modifié avec succès.";
        }
    }
}

header('Location: ' . ROOT_URL . 'backend/admin/');
die();
?>
