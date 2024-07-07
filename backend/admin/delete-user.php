<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    //Fetch user from database
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    //make sure we got back only one user
    if (mysqli_num_rows($result) == 1){
        $avatar_name = $user['avatar'];
        $avatar_path = '../../frontend/assets/images/'.$avatar_name;
        //delete image if available
        if ($avatar_name){
            unlink($avatar_path);
        }
    }

    //FOR LATER
    //fetch all thumbnails of user's posts and delete them


    //Delete user from database
    $delete_user_query = "DELETE FROM users WHERE id=$id";
    $delete_user_result = mysqli_query($connection, $delete_user_query);
    if (mysqli_errno($connection)){
        $_SESSION['delete-user'] = "Suppression de {$user['$firstname']} {$user['lastname']} impossible.";
    } else {
        $_SESSION['delete-user'] = "Suppression de {$user['$firstname']} {$user['lastname']} effectuée.";
    }
}

header('location: ' . ROOT_URL . '/backend/admin/manage-user.php');
die();