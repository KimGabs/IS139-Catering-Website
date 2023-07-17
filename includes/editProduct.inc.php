<?php

if(isset($_POST['editProduct'])){
    
    require_once 'database.inc.php';
    require_once 'functions.inc.php';

    $userid = $_POST['userId'];
    $prodid = $_POST['prodId'];
    $name = $_POST['prodName'];
    $price = $_POST['prodPrice'];
    $qty = $_POST['prodQty'];
    $desc = $_POST['prodDesc'];
    $prodCategory = strtolower($_POST['prodCategory']);

    updateProducts($conn, $userid, $prodid, $name, $desc, $prodCategory, $price, $qty);
}