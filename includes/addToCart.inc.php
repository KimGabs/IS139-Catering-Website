<?php
session_start();

require_once 'database.inc.php';
require_once 'functions.inc.php';


  // Check if the user has added a product to their cart
  if (isset($_POST['addPackage'])) {
    // setcookie('cart', '', time() - 3600, '/'); 
    // Get the product ID and quantity from the form submission
    $rice = $_POST['rice'];
    $pax = $_POST['pax'];   
    $loc = $_POST['location'];

    if(empty($rice) || $rice === null){
        $rice = "off";
    }
    if(emptyPkgInput($pax) !== false){
        header("location: ../PHP/public/menu.php?show=modal&error=emptyInput");
        exit();    
    }
    if(invalidPax($pax) !== false){
        header("location: ../PHP/public/menu.php?show=modal&error=invalidpax");
        exit();    
    }

    $package = isset($_COOKIE["package"]) ? $_COOKIE["package"] : "[]";
    $package = json_decode($package);

    array_push($package, array(
        'rice' => $rice,
        'pax' => $pax,
    ));

    // Serialize the array to a JSON string
    $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
    $cart = json_decode($cart);

    array_push($cart, $package);
    
    setcookie("cart", json_encode($cart), time() + (86400 * 30), '/'); // Cookie expires in 30 days
    
    echo "<script>console.log('Unset Package Cookie...')</script>";
    setcookie("package", '', time() - 3600, '/'); 
    
    // Redirect the user back to the product catalog page
    header("Location: ../PHP/public/menu.php?addedToCart=success");
    exit();
}
else{
    header("Location: ../PHP/public/menu.php?addedToCart=failed");
    exit();
}
  