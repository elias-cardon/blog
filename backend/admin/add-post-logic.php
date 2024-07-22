<?php
require '../config/database.php';

if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // Définir is_featured à 0 si non coché
    $is_featured = $is_featured == 1 ? 1 : 0;

    // Valider les données du formulaire
    if (!$title) {
        $_SESSION['add-post'] = "Renseignez le titre.";
    } elseif (!$category_id) {
        $_SESSION['add-post'] = "Renseignez la catégorie.";
    } elseif (!$body) {
        $_SESSION['add-post'] = "Renseignez la description.";
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Renseignez une image.";
    } else {
        // TRAITEMENT DE LA MINIATURE
        // Renommer l'image
        $time = time(); // rendre chaque nom d'image unique
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../../frontend/assets/images/' . $thumbnail_name;

        // S'assurer que le fichier est une image
        $allowed_files = ['jpg', 'jpeg', 'png'];
        $extension = pathinfo($thumbnail_name, PATHINFO_EXTENSION);
        if (in_array($extension, $allowed_files)) {
            // S'assurer que l'image n'est pas trop volumineuse (moins de 2MO)
            if ($thumbnail['size'] < 2000000) {
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add-post'] = "L'image est trop volumineuse. Elle doit faire moins de 2MO.";
            }
        } else {
            $_SESSION['add-post'] = "Le fichier doit être un jpg, jpeg ou png.";
        }
    }

    // Rediriger vers la page d'ajout d'article (avec les données du formulaire) en cas de problème
    if (isset($_SESSION['add-post'])) {
        $_SESSION['add-post-data'] = $_POST;
        header('Location: ' . ROOT_URL . 'backend/admin/add-post.php');
        die();
    } else {
        // Définir is_featured de tous les articles à 0 si is_featured pour cet article est 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $stmt = $connection->prepare($zero_all_is_featured_query);
            $stmt->execute();
        }

        // Insérer l'article dans la base de données
        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured)
                  VALUES (:title, :body, :thumbnail, :category_id, :author_id, :is_featured)";
        $stmt = $connection->prepare($query);
        $stmt->execute([
            'title' => $title,
            'body' => $body,
            'thumbnail' => $thumbnail_name,
            'category_id' => $category_id,
            'author_id' => $author_id,
            'is_featured' => $is_featured
        ]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['add-post-success'] = "Nouvel article ajouté avec succès.";
            header('Location: ' . ROOT_URL . 'backend/admin/');
            die();
        }
    }
}
header('Location: ' . ROOT_URL . 'backend/admin/add-post.php');
die();
?>
