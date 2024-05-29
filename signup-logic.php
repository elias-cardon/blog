<?php

require './backend/config/database.php';

//get signup data if signup button clicked
if (isset($_POST['submit'])){
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    //validate input values
    if (!$firstname){
        $_SESSION['signup'] = "Veuillez renseigner votre prénom.";
    } elseif (!$lastname){
        $_SESSION['signup'] = "Veuillez renseigner votre nom.";
    }elseif (!$username){
        $_SESSION['signup'] = "Veuillez renseigner votre pseudonyme.";
    }elseif (!$email){
        $_SESSION['signup'] = "Veuillez renseigner une adresse email valide.";
    }elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8){
        $_SESSION['signup'] = "Le mot de passe doit contenir plus de 8 caractères.";
    }elseif (!$avatar['name']){
        $_SESSION['signup'] = "Veuillez ajouter un avatar.";
    } else {
        //Check if password don't match
        if ($createpassword !== $confirmpassword){
            $_SESSION['signup'] = "Les mots de passe ne correspondent pas.";
        } else{
            //hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            //check if username or email already exit in database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if (mysqli_num_rows($user_check_result) > 0){
                $_SESSION['signup'] = "Pseudonyme ou adresse email déjà existant";
            } else{
                //Work on avatar
                //rename avatar
                $time = time(); //make each image unique using current timestamp
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'frontend/assets/images/' . $avatar_name;

                //make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extention = explode('.', $avatar_name);
                $extention = end($extention);
            }
        }
    }
}else{
    //if button not clicked, return to signup page
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}