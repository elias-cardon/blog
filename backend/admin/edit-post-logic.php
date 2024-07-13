<?php
require 'config/database.php';

//make sure edit post button was clicked
if(isset($_POST['submit'])){
    $id= filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var(filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT));
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    //set is_featured to 0 if it was unchecked
    $is_featured = $is_featured == 1 ?: 0;

    //check and validate input values
    if (!$title){
        $_SESSION['edit-post'] = "Modification impossible. Données invalides.";
    } elseif(!$category_id){
        $_SESSION['edit-post'] = "Modification impossible. Données invalides.";
    } elseif (!$body){
        $_SESSION['edit-post'] = "Modification impossible. Données invalides.";
    } else {
        //Delete existing thumbnail if new thumbnail is available
        if ($thumbnail['name']){
            $previous_thumbnail_path = '../../frontend/assets/images/' . $previous_thumbnail_name;
            if ($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }

            //WORK ON THUMBNAIL
            //Rename image
            $time = time() . $thumbnail['name']; // Make each image name upload unique using current timestamp
            $thumbnail_name = $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../../frontend/assets/images/' . $thumbnail_name;

            //Make sure file is an image
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);
            if (in_array($extension, $allowed_files)){
                //Make sure image is not too large (2MO+)
                if ($thumbnail['size'] < 2000000) {
                    //upload image
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit-post'] = "Modification impossible. L'image est trop volumineuse. Elle doit peser moins de 2MO.";
                }
            } else {
                $_SESSION['edit-post'] = "Modification impossible. L'image doit être un jpg, jpeg ou png.";
            }
        }
    }

    if ($_SESSION['edit-post']){
        //redirect to manage form page if form data invalid
        header('location: ' . ROOT_URL . 'backend/admin/edit-post.php');
        die();
    } else {
        //set is_featured of all posts to 0 if is_featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_featured_query = "UPDATE posts SET is_featured = 0";
            $zero_all_featured_result = mysqli_query($connection, $zero_all_featured_query);
        }

        //set thumbnail name if a new one is uploaded, else keep old thumbnail name
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        $query = "UPDATE posts SET title = '$title', body = '$body', thumbnail = '$thumbnail_to_insert',
                 category_id = '$category_id', is_featured = '$is_featured' WHERE id = '$id' LIMIT 1";
        $result = mysqli_query($connection, $query);
    }

    if (!mysqli_errno($connection)){
        $_SESSION['edit-post-success'] = "L'article a bien été modifié.";
    }
}

header('location: ' .ROOT_URL . 'backend/admin/');
die();