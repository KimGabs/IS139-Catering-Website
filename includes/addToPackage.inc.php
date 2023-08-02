<?php
session_start();

require_once 'database.inc.php';

// Check if the product ID and quantity have been provided
if (!isset($_POST['prodId'])) {
    header("location: ../PHP/public/menu.php?error=prodIdNotProvided");
    exit();
}

if (isset($_POST['rf_package'])){

    $prodId = $_POST['prodId'];

    $package = isset($_COOKIE["package"]) ? $_COOKIE["package"] : "[]";
    $package = json_decode($package);
    
    $loc = $_POST['location'];
    
    $new_package = array();
    foreach ($package as $p){
        if ($p->prodId != $prodId){
            array_push($new_package, $p);
        }
    }
    
    setcookie("package", json_encode($new_package), time() + (86400 * 30), '/');
    
    if($loc != "modal"){
        header("location: ../PHP/public/menu.php?removed");
        // echo '<script>window.history.back();</script>';
        exit();
    }
    else{
        header("location: ../PHP/public/menu.php?show=modal");
        exit();
    }
}

    // Check if the user has added a product to their cart
if (isset($_POST['add_to_package'])) {

    // Get the product ID and quantity from the form submission
    $prodId = $_POST['prodId'];

    $package = isset($_COOKIE["package"]) ? $_COOKIE["package"] : "[]";
    $package = json_decode($package);

    array_push($package, array(
        'prodId' => $prodId,
    ));

    setcookie("package", json_encode($package), time() + (86400 * 30), '/'); // Cookie expires in 30 days
    header("location: ../PHP/public/menu.php?added");
    exit();
}
