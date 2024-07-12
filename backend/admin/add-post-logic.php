<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    //set is_featured to 0 if unchecked
    $is_featured = $is_featured == 1 ?: 0;

    //validate form data
    if (!$title) {
        $_SESSION['add-post'] = "Renseignez le titre.";
    } elseif (!$category_id) {
        $_SESSION['add-post'] = "Renseignez la catégorie.";
    } elseif (!$body) {
        $_SESSION['add-post'] = "Renseignez la description.";
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Renseignez une image.";
    } else {
        //WORK ON THUMBNAIL
        //Rename the image
        $time = time(); //make each image name unique
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../../frontend/assets/images/' . $thumbnail_name;

        //make sure file is an image
        $allowed_files = ['jpg', 'jpeg', 'png'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);
        if (in_array($extension, $allowed_files)) {
            //make sure image is not too large (2MO+)
            if ($thumbnail['size'] < 2000000) {
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add-post'] = "L'image est trop volumineuse. Elle doit faire moins de 2MO.";
            }
        } else {
            $_SESSION['add-post'] = "Le fichier doit être un jpg, jpeg ou png.";
        }
    }

    //redirect back (with form data) to add post page if there is a problem
    if (isset($_SESSION['add-post'])){
        $_SESSION['add-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'backend/admin/add-post.php');
        die();
    } else {
        // set is_featured of all post to 0 if is_featured for this post is 1
        if ($is_featured == 1){
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        //insert post into database
        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured)
                    VALUES ('$title', '$body', '$thumbnail_name', $category_id, $author_id, $is_featured)";
        $result = mysqli_query($connection, $query);

        if (!mysqli_errno($connection)){
            $_SESSION['add-post-success'] = "Nouvel article ajouté avec succès.";
            header('location: ' . ROOT_URL . 'backend/admin/');
            die();
        }
    }
}
header('location: ' . ROOT_URL . 'backend/admin/add-post.php');
die();