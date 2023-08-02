<?php

if (isset($_POST["submitLogin"])) {
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $username = strtolower($username);
    
    require_once 'database.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputLogin($username, $pwd) !== false){
        header("location: ../PHP/public/entry/login.php?error=emptyinput");
        exit();    
    }
    
    loginUser($conn, $username, $pwd);
}

else{
    echo '<script>console.log("Else: login error")</script>';
    header("location: ../PHP/public/entry/login.php?postMethod=Failed");
    exit();    
}