<?php

require './backend/config/database.php';

//get signup data if signup button clicked
if (isset($_POST['submit'])){
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
}else{
    //if button not clicked, return to signup page
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}