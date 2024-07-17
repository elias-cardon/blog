<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Vérifie que la catégorie existe
    $check_query = "SELECT * FROM categories WHERE id = :id";
    $check_stmt = $connection->prepare($check_query);
    $check_stmt->execute(['id' => $id]);
    $category = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        // Supprime la catégorie
        $query = "DELETE FROM categories WHERE id = :id LIMIT 1";
        $stmt = $connection->prepare($query);
        $stmt->execute(['id' => $id]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['delete-category-success'] = "Catégorie supprimée avec succès";
        } else {
            $_SESSION['delete-category'] = "Échec de la suppression de la catégorie.";
        }
    } else {
        $_SESSION['delete-category'] = "Catégorie non trouvée.";
    }
} else {
    $_SESSION['delete-category'] = "ID de catégorie non fourni.";
}

header('Location: ' . ROOT_URL . 'backend/admin/manage-category.php');
die();
?>
