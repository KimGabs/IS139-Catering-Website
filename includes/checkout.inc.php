<?php

    require_once 'database.inc.php';
    require_once 'functions.inc.php';

    function printCart($conn, $userID){
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "SELECT cart.prodId, cart.cartId, products.prodName, products.prodPrice, 
                products.prodImage, products.prodQty, cart.quantity 
                FROM cart JOIN products ON cart.prodId = products.prodId WHERE cart.usersID IN ($userID)";
        $result = mysqli_query($conn, $sql);
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='row d-flex align-items-center'>";
            echo "<div class='col-2'><img class='img-fluid' src=" . $row['prodImage'] . "></div>";
            echo "<div class='col-4'>" . $row['prodName'] . "</div>";
            echo "<div class='col'>" . $row['quantity'] . "</div>";
            echo "<div class='col'>₱" . $row['prodPrice'] . "</div>";
            echo "</div><hr>";
        }

        $sql = "SELECT * FROM orders WHERE orderStatus='pending' AND usersId='$userID'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $totalPrice = $row['totalPrice'] + $row['deliveryFee'];

            echo "<div class='row d-flex align-items-center'>";
            echo "<div class='col-8'>Subtotal</div>";
            echo "<div class='col'>₱" . $row['totalPrice'] . "</div>";
            echo "</div>";
            echo "<div class='row d-flex align-items-center'>";
            echo "<div class='col-8'>Shipping Fee</div>";
            echo "<div class='col'>₱" . $row['deliveryFee'] . "</div>";
            echo "</div><hr>";
            echo "<div class='row align-items-center'>";
            echo "<div class='col-8'>Total</div>";
            echo "<div class='col'>₱" . $totalPrice . "</div>";
            echo "</div>";
    }
