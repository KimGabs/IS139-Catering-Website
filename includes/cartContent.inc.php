<?php

// CART CONTENT AND SUMMARY SYSTEM //
function cartContent($conn, $userID){
    if(checkUserInCart($conn, $userID)){
        retrieveCart($conn, $userID);
        $sql = "SELECT cart.prodId, cart.cartId, products.prodName, products.prodPrice, 
                products.prodImage, products.prodQty, cart.quantity 
                FROM cart JOIN products ON cart.prodId = products.prodId WHERE cart.usersID IN ($userID)";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='row border-top border-bottom'>";
            echo "<div class='row main align-items-center'>";
            echo "<div class='col-2'><img class='img-fluid' src=" . $row['prodImage'] . "></div>";
            echo "<div class='col'>";
            echo "<div class='row'>" . $row['prodName'] . "</div>";
            echo "</div>";
            echo "<div class='col'>";
            echo "<form action='../../includes/cart.inc.php' class='qty-form' method='post'>";
            echo "<button class='minus-btn' type='button' name='subtract'>–</button>";
            echo "<input type='number' name='qty' class='qty' min='1' max=" . $row['prodQty'] . " maxlength='3' value=" . $row['quantity'] . ">";
            echo "<button class='plus-btn' type='button' name='add'>+</button>";
            echo "<input type='hidden' name='cartId' value=" . $row['cartId'] . ">";
            echo "</div>";
            echo "<div class='col'>";
            echo "<span>₱" . $row['prodPrice'] . "</span>";
            echo "<form action='../../includes/cart.inc.php' class='qty-form' method='post'>";
            echo "<button class='close' name='close'>&#10005;</button>";
            echo "<input type='hidden' name='userId' value=" . $userID . ">";
            echo "<input type='hidden' name='prodId' value=" . $row['prodId'] . ">";
            echo "<input type='hidden' name='cartId' value=" . $row['cartId'] . ">";
            echo "</form></div>";
            echo "</div></div>";
        }
    }
    else{
        echo "<p style='text-align: center; font-weight: bold'>Your cart is empty...</p>";
    }   
}

function summary($conn, $userID){
    if(checkUserInCart($conn, $userID)){
        // Statement to get total quantity and price of the products in the user's cart
        // $sql = "SELECT SUM(cart.quantity) AS total_quantity, SUM(products.prodPrice * cart.quantity) AS total_price
        //         FROM cart JOIN products ON cart.prodId = products.prodId WHERE cart.usersID = $userID";
        // $result = mysqli_query($conn, $sql);

        $sql = "SELECT SUM(cart.quantity) AS total_quantity, SUM(products.prodPrice * cart.quantity) AS total_price,
        (SELECT deliveryMethod FROM users WHERE usersID = $userID) AS delivery_method FROM cart JOIN products ON cart.prodId = products.prodId 
        WHERE cart.usersID = $userID";

        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)){
            if ($row['delivery_method'] == 'standard'){$delFee = 50.00;}
            else if($row['delivery_method'] == 'express'){$delFee = 70.00;}
            else{$delFee = 80.00;}

            $totalPrice = $row['total_price'] + $delFee;

            
            echo "<div class='row' id='delivery-option'>";
            echo "<div class='col' style='padding-left:0;''>Items: " . $row['total_quantity'] . "</div>";
            echo "<div class='col text-right'>₱" . $row['total_price'] .  "</div>";
            echo "</div>";
            echo "<form id='delivery-form' action='../../includes/cart.inc.php' method='post'>";
            echo "<p style='margin-top:2em'>SHIPPING</p>";
            echo "<select class='delivery' selected='express' name='dlvy-method' onchange='submitDeliveryForm()'>";
            if ($row['delivery_method'] == 'standard'){
            echo "<option class='text-muted' value='standard' selected='selected'>Standard Delivery: ₱50.00</option>";
            }else{echo "<option class='text-muted' value='standard'>Standard Delivery: ₱50.00</option>";}
            if ($row['delivery_method'] == 'express'){
                echo "<option class='text-muted' value='express' selected='selected'>Express Delivery: ₱70.00</option>";
            }else{echo "<option class='text-muted' value='express'>Express Delivery: ₱70.00</option>";}
            if ($row['delivery_method'] == 'large'){
                echo "<option class='text-muted' value='large' selected='selected'>Large-item Delivery: ₱80.00</option>";
            }else{echo "<option class='text-muted' value='large'>Large-item Delivery: ₱80.00</option>";}
            echo "</select>";
            echo "<input type='hidden' name='userId' value=" . $userID . ">";
            echo "</form>";
            echo "<p>GIVE CODE</p>";
            echo "<input id='code' placeholder='Enter your code'>";
            echo "<div class='row' style='border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;'>";
            echo "<div class='col'>TOTAL PRICE</div>";
            echo "<div class='col text-right'>₱" . number_format($totalPrice, 2, '.', '') . "</div>";
            echo "</div>";
            echo "<form action='../../includes/cart.inc.php' method='post'>";
            echo "<input type='hidden' name='userId' value=" . $userID . ">";
            echo "<input type='hidden' name='delMethod' value=" . $row['delivery_method'] . ">";
            echo "<input type='hidden' name='delFee' value=" . $delFee . ">";
            echo "<input type='hidden' name='subTotal' value=" . $row['total_price'] . ">";
            echo "<input type='hidden' name='totalPrice' value=" . $totalPrice . ">";
            echo "<button name='checkout' class='btn'>CHECKOUT</button>";
            echo "</form>";
        }
    }
    
}

// Define the function to check whether the userID is present in the cart table
function checkUserInCart($conn, $userID) {
    // Create a query to check if the userID is present in the cart table
    $sql = "SELECT * FROM cart WHERE usersID = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // If there is an error with the query, return false
        return false;
    } else {
        // Bind the userID parameter to the query
        mysqli_stmt_bind_param($stmt, "i", $userID);
        // Execute the query
        mysqli_stmt_execute($stmt);
        // Store the result of the query
        $result = mysqli_stmt_get_result($stmt);
        // Check if there are any rows in the result set
        if (mysqli_num_rows($result) > 0) {
            // If there are rows, return true
            return true;
        } else {
            // If there are no rows, return false
            return false;
        }
    }
}

// Retrieve the user's cart
function retrieveCart($conn, $userID){
    // Retrieve cart data from database
    $sql = "SELECT * FROM cart WHERE usersID = $userID";
    $result = mysqli_query($conn, $sql);

    // Store cart data in session
    $cart = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $cart[$row['prodId']] = $row['quantity'];
    }
    $_SESSION['cart'] = $cart;
}

