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
        header("location: ../PHP/public/entry/login.php?error=wrongPassword");
        exit();  
    }
    else if($checkPwd === true){
        session_start();
        $_SESSION["userid"] = $uidExists["usersID"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        $_SESSION["userName"] = $uidExists["usersName"];
        $_SESSION["userType"] = $uidExists["user_type"];
        $_SESSION["userType"] = $uidExists["user_type"];
        header("location: ../PHP/admin/manageOrders.php");
        exit();   
    }
}


// ADD PRODUCT Function //
// Check if all fields are filled
function emptyInputProduct($productName, $productDesc, $productCatergory, $productPrice) {
    $result;
    if (empty($productName) || empty($productDesc) || empty($productCatergory) || empty($productPrice)) {
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
    $filename = $file['name'];
    $fileType = pathinfo($filename, PATHINFO_EXTENSION);
    $filesize = $file['size'];

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

    return $uploadPath;
  }

// Add product function
function addProduct($conn, $productName, $productDesc, $productCatergory, $productPrice, $imagePath){
    // prepare statement to insert data into products table
    $sql = "INSERT INTO products (prodName, prodDesc, prodCat, prodPrice, prodImage) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../PHP/admin/addProduct.php?error=stmtFailed");
        exit(); 
    }
    
    // close statement and connection
    if(mysqli_stmt_bind_param($stmt, "sssds", $productName, $productDesc, $productCatergory, $productPrice, $imagePath) === false){
        header("location: ../PHP/admin/addProduct.php?error=stmtFailedBind");    
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return;
}

// Remove Product/Item from cart
function removeFromCart($pkgId, $cart) {
    
    if(isset($cart[$pkgId])){
        unset($cart[$pkgId]);
    }

    // Re-index the array to avoid gaps
    $cart = array_values($cart);
    setcookie("cart", json_encode($cart), time() + (86400 * 30), '/');
    
    header("location: ../PHP/public/cart.php");
    exit();
    
}

function editPackageMethod($pkgId){

    $cart = isset($_COOKIE["cart"]) ? json_decode($_COOKIE["cart"]) : [];
    $package = isset($_COOKIE["package"]) ? json_decode($_COOKIE["package"]) : [];
    
    if(isset($package)){
        unset($package);
    }

    if (isset($cart[$pkgId])) {
        // Remove the element from the cart cookie
        $removedElement = array_splice($cart, $pkgId, 1)[0];
    
        // Add the removed element to the package cookie
        $package[] = $removedElement;
    
        // Update the cookies with the modified arrays
        setcookie("cart", json_encode($cart), time() + (86400 * 30), '/');
        setcookie("package", json_encode($package), time() + (86400 * 30), '/');
    }
    else{
        header("location: ../PHP/public/menu.php?editPkg=success");
        exit();    
    }
    header("location: ../PHP/public/menu.php?editPkg=success");
    exit();
    
}

function submitForm($conn, $name, $contact, $date, $time, $loc, $cart, $req){
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    updateOrder($conn, $name, $contact, $date, $time, $loc, $cart, $req);
    updateOrderItem($conn, $name, $cart);
    header("location: ../PHP/index.php?order=Submited");
    exit();
}

function updateOrder($conn, $name, $contact, $date, $time, $loc, $cart, $req){
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    session_start();
    $totalPrice = $_SESSION['totalPrice'];
    
    // Insert the order into the orders table
    $stmt = $conn->prepare("INSERT INTO orders (cxName, contactNo, eventDate, eventTime, eventLocation, request, totalPrice)
    VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssd", $name, $contact, $date, $time, $loc, $req, $totalPrice);
    $stmt->execute();
    $stmt->close();
    return;
}

function updateOrderItem($conn, $name, $cart){
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Check if the order already exists
    $stmt = $conn->prepare("SELECT orderId FROM orders WHERE cxName=? AND orderStatus='pending'");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result1 = $stmt->get_result();

    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $orderId = $row['orderId'];
    }

    $sql = "SELECT * FROM products";
    $result2 = mysqli_query($conn, $sql);
    $pkg_count = 0;
    foreach ($cart as $pkg) {
        $pkg_count++;
        $prodPrice = 0;
        $pax = 0;
        $pkgTotal = 0;
        $ricePrice = 0;
        foreach ($pkg as $item) {
            if (isset($item->rice)) {
                $rice = $item->rice;
                if ($rice == "on"){
                    $ricePrice = 10;
                }else{$ricePrice = 0;}
            }
            if (isset($item->pax)) {
                $pax = $item->pax;
            }
        }
        foreach ($pkg as $item) {
            if (isset($item->prodId)) {
                mysqli_data_seek($result2, 0);
                while ($row = mysqli_fetch_assoc($result2)) {
                    if ($item->prodId == $row["prodId"]) {
                        $pkgTotal += $row['prodPrice'];
                    }
                }
            }
        }
        $pkgTotal = ($pkgTotal * $pax) + ($pax * $ricePrice);
        foreach ($pkg as $item) {
            if (isset($item->prodId)) {
                mysqli_data_seek($result2, 0);
                while ($row = mysqli_fetch_assoc($result2)) {
                    if ($item->prodId == $row["prodId"]) {
                        $prodid = $row['prodId'];
                        $prodPrice = $row['prodPrice'];
                        $stmt = $conn->prepare("INSERT INTO order_items (orderId, pkgId, prodId) VALUES (?, ?, ?)");
                        $stmt->bind_param("iii", $orderId, $pkg_count, $row['prodId']);
                        $stmt->execute();
                    }
                }
            } 
            $subtotal = $prodPrice * $pax;
            $stmt = $conn->prepare("UPDATE order_items SET rice = ?, pax = ?, total = ?, pkgTotal = ? WHERE orderId = ? AND pkgId = ? AND prodId = ?");
            $stmt->bind_param("siddiii", $rice, $pax, $subtotal, $pkgTotal, $orderId, $pkg_count, $prodid);
            $stmt->execute();
            $stmt->close();
        }
        
    }
    $emptyCart = [];
    setcookie('cart', json_encode($emptyCart), time() + (86400 * 30), '/'); // Clear cookie after submission
    return;
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

function checkOrderStatusExist($conn, $orderid, $status) {
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

function checkProdStatusExist($conn, $prodId, $status) {
    $stmt = $conn->prepare("SELECT prodStatus FROM products WHERE prodId=?");
    $stmt->bind_param("i", $prodId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($row = $result->fetch_assoc()){
        if($status != $row['prodStatus']){
            return $row['prodStatus'];
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
        header("location: ../PHP/admin/manageOrders.php?statusChange=stmtFailed");
        exit();
    }
}

function updateProdStatus($conn, $prodId, $newStatus, $oldStatus){
    if($newStatus != $oldStatus){
        $stmt = $conn->prepare("UPDATE products SET prodStatus = ? WHERE prodId = ? AND prodStatus = ?");
        $stmt->bind_param("sis", $newStatus, $prodId, $oldStatus);
        $stmt->execute();   
        $stmt->close();   
        return;
    }else{
        header("location: ../PHP/admin/manageProducts.php?statusChange=stmtFailed");
        exit();
    }
}

function updateProducts($conn, $prodid, $name, $image, $price, $prodCategory, $desc){
  if($_SESSION["userType"] == 'admin'){
    header("location: ../PHP/index.php?error=nonAdmin");
    exit();
  }
  if (empty($image['name'])){
      $query = "UPDATE products SET prodName=?, prodDesc=?, prodPrice=?, prodCat=?  WHERE prodId = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("ssdsi", $name, $desc, $price, $prodCategory, $prodid);
      $stmt->execute();
      header("location: ../PHP/admin/manageProducts.php?updateProduct=sucess");
      exit();
}
else{ 
    $imagePath = uploadProductImage($image);
    $query = "UPDATE products SET prodName=?, prodDesc=?, prodPrice=?, prodCat=?, prodImage=? WHERE prodId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdssi", $name, $desc, $price, $prodCategory, $imagePath, $prodid);
    $stmt->execute();
    header("location: ../PHP/admin/manageProducts.php?updateProduct=sucessImg");
    exit();
  }
}

function updateOrderInfo($conn, $orderId, $cxName, $eventDate, $eventTime, $contactNo, $eventLocation, $request){
    if($_SESSION["userType"] == 'admin'){
          header("location: ../PHP/index.php?error=nonAdmin");
          exit();
    }
    else{ 
      // Update the product table
      $query = "UPDATE orders SET cxName=?, eventDate=?, eventTime=?, contactNo=?, eventLocation=?, request=? WHERE orderId = ?";
      $stmt2 = $conn->prepare($query);
      $stmt2->bind_param("ssssssi", $cxName, $eventDate, $eventTime, $contactNo, $eventLocation, $request, $orderId);
      $stmt2->execute();
      header("location: ../PHP/admin/manageOrders.php?updateOrderInfo=success");
      exit();
    }

}


function emptyPkgInput($pax) {
    $result;
    if (empty($pax)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidPax($pax) {
    $result;
    $paxInt = intval($pax);

    if ($paxInt < 30) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function formatTimestamp($dateString) {
    $timestamp = strtotime($dateString);

    $month = date('m', $timestamp); 
    $day = date('d', $timestamp);   
    $year = date('Y', $timestamp);  
    $time12hr = date('h:i A', $timestamp); 

    return array($month, $day, $year, $time12hr);
}