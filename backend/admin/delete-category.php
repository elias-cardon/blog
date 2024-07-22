<?php
require '../config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Vérifie que la catégorie existe dans la base de données
    $check_query = "SELECT * FROM categories WHERE id = :id";
    $check_stmt = $connection->prepare($check_query);
    $check_stmt->execute(['id' => $id]);
    $category = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        // Supprime la catégorie si elle existe
        $query = "DELETE FROM categories WHERE id = :id LIMIT 1";
        $stmt = $connection->prepare($query);
        $stmt->execute(['id' => $id]);

        // Vérifie si la suppression a réussi
        if ($stmt->rowCount() > 0) {
            $_SESSION['delete-category-success'] = "Catégorie supprimée avec succès";
        } else {
            $_SESSION['delete-category'] = "Échec de la suppression de la catégorie.";
        }
    } else {
        // Message si la catégorie n'existe pas
        $_SESSION['delete-category'] = "Catégorie non trouvée.";
    }
} else {
    // Message si l'ID de la catégorie n'est pas fourni
    $_SESSION['delete-category'] = "ID de catégorie non fourni.";
}

// Redirige vers la page de gestion des catégories
header('Location: ' . ROOT_URL . 'backend/admin/manage-category.php');
die();
?>
