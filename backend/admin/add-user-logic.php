<?php
require 'config/database.php';

//get form data if submit button clicked
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];

    //validate input values
    if (!$firstname) {
        $_SESSION['add-user'] = "Veuillez renseigner le prénom.";
    } elseif (!$lastname) {
        $_SESSION['add-user'] = "Veuillez renseigner le nom.";
    } elseif (!$username) {
        $_SESSION['add-user'] = "Veuillez renseigner le pseudonyme.";
    } elseif (!$email) {
        $_SESSION['add-user'] = "Veuillez renseigner une adresse email valide.";
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['add-user'] = "Le mot de passe doit contenir plus de 8 caractères.";
    } elseif (!$avatar['name']) {
        $_SESSION['add-user'] = "Veuillez ajouter un avatar.";
    } else {
        //Check if password don't match
        if ($createpassword !== $confirmpassword) {
            $_SESSION['add-user'] = "Les mots de passe ne correspondent pas.";
        } else {
            //hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            //check if username or email already exit in database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['add-user'] = "Pseudonyme ou adresse email déjà existant";
            } else {
                //Work on avatar
                //rename avatar
                $time = time(); //make each image unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../../frontend/assets/images/' . $avatar_name;

                //make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extention = explode('.', $avatar_name);
                $extention = end($extention);
                if (in_array($extention, $allowed_files)) {
                    //Make sure the file is not too large (1Mo)
                    if ($avatar['size'] < 1000000) {
                        //Upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['add-user'] = 'Votre avatar est trop volumineux. Il doit faire moins de 1Mo.';
                    }
                } else {
                    $_SESSION['add-user'] = "Votre avatar doit être un JPG, un JPEG ou un PNG.";
                }
            }
        }
    }
    //redirect back to signup if any problem
    if (isset($_SESSION['add-user'])) {
        //pass the form data back to signup page
        $_SESSION['add-user-data'] = $_POST;
        header('location:' . ROOT_URL . 'backend/admin/add-user.php');
        die();
    } else {
        //insert new user into users table
        $insert_user_query = "INSERT INTO users SET firstname='$firstname',
              lastname='$lastname', username='$username', email='$email', password='$hashed_password',
              avatar='$avatar_name', is_admin='$is_admin'";

        $insert_user_result = mysqli_query($connection, $insert_user_query);

        if (!mysqli_errno($connection)) {
            //Redirect to signup pag with success message
            $_SESSION['add-user-success'] = "$firstname $lastname a bien été ajouté.";
            header('location:' . ROOT_URL . 'backend/admin/manage-user.php');
        }
    }
} else {
    //if button not clicked, return to signup page
    header('location:' . ROOT_URL . 'backend/admin/add-user.php');
    die();
}