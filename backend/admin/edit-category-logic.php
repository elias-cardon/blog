<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Valide les entrées du formulaire
    if (!$title || !$description) {
        $_SESSION['edit-category'] = "Entrée de formulaire invalide sur la page de modification de catégorie.";
    } else {
        try {
            // Met à jour la catégorie dans la base de données
            $query = "UPDATE categories SET title = :title, description = :description WHERE id = :id LIMIT 1";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Message de succès
            $_SESSION['edit-category-success'] = "Catégorie $title mise à jour avec succès.";
        } catch (PDOException $e) {
            // Message d'erreur en cas d'échec de la mise à jour
            $_SESSION['edit-category'] = "Mise à jour de la catégorie impossible : " . $e->getMessage();
        }
    }
}

// Redirige vers la page de gestion des catégories
header('Location: ' . ROOT_URL . 'backend/admin/manage-category.php');
die();
?>
