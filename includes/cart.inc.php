<?php

    require_once 'database.inc.php';
    require_once 'functions.inc.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST["checkout"])){
            $usersID = $_POST["userId"];
            $delMethod = $_POST['delMethod'];
            $delFee = $_POST['delFee'];
            $totalPrice = $_POST['subTotal'];            
            
            checkout($conn, $usersID, $delMethod, $delFee, $totalPrice);
        }
        else if (isset($_POST["dlvy-method"])) {
            $usersID = $_POST["userId"];
            $dlvy = $_POST['dlvy-method'];

            getDeliveryMethod($conn, $usersID, $dlvy);

            header("location: ../PHP/public/cart.php?delivery");
            exit();
        }
        else if (isset($_POST["close"])) {

            $prodId = $_POST["prodId"];
            $cartId = $_POST["cartId"];
            $usersID = $_POST["userId"];

            removeFromCart($conn, $cartId, $usersID, $prodId);
        }
        else if (isset($_POST["qty"])) {
            $quantity = $_POST["qty"];
            $prodId = $_POST["prodId"];
            $cartId = $_POST["cartId"];
            
            updateQuantity($conn, $cartId, $quantity, $prodId);
        }
        else{
            header("location: ../PHP/public/cart.php?error=stmtFailedCart-1");
            exit();    
        }
    }
    else{
        header("location: ../PHP/public/cart.php?error=stmtFailedCart-2");
        exit();    
    }
