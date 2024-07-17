<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Update category_id of posts that belong to this category to id of "non catégorisé"
    $update_query = "UPDATE posts SET category_id = 5 WHERE category_id = :id";
    $stmt = $connection->prepare($update_query);
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() > 0) {
        // Delete category
        $query = "DELETE FROM categories WHERE id = :id LIMIT 1";
        $stmt = $connection->prepare($query);
        $stmt->execute(['id' => $id]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['delete-category-success'] = "Catégorie supprimée avec succès";
        }
    }
}

header('Location: ' . ROOT_URL . 'backend/admin/manage-category.php');
die();
?>
