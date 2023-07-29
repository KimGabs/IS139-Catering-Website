<?php
session_start();

require_once 'database.inc.php';

// Check if the product ID and quantity have been provided
if (!isset($_POST['prodId'])) {
    header("location: ../PHP/public/products.php?error=prodIdNotProvided");
    exit();
}

  // Check if the user has added a product to their cart
  if (isset($_POST['add_to_package'])) {

    // Get the product ID and quantity from the form submission
    $prodId = $_POST['prodId'];
    $quantity = $_POST['quantity'];   
    $loc = $_POST['loc'];
    // Get the user ID from the session
    $cartNum = $_SESSION['cart'];
    if($loc == 'index'){
        // $direct = header('Location: ../PHP/index.php?addedToCart=success');
        $direct = header('Location: ../PHP/index.php?addedToCart=success');
    }
    else{
        $direct = header('Location: ../PHP/public/products.php?addedToCart=success');
    }

    // Check the quantity of the product in the 'products' table
    $query = "SELECT * FROM products WHERE prodId='$prodId'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $newProdQty = $row['prodQty'] - $quantity;

    if ($row['prodQty'] > 0) {
        // Update the quantity of the product in the 'products' table
        $query = "UPDATE products SET prodQty='$newProdQty' WHERE prodId='$prodId'";
        if (!mysqli_query($conn, $query)) {
            header("location: ../PHP/public/products.php?QuantityUpdateFailed");
            exit();
        }
    }else {
        header("location: ../PHP/public/products.php?error=prodQtyZero");
        exit(); // Product not found in cart table
    }

    
    // Check if the product is already in the 'cart' table
    $sql = "SELECT * FROM cart WHERE prodId = '$prodId' AND usersID = '$userId'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // If it is, update the quantity
        $_SESSION['cart'][$prodId] += $quantity;
        // Insert or update the product and quantity into the cart table for the current user
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + ?
        WHERE prodId = ? AND usersID = ?");
        $stmt->bind_param("iii", $quantity, $prodId, $userId);
        $stmt->execute();
        $stmt->close();
        $direct;
    } else {
        // If it isn't, add a new item to the cart
        $_SESSION['cart'][$prodId] = $quantity;
        // Insert the product and quantity into the cart table for the current user
        $stmt = $conn->prepare("INSERT INTO cart (usersID, prodId, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $userId, $prodId, $quantity);
        $stmt->execute();
        $stmt->close();
        $direct;
    }

    // Redirect the user back to the product catalog page
    
    exit();
}
  