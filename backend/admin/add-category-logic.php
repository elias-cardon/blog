<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    //get form data
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$title){
        $_SESSION['add-category'] = "Veuillez renseigner le titre";
    } elseif (!$description) {
        $_SESSION['add-category'] = "Veuillez renseigner la description";
    }

    //Redirect back to add category page with form data if there was invalid input
    if (isset($_SESSION['add-category'])){
        $_SESSION['add-category-data'] = $_POST;
        header('location:' . ROOT_URL . 'backend/admin/add-category.php');
        die();
    } else {
        // Insert category into database
        $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $result = mysqli_query($connection, $query);
        if (mysqli_errno($connection)){
            $_SESSION['add-category'] = "Ajout de catégorie échouée.";
            header('location: ' . ROOT_URL . 'backend/admin/add-category.php');
            die();
        } else {
            $_SESSION['add-category-success'] = "La catégorie $title a bien été ajoutée.";
            header('location: ' . ROOT_URL . 'backend/admin/manage-category.php');
            die();
        }
    }
}