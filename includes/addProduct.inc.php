<?php


if (isset($_POST["submit"])) {
    
    if(isset($_SESSION["userType"])){
        if ($_SESSION["userType"] != "admin") {
            header("location: ../PHP/admin/login.php?error=nonAdmin");
            exit();
        }
    }

    require_once 'database.inc.php';
    require_once 'functions.inc.php';

    $productName = $_POST["name"];
    $productDesc = $_POST["desc"];
    $productPrice = $_POST["price"];
    $productQuantity = $_POST["quantity"];
    $productCatergory = strtolower($_POST["category"]);

    if(emptyInputProduct($productName, $productDesc, $productCatergory, $productPrice, $productQuantity) !== false){
        header("location: ../PHP/admin/addProduct.php?error=emptyinput");
        exit();    
    }

    $imagePath = uploadProductImage($_FILES['image']);

    if(prodExists($conn, $productName) !== false){
        header("location: ../PHP/admin/addProduct.php?error=productNameTaken");
        exit();    
    }

    addProduct($conn, $productName, $productDesc, $productCatergory, $productPrice, $productQuantity, $imagePath);
    header("location: ../PHP/admin/addProduct.php?addProduct=success");
}

else{
    header("location: ../PHP/admin/addProduct.php");
    exit();    
}