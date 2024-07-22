<?php
require '../config/database.php';

if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Vérifier les champs obligatoires
    if (!$title) {
        $_SESSION['add-category'] = "Veuillez renseigner le titre";
    } elseif (!$description) {
        $_SESSION['add-category'] = "Veuillez renseigner la description";
    }

    // Rediriger vers la page d'ajout de catégorie avec les données du formulaire en cas d'entrée invalide
    if (isset($_SESSION['add-category'])) {
        $_SESSION['add-category-data'] = $_POST;
        header('Location: ' . ROOT_URL . 'backend/admin/add-category.php');
        die();
    } else {
        // Insérer la catégorie dans la base de données
        $query = "INSERT INTO categories (title, description) VALUES (:title, :description)";
        $stmt = $connection->prepare($query);
        $stmt->execute(['title' => $title, 'description' => $description]);

        // Vérifier si l'insertion a échoué
        if ($stmt->rowCount() == 0) {
            $_SESSION['add-category'] = "Ajout de catégorie échouée.";
            header('Location: ' . ROOT_URL . 'backend/admin/add-category.php');
            die();
        } else {
            // Rediriger vers la page de gestion des catégories avec un message de succès
            $_SESSION['add-category-success'] = "La catégorie $title a bien été ajoutée.";
            header('Location: ' . ROOT_URL . 'backend/admin/manage-category.php');
            die();
        }
    }
}
?>
