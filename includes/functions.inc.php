<?php
// Sign up functions
function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) {
    $result;
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUid($username) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../PHP/public/entry/register.php?error=stmtFailed");
        exit();  
    }
    
    mysqli_stmt_bind_param($stmt, "ss", $username, $email); #ss means two strings (username and email)
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $email, $username, $pwd) {
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../PHP/public/entry/register.php?error=stmtFailed");
        exit();  
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../PHP/public/entry/login.php");
    exit();    
}

// Log in functions
function emptyInputLogin($username, $pwd) {
    $result;
    if (empty($username) || empty($pwd)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../PHP/public/entry/login.php?error=wronglogin");
        exit();   
    }
    
    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd =password_verify($pwd, $pwdHashed);

    if($checkPwd === false){
        header("location: ../PHP/public/entry/login.php?error=wronglogin");
        exit();  
    }
    else if($checkPwd === true){
        session_start();
        $_SESSION["userid"] = $uidExists["usersID"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        $_SESSION["userName"] = $uidExists["usersName"];
        $_SESSION["userType"] = $uidExists["user_type"];
        $_SESSION["userType"] = $uidExists["user_type"];
        header("location: ../PHP/index.php");
        exit();   
    }
}


// ADD PRODUCT Function //
// Check if all fields are filled
function emptyInputProduct($productName, $productDesc, $productCatergory, $productPrice, $productQuantity) {
    $result;
    if (empty($productName) || empty($productDesc) || empty($productCatergory) || empty($productPrice) || empty($productQuantity)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

// Check if product name already exists
function prodExists($conn, $productName) {
    $sql = "SELECT * FROM products WHERE prodName=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../PHP/admin/addProduct.php?error=stmtFailed");
        exit();  
    }
    
    mysqli_stmt_bind_param($stmt, "s", $productName); #ss means two strings (username and email)
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

// Upload image function
function uploadProductImage($file) {
    // Get file name, type, and size
    $filename = $_FILES['image']['name'];
    $file = $_FILES['image'];
    $fileType = pathinfo($filename, PATHINFO_EXTENSION);
    $filesize = $_FILES['image']['size'];
    // file input is empty
    if (empty($filename)) { 
        header("location: ../PHP/admin/addProduct.php?error=emptyFile");
        exit();   
      }

    // Check if file is an image
    if($fileType !== "jpg" && $fileType !== "jpeg" && $fileType !== "png") {
        echo "Error: Only JPG, JPEG, and PNG files are allowed.";
        exit;
      }
  
    // Check file size (5MB max)
    $maxFileSize = 5 * 1024 * 1024;
    if ($filesize > $maxFileSize) {
        header("location: ../PHP/admin/addProduct.php?error=invalidFileSize");
        exit();  
    }
  
    // Generate unique file name and save to server
    $uniqueFilename = uniqid() . "-" . $filename;
    $uploadDir = "../img/products/";
    $uploadPath = $uploadDir . $uniqueFilename;
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        header("location: ../PHP/admin/addProduct.php?error=stmtFailedGenFileName");
        exit(); 
    }
    
    $uploadDir = "../../img/products/";
    $uploadPath = $uploadDir . $uniqueFilename;
    // Return path to saved image
    return $uploadPath;
  }

// Add product function
function addProduct($conn, $productName, $productDesc, $productCatergory, $productPrice, $productQuantity, $imagePath){
    // prepare statement to insert data into products table
    $sql = "INSERT INTO products (prodName, prodDesc, prodCat, prodPrice, prodQty, prodImage) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../PHP/admin/addProduct.php?error=stmtFailed");
        exit(); 
    }
    
    // close statement and connection
    if(mysqli_stmt_bind_param($stmt, "sssdis", $productName, $productDesc, $productCatergory, $productPrice, $productQuantity, $imagePath) === false){
        header("location: ../PHP/admin/addProduct.php?error=stmtFailedBind");    
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return;
}

// Update a product quantity in the cart page
function updateQuantity($conn, $cartId, $quantity, $prodId){

// Sanitize inputs to prevent SQL injection
$cartId = mysqli_real_escape_string($conn, $cartId);
$prodId = mysqli_real_escape_string($conn, $prodId);
$quantity = mysqli_real_escape_string($conn, $quantity);

// Check if the product exists in the cart table
$sql = "SELECT * FROM cart WHERE cartId='$cartId' AND prodId='$prodId'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// // Check the quantity of the product in the 'products' table
$query = "SELECT * FROM products WHERE prodId='$prodId'";
$result = mysqli_query($conn, $query);
$row_2 = mysqli_fetch_assoc($result);

if ($quantity > $row['quantity']) {
    $qty= $quantity - $row['quantity'];
    $newProdQty = $row_2['prodQty'] - $qty;
    // Update the quantity of the product in the 'products' table
    $query = "UPDATE products SET prodQty='$newProdQty' WHERE prodId='$prodId'";
    if (!mysqli_query($conn, $query)) {
        header("location: ../PHP/public/products.php?QuantityUpdateFailed");
        exit();
    }
}else if ($quantity < $row['quantity']) {
    $qty= $row['quantity'] - $quantity;
    $newProdQty = $row_2['prodQty'] + $qty;
    $query = "UPDATE products SET prodQty='$newProdQty' WHERE prodId='$prodId'";
    if (!mysqli_query($conn, $query)) {
        header("location: ../PHP/public/products.php?error=QuantityUpdateFailed");
        exit();
    }
}

if ($row) {
    // Update the quantity of the product in the cart table
    $sql = "UPDATE cart SET quantity='$quantity' WHERE cartId='$cartId' AND prodId='$prodId'";
    if (mysqli_query($conn, $sql)) {
        header("location: ../PHP/public/cart.php?QuantityUpdateSuccess");
        exit();
    }
} else {
    header("location: ../PHP/public/cart.php?error=prodNotFound");
    exit(); // Product not found in cart table
}

mysqli_close($conn);
}

// Remove Product/Item from cart
function removeFromCart($conn, $cartId, $usersID, $prodId) {

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM cart WHERE cartId = $cartId AND usersID = $usersID AND prodId = $prodId";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $sql = "UPDATE products SET prodQty = prodQty + ? WHERE prodId = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $row['quantity'], $prodId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $query = "DELETE FROM cart WHERE cartId = ? AND usersID = ? AND prodId = ?";
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "iii", $cartId, $usersID, $prodId);

    if(mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("location: ../PHP/public/cart.php?productRemoved");
        exit();
    } else {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("location: ../PHP/public/cart.php?error=stmtFailed");
        exit();
    }
}


function getDeliveryMethod($conn, $usersID, $dlvy){
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "UPDATE users SET deliveryMethod = ? WHERE usersID = ?";
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "si", $dlvy, $usersID);
    if(mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("location: ../PHP/public/cart.php?dlvy=updated");
        exit();
    } else {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("location: ../PHP/public/cart.php?error=stmtFailed");
        exit();
    }
}

function checkout($conn, $usersID, $delMethod, $delFee, $totalPrice){
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    updateOrder($conn, $usersID, $delMethod, $delFee, $totalPrice);
    header("location: ../PHP/public/checkout.php");
    exit();
}

function updateOrder($conn, $usersID, $delMethod, $delFee, $totalPrice){
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Check if the order already exists
    $stmt = $conn->prepare("SELECT * FROM orders WHERE usersId = ? AND orderStatus='pending'");
    $stmt->bind_param("i", $usersID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the existing order
        $stmt = $conn->prepare("UPDATE orders SET orderDate = NOW(), deliveryFee = ?, deliveryMethod = ?, totalPrice = ?
                                WHERE usersId = ? AND orderStatus='pending'");
        $stmt->bind_param("dsdi", $delFee, $delMethod, $totalPrice, $usersID);
        $stmt->execute();
        $stmt->close();
        return;
    } else{
        // Insert the order into the orders table
        $stmt = $conn->prepare("INSERT INTO orders (usersId, deliveryMethod, deliveryFee, totalPrice)
        VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isdd", $usersID, $delMethod, $delFee, $totalPrice);
        $stmt->execute();
        $stmt->close();
        return;
    }
}

function updateOrderItem($conn, $usersID){
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Check if the order already exists
    $stmt = $conn->prepare("SELECT orderId FROM orders WHERE usersId=? AND orderStatus='pending'");
    $stmt->bind_param("i", $usersID);
    $stmt->execute();
    $result1 = $stmt->get_result();

    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $orderId = $row['orderId'];
    }

    // Retrieve the cart data from the database for the current user
    $stmt = $conn->prepare("SELECT c.prodId, c.quantity, p.prodPrice 
                            FROM cart c 
                            INNER JOIN products p ON c.prodId = p.prodId 
                            WHERE c.usersID = ?");
    $stmt->bind_param("i", $usersID);
    $stmt->execute();
    $result2 = $stmt->get_result();

        // Insert each item from the cart into the order_items table with the newly created order_id
    while ($row = $result2->fetch_assoc()) {
        $stmt = $conn->prepare("INSERT INTO order_items (orderId, prodId, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $orderId, $row['prodId'], $row['quantity'], $row['prodPrice']);
        $stmt->execute();
        $stmt->close();
    }   
    
    return $orderId;
}

function emptyAddress($contactNo, $address, $postal, $city){
    $result;
    if (empty($contactNo) || empty($address) || empty($postal) || empty($city)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

// Finalize Purchase
function placeOrder($conn, $usersID, $address, $postal, $city, $contactNo){

    // Completes the order table
    fillOrder($conn, $usersID, $address, $postal, $city, $contactNo);
    
    // Inserts into order_item table
    $orderid = updateOrderItem($conn, $usersID);

    // Clear the cart for this user
    clearCart($conn, $usersID);

    // Updates order status 
    promotePendingStatus($conn, $usersID, $orderid);

    header("location: ../PHP/index.php?orderSubmit=success");
    exit();
}

function fillOrder($conn, $usersID, $address, $postal, $city, $contactNo){
    $stmt = $conn->prepare("UPDATE orders SET shippingAddress = ?, postal = ?, city = ?, 
    contactNo = ? WHERE usersId= ? AND orderStatus='pending'");
    $stmt->bind_param("ssssi",  $address, $postal, $city, $contactNo, $usersID);
    $stmt->execute();
    $stmt->close();
    return;
}

function clearCart($conn, $usersID){
    $stmt = $conn->prepare("DELETE FROM cart WHERE usersID = ?;");
    $stmt->bind_param("i", $usersID);
    $stmt->execute();
    $stmt->close();
    return;
}

function promotePendingStatus($conn, $usersID, $orderid){
    
    $stmt = $conn->prepare("SELECT orderStatus FROM orders WHERE usersId=? AND orderId=?");
    $stmt->bind_param("ii", $usersID, $orderid);
    $stmt->execute();
    $result1 = $stmt->get_result();
    $row = $result1->fetch_assoc();

    if($row['orderStatus'] == 'pending'){
        $stmt = $conn->prepare("UPDATE orders SET orderStatus = 'processing' WHERE usersID = ? AND orderId = ?");
        $stmt->bind_param("ii", $usersID, $orderid);
        $stmt->execute();   
        $stmt->close();   
        return;
    }
}

function checkStatusExist($conn, $orderid, $status) {
    $stmt = $conn->prepare("SELECT orderStatus FROM orders WHERE orderId=?");
    $stmt->bind_param("i", $orderid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($row = $result->fetch_assoc()){
        if($status != $row['orderStatus']){
            return $row['orderStatus'];
        }
        else{
            return false;
        }
    }
}

function updateOrderStatus($conn, $orderid, $newStatus, $oldStatus){
    if($newStatus != $oldStatus){
        $stmt = $conn->prepare("UPDATE orders SET orderStatus = ? WHERE orderId = ? AND orderStatus = ?");
        $stmt->bind_param("sis", $newStatus, $orderid, $oldStatus);
        $stmt->execute();   
        $stmt->close();   
        return;
    }else{
        header("location: ../PHP/admin/manageOrders.php?Onchange=stmtFailed");
        exit();
    }
}

function updateProducts($conn, $userid, $prodid, $name, $desc, $prodCategory, $price, $quantity){

  $stmt = $conn->prepare("SELECT user_type FROM users WHERE usersID = ?");
  $stmt->bind_param("i", $userid);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  if(!$row['user_type'] == 'admin'){
        header("location: ../PHP/index.php?error=nonAdmin");
        exit();
  }
  else{ 
    // Update the product table
    $query = "UPDATE products SET prodName=?, prodDesc=?, prodPrice=?, prodCat=?, prodQty=? WHERE prodId = ?";
    $stmt2 = $conn->prepare($query);
    $stmt2->bind_param("ssdsii", $name, $desc, $price, $prodCategory, $quantity, $prodid);
    $stmt2->execute();
    header("location: ../PHP/admin/manageProducts.php?updateProduct=Sucess");
    exit();
  }

}