<?php
session_start();

require_once 'database.inc.php';

// Check if the product ID and quantity have been provided
if (!isset($_POST['prodId'])) {
    header("location: ../PHP/public/products.php?error=prodIdNotProvided");
    exit();
}

if (isset($_POST['rf_package'])){

    $prodId = $_POST['prodId'];

    $package = isset($_COOKIE["package"]) ? $_COOKIE["package"] : "[]";
    $package = json_decode($package);
    
    $new_package = array();
    foreach ($package as $p){
        if ($p->prodId != $prodId){
            array_push($new_package, $p);
        }
    }
    setcookie("package", json_encode($new_package), time() + (86400 * 30), '/');
    header('Location: ../PHP/public/menu.php');
}

    // Check if the user has added a product to their cart
if (isset($_POST['add_to_package'])) {
    // $cart = json_decode($_COOKIE['package'], true);

    // Get the product ID and quantity from the form submission
    $prodId = $_POST['prodId'];
    $quantity = $_POST['quantity'];   
    // $loc = $_POST['loc'];

    $package = isset($_COOKIE["package"]) ? $_COOKIE["package"] : "[]";
    $package = json_decode($package);

    array_push($package, array(
        'prodId' => $prodId,
        'quantity' => $quantity
    ));

    setcookie("package", json_encode($package), time() + (86400 * 30), '/'); // Cookie expires in 30 days
    header('Location: ../PHP/public/menu.php');

    
    // // Check if the product is already in the 'cart' table
    // $sql = "SELECT * FROM cart WHERE prodId = '$prodId' AND usersID = '$userId'";
    // $result = mysqli_query($conn, $sql);

    // if (mysqli_num_rows($result) > 0) {
    //     // If it is, update the quantity
    //     $_SESSION['cart'][$prodId] += $quantity;
    //     // Insert or update the product and quantity into the cart table for the current user
    //     $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + ?
    //     WHERE prodId = ? AND usersID = ?");
    //     $stmt->bind_param("iii", $quantity, $prodId, $userId);
    //     $stmt->execute();
    //     $stmt->close();
    //     $direct;
    // } else {
    //     // If it isn't, add a new item to the cart
    //     $_SESSION['cart'][$prodId] = $quantity;
    //     // Insert the product and quantity into the cart table for the current user
    //     $stmt = $conn->prepare("INSERT INTO cart (usersID, prodId, quantity) VALUES (?, ?, ?)");
    //     $stmt->bind_param("iii", $userId, $prodId, $quantity);
    //     $stmt->execute();
    //     $stmt->close();
    //     $direct;
    // }

    // exit();
}
