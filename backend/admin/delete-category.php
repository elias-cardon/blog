<?php
require 'config/database.php';

if (isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //update category _id of posts that belong to this category to if of non categorisé
    $update_query = "UPDATE posts SET category_id=5 WHERE category_id=$id";
    $update_result = mysqli_query($connection, $update_query);

    if (!mysqli_errno($connection)){
        //Delete category
        $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);
        $_SESSION['delete-category-success'] = "Catégorie supprimée avec succès";
    }
}

header('location: ' . ROOT_URL . 'backend/admin/manage-category.php');
die();