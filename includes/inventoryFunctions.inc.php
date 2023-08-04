<?php
require_once 'database.inc.php';
require_once 'functions.inc.php';

// CRUD Operations
// Add item to inventory

if (isset($_POST['submit'])) {
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql = "INSERT INTO inventory (product_name, quantity, price) VALUES ('$product_name', $quantity, $price)";
    $result = $conn->query($sql);

    if ($result) {
        header('location: ../PHP/admin/inventory.php?addItem=success');
        exit();
    } else {
        echo "Error: " . $conn->error;
        header('location: ../PHP/admin/inventory.php?addItem=failed');
        exit();
    }
}

// Update item in the inventory
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql = "UPDATE inventory SET product_name='$product_name', quantity=$quantity, price=$price WHERE id=$id";
    $result = $conn->query($sql);

    if ($result) {
        header('location: ../PHP/admin/inventory.php?updateItem=success');
        exit();
    } else {
        echo "Error: " . $conn->error;
        header('location: ../PHP/admin/inventory.php?updateItem=failed');
        exit();
    }
}

// Delete item from the inventory
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM inventory WHERE id=$id";
    $result = $conn->query($sql);

    if ($result) {
        header('location: ../PHP/admin/inventory.php?deleteItem=success');
        exit();
    } else {
        echo "Error: " . $conn->error;
        header('location: ../PHP/admin/inventory.php?deleteItem=failed');
        exit();
    }

}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql = "UPDATE inventory SET product_name='$product_name', quantity=$quantity, price=$price WHERE id=$id";
    $result = $conn->query($sql);

    if ($result) {
        header('location: ../PHP/admin/inventory.php?updateItem=success');
        exit();
    } else {
        echo "Error: " . $conn->error;
        header('location: ../PHP/admin/inventory.php?updateItem=failed');
        exit();
    }
}

$conn->close();