<?php

if(isset($_POST['editProduct'])){
    
    require_once 'database.inc.php';
    require_once 'functions.inc.php';

    $prodid = $_POST['prodId'];
    $name = $_POST['prodName'];
    $image = $_FILES['image-' . $prodid];
    $price = $_POST['prodPrice'];
    $prodCategory = strtolower($_POST['prodCat']);
    $desc = $_POST['prodDesc'];
    $desc_proxy = "Proxy description: false positive empty input";
    
    if(emptyInputProduct($name, $prodCategory, $desc_proxy, $price) !== false){
        header("location: ../PHP/admin/manageProducts.php?error=emptyinput");
        exit();    
    }
    // echo "<p>empty:" . empty($image['name']) . "</p> ";

    updateProducts($conn, $prodid, $name, $image, $price, $prodCategory, $desc);
}