<?php
// Inclure le fichier de configuration de la base de données
require '../config/database.php';

// Vérifier si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire et les assainir pour éviter les injections de code
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Vérifier si les champs obligatoires sont remplis
    if (!$title) {
        // Si le titre est vide, enregistrer un message d'erreur dans la session
        $_SESSION['add-category'] = "Veuillez renseigner le titre";
    } elseif (!$description) {
        // Si la description est vide, enregistrer un message d'erreur dans la session
        $_SESSION['add-category'] = "Veuillez renseigner la description";
    }

    // Si un message d'erreur a été enregistré, rediriger vers la page d'ajout de catégorie
    if (isset($_SESSION['add-category'])) {
        // Enregistrer les données du formulaire dans la session pour les réafficher
        $_SESSION['add-category-data'] = $_POST;
        header('Location: ' . ROOT_URL . 'backend/admin/add-category.php');
        die();
    } else {
        // Préparer la requête SQL pour insérer la nouvelle catégorie dans la base de données
        $query = "INSERT INTO categories (title, description) VALUES (:title, :description)";
        $stmt = $connection->prepare($query);
        // Exécuter la requête avec les données du formulaire
        $stmt->execute(['title' => $title, 'description' => $description]);

        // Vérifier si l'insertion a échoué
        if ($stmt->rowCount() == 0) {
            // Si l'insertion a échoué, enregistrer un message d'erreur dans la session
            $_SESSION['add-category'] = "Ajout de catégorie échouée.";
            header('Location: ' . ROOT_URL . 'backend/admin/add-category.php');
            die();
        } else {
            // Si l'insertion a réussi, enregistrer un message de succès dans la session
            $_SESSION['add-category-success'] = "La catégorie $title a bien été ajoutée.";
            // Rediriger vers la page de gestion des catégories
            header('Location: ' . ROOT_URL . 'backend/admin/manage-category.php');
            die();
        }
    }
}
?>
