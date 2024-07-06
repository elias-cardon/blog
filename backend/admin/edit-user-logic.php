<?php
require 'config/database.php';
if(isset($_POST['submit'])){
    //get updated form data
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_VALIDATE_INT);

    //check for valid input
    if (!$firstname || !$lastname) {
        $_SESSION['edit-user'] = "Invalid form input sur la page d'édition";
    } else {
        //update user
        $query = "UPDATE `users` SET firstname = '$firstname', lastname = '$lastname', is_admin = $is_admin WHERE id = $id LIMIT 1";
        $result = mysqli_query($connection, $query);

        if (mysqli_errno($connection)){
            $_SESSION['edit-user'] = "Edition de l'utilisateur non reconnu";
        } else {
            $_SESSION['edit-user-success'] = "Edition de l'utilisateur $firstname $lastname réussie";
        }
    }
}

header('location: ' . ROOT_URL . 'backend/admin/manage-user.php');
die();