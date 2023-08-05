<?php

    require_once 'database.inc.php';
    require_once 'functions.inc.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST["submitOrder"])){
            $name = $_POST["nameInput"];
            $contact = $_POST['contactInput'];
            $date = $_POST['dateInput'];
            $time = $_POST['timeInput'];
            $loc = $_POST['locInput'];
            $req = $_POST['request'];
            $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
		    $cart = json_decode($cart);
            
            submitForm($conn, $name, $contact, $date, $time, $loc, $cart, $req);
        }
        else if (isset($_POST["editPkg"])) {
            $pkgId = $_POST["packageId"];

            editPackageMethod($pkgId);

            header("location: ../PHP/public/cart.php?delivery");
            exit();
        }
        else if (isset($_POST["close"])) {

            $pkgId = $_POST["packageId"];
            $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
		    $cart = json_decode($cart);

            removeFromCart($pkgId, $cart);
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
