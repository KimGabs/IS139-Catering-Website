<?php

    require_once 'database.inc.php';
    require_once 'functions.inc.php';


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
        if (isset($_POST["order"])){
            
            $usersID = $_POST["userId"];
            $contactNo = $_POST["contactNo"];
            $address = $_POST["address"];
            $postal = $_POST["postal"];
            $city = $_POST["city"];

            if (emptyAddress($contactNo, $address, $postal, $city) !== false){
                header("location: ../PHP/public/checkout.php?error=emptyInput");
                exit();    
            }
            
            placeOrder($conn, $usersID, $address, $postal, $city, $contactNo);

            header("location: ../PHP/public/checkout.php?checkout");
            exit();
        }
        else{
            header("location: ../PHP/public/checkout.php?error=stmtFailedCheckout");
            exit();    
        }
    }
    else{
        header("location: ../PHP/public/checkout.php?error=stmtFailed");
        // exit();    
    }
