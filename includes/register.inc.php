<?php

if (isset($_POST["submit"])) {
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];
    $username = strtolower($username);
    
    require_once 'database.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) !== false){
        header("location: ../PHP/public/entry/register.php?error=emptyinput");
        exit();    
    }
    if(invalidUid($username) !== false){
        header("location: ../PHP/public/entry/register.php?error=invalidUid");
        exit();    
    }
    if(invalidEmail($email) !== false){
        header("location: ../PHP/public/entry/register.php?error=invalidEmail");
        exit();    
    }
    if(pwdMatch($pwd, $pwdRepeat) !== false){
        header("location: ../PHP/public/entry/register.php?error=passwordsDontMatch");
        exit();    
    }
    if(uidExists($conn, $username, $email) !== false){
        header("location: ../PHP/public/entry/register.php?error=usernameTaken");
        exit();    
    }

    createUser($conn, $name, $email, $username, $pwd);

}
else {
    header("location: ../PHP/admin/myOrders.php");
}