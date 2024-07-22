<?php
// Inclure le fichier de configuration de la base de données
require '../config/database.php';

// Vérifier si l'ID de la catégorie est fourni dans l'URL
if (isset($_GET['id'])) {
    // Assainir l'ID pour éviter les injections de code
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Vérifier que la catégorie existe dans la base de données
    $check_query = "SELECT * FROM categories WHERE id = :id";
    $check_stmt = $connection->prepare($check_query);
    $check_stmt->execute(['id' => $id]);
    $category = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        // Supprimer la catégorie si elle existe
        $query = "DELETE FROM categories WHERE id = :id LIMIT 1";
        $stmt = $connection->prepare($query);
        $stmt->execute(['id' => $id]);

        // Vérifier si la suppression a réussi
        if ($stmt->rowCount() > 0) {
            // Enregistrer un message de succès dans la session
            $_SESSION['delete-category-success'] = "Catégorie supprimée avec succès";
        } else {
            // Enregistrer un message d'erreur dans la session si la suppression a échoué
            $_SESSION['delete-category'] = "Échec de la suppression de la catégorie.";
        }
    } else {
        // Enregistrer un message d'erreur dans la session si la catégorie n'existe pas
        $_SESSION['delete-category'] = "Catégorie non trouvée.";
    }
} else {
    // Enregistrer un message d'erreur dans la session si l'ID de la catégorie n'est pas fourni
    $_SESSION['delete-category'] = "ID de catégorie non fourni.";
}

// Rediriger vers la page de gestion des catégories
header('Location: ' . ROOT_URL . 'backend/admin/manage-category.php');
die();
?>
