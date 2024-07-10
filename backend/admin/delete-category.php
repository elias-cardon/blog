<?php
require 'config/database.php';

if (isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //FOR LATER
    //update category _id of posts that belong to this category to if of non categorisé


    //Delete category
    $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
    $result = mysqli_query($connection, $query);
    $_SESSION['delete-category-success'] = "Catégorie supprimée avec succès";
}

header('location: ' . ROOT_URL . 'backend/admin/manage-category.php');
die();