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
    $productCatergory = strtolower($_POST["category"]);
    $image = $_FILES['image'];

    if(emptyInputProduct($productName, $productDesc, $productCatergory, $productPrice) !== false){
        header("location: ../PHP/admin/addProduct.php?error=emptyinput");
        exit();    
    }

    $imagePath = uploadProductImage($image);

    if(prodExists($conn, $productName) !== false){
        header("location: ../PHP/admin/addProduct.php?error=productNameTaken");
        exit();    
    }

    addProduct($conn, $productName, $productDesc, $productCatergory, $productPrice, $imagePath);
    header("location: ../PHP/admin/addProduct.php?addProduct=success");
}

else{
    header("location: ../PHP/admin/addProduct.php");
    exit();    
}