<?php
require '../config/database.php';

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
        //Check if passwords don't match
        if ($createpassword !== $confirmpassword) {
            $_SESSION['add-user'] = "Les mots de passe ne correspondent pas.";
        } else {
            //hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            //check if username or email already exists in database
            $user_check_query = "SELECT * FROM users WHERE username = :username OR email = :email";
            $stmt = $connection->prepare($user_check_query);
            $stmt->execute(['username' => $username, 'email' => $email]);

            if ($stmt->rowCount() > 0) {
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
                $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);
                if (in_array($extension, $allowed_files)) {
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
        header('Location: ' . ROOT_URL . 'backend/admin/add-user.php');
        die();
    } else {
        //insert new user into users table
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) 
                              VALUES (:firstname, :lastname, :username, :email, :password, :avatar, :is_admin)";
        $stmt = $connection->prepare($insert_user_query);
        $stmt->execute([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'email' => $email,
            'password' => $hashed_password,
            'avatar' => $avatar_name,
            'is_admin' => $is_admin
        ]);

        if ($stmt->rowCount() > 0) {
            //Redirect to signup page with success message
            $_SESSION['add-user-success'] = "$firstname $lastname a bien été ajouté.";
            header('Location: ' . ROOT_URL . 'backend/admin/manage-user.php');
            die();
        }
    }
} else {
    //if button not clicked, return to signup page
    header('Location: ' . ROOT_URL . 'backend/admin/add-user.php');
    die();
}
?>
