<?php
// Inclure le fichier de configuration de la base de données
require 'config/database.php';

// S'assurer que le bouton de modification de l'article a été cliqué
if (isset($_POST['submit'])) {
    // Assainir les données du formulaire pour éviter les injections de code
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // Définir is_featured à 0 si la case n'est pas cochée
    $is_featured = $is_featured == 1 ? 1 : 0;

    // Valider les entrées du formulaire
    if (!$title) {
        // Enregistrer un message d'erreur dans la session si le titre est vide
        $_SESSION['edit-post'] = "Modification impossible. Renseignez le titre.";
    } elseif (!$category_id) {
        // Enregistrer un message d'erreur dans la session si la catégorie est vide
        $_SESSION['edit-post'] = "Modification impossible. Données invalides.";
    } elseif (!$body) {
        // Enregistrer un message d'erreur dans la session si le corps de l'article est vide
        $_SESSION['edit-post'] = "Modification impossible. Renseignez le texte de l'article.";
    } else {
        // Supprimer la miniature existante si une nouvelle miniature est disponible
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../../frontend/assets/images/' . $previous_thumbnail_name;
            if (file_exists($previous_thumbnail_path)) {
                unlink($previous_thumbnail_path);
            }

            // Traiter la nouvelle miniature
            // Renommer l'image pour rendre chaque nom unique
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../../frontend/assets/images/' . $thumbnail_name;

            // S'assurer que le fichier est une image
            $allowed_files = ['jpg', 'jpeg', 'png'];
            $extension = pathinfo($thumbnail_name, PATHINFO_EXTENSION);
            if (in_array($extension, $allowed_files)) {
                // S'assurer que l'image n'est pas trop volumineuse (moins de 2MB)
                if ($thumbnail['size'] < 2000000) {
                    // Déplacer l'image vers le chemin de destination
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    // Enregistrer un message d'erreur dans la session si l'image est trop volumineuse
                    $_SESSION['edit-post'] = "L'image est trop volumineuse. Elle doit faire moins de 2MB.";
                }
            } else {
                // Enregistrer un message d'erreur dans la session si le fichier n'est pas une image valide
                $_SESSION['edit-post'] = "Le fichier doit être un jpg, jpeg ou png.";
            }
        }
    }

    if (isset($_SESSION['edit-post'])) {
        // Rediriger vers la page de gestion si les données du formulaire sont invalides
        header('Location: ' . ROOT_URL . 'backend/admin/');
        die();
    } else {
        // Définir is_featured de tous les articles à 0 si is_featured pour cet article est 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
            $stmt = $connection->prepare($zero_all_is_featured_query);
            $stmt->execute();
        }

        // Définir le nom de la miniature si une nouvelle a été téléchargée, sinon garder l'ancienne
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        // Mettre à jour l'article dans la base de données
        $query = "UPDATE posts SET title = :title, body = :body, thumbnail = :thumbnail, category_id = :category_id, is_featured = :is_featured WHERE id = :id LIMIT 1";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':body', $body, PDO::PARAM_STR);
        $stmt->bindParam(':thumbnail', $thumbnail_to_insert, PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':is_featured', $is_featured, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Vérifier si la mise à jour a réussi
        if ($stmt->rowCount()) {
            // Enregistrer un message de succès dans la session
            $_SESSION['edit-post-success'] = "Article modifié avec succès.";
        }
    }
}

// Rediriger vers la page d'administration
header('Location: ' . ROOT_URL . 'backend/admin/');
die();
?>
