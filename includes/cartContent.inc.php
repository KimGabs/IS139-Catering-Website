<?php
// CART CONTENT AND SUMMARY SYSTEM //
function cartContent($conn, $cart){
    if(!empty($cart)){
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);
        $pkg_count = 0;
        // getCart($result, $cart);
        $_SESSION['pkgCount'] = 0;
        $_SESSION['totalPrice'] = 0;
        foreach ($cart as $pkg) {
            $foundProdId = false;
            $pkg_count++;
            $_SESSION['pkgCount'] = $pkg_count;
            $foundRiceAndPax = false;
            $total = 0;
            foreach ($pkg as $item) {
                // Get pkg img template
                if (!$foundRiceAndPax){
                    if (isset($item->prodId)) {
                        mysqli_data_seek($result, 0);
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($item->prodId == $row["prodId"]){
                                $total = $total + $row["prodPrice"];
                            }
                        }
                    }
                    if (isset($item->prodId) && !$foundProdId) {
                        $product = null;
                        mysqli_data_seek($result, 0);
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($item->prodId == $row["prodId"]){
                                $foundProdId = true; // Set this to true so that we won't print other prodIds
                                break;
                            }
                        }
                        // Print the product details if found
                        if ($foundProdId) {
                            echo "<div class='row border-top border-bottom'>";
                            echo "<div class='row main align-items-center'>";
                            echo "";
                            echo "<div class='col-md-2'><a type='button' class='' data-toggle='modal' data-target='#pkgWindow-" . $pkg_count . "'><img class='img-fluid' src=" . $row['prodImage'] . "></a></div>";
                            echo "";
                            echo "<div class='col-2'>";
                            echo "<a type='button' class='' data-toggle='modal' data-target='#pkgWindow-" . $pkg_count . "'>Package " . $pkg_count . "</a>";        
                            // echo '<button type="button" class="menu-btn" data-toggle="modal" data-target="#productModal' . $row["prodId"] . '">View Details</button>';
                            echo "</div>";
                            // break;
                        }
                    }  
                    if (isset($item->rice) && isset($item->pax)) {
                        $totalPrice = ($total*$item->pax);
                        $_SESSION['totalPrice'] += $totalPrice;
                        echo "<div class='col'>";
                        echo "<form action='../../includes/cart.inc.php' id='rf_Cart' method='post'>";
                        if(isset($item->rice)){
                            $Rice = ($item->rice == "on") ? "Yes" : "No";
                            echo "<div class='col'>Rice: " . $Rice . " | PAX: " . $item->pax . "</div>";
                            $foundRiceAndPax = true; 
                        }
                        echo "<input type='hidden' name='packageId' value='" . $pkg_count-1 . "'>";
                        echo '<input type="hidden" name="close">';
                        echo "</form>";
                        echo "</div>";
                        echo "<div class='col'>";
                        echo "<span>₱" . number_format((float)$totalPrice, 2, '.', ',') . "</span>";
                        echo "<button class='close' onclick='removeFromCart()'>&#10005;</button>";
                        echo "</div></div></div>";
                    }
                }
            }
        }
    }
    else{
        echo "<p style='text-align: center; font-weight: bold'>Your cart is empty...</p>";
    }   
}

function summary($conn, $userID){

        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);

        // $totalPrice = $row['total_price'];
        echo "<div class='row' id='delivery-option'>";
        echo "</div>";
        echo "<form id='orderForm' action='../../includes/cart.inc.php' method='post'>";
        echo "<label type='text' for='nameInput' class='inputInfo'>Name</label>";
        echo "<input name='nameInput' class='form-control code' placeholder='Enter name' required>";
        echo "<label for='contactInput' class='inputInfo'>Contact Number</label>";
        echo "<input type='text' name='contactInput' class='form-control code' placeholder='Enter contact number' maxlength='11' required>";

        echo "<div class='col align-items-center justify-content-left' style='padding: 0'>";;
        echo "<label for='dateInput' class='inputInfo'>Date</label>";
        echo "<input type='date' name='dateInput' class='form-control code' placeholder='Enter date of event' style='margin-left: 1vh' required>";
        echo "<div class='input-group date' id='datepicker' style='position:absolute;'></div>";
        echo "</div>";

        echo "<div class='col align-items-center justify-content-left' style='padding: 0'>";
        echo "<label for='timeInput' class='inputInfo'>Time</label>";
        echo "<input type='time' name='timeInput' class='form-control code' placeholder='Enter time of event' style='margin-left: 1vh' required>";
        echo "</div>";

        echo "<div class='col-12 align-items-center justify-content-left locInfo' style='padding: 0'>";
        echo "<label for='locInput' class='inputInfo'>Location</label>";
        echo "<textarea type='text' name='locInput' class='form-control code' placeholder='Enter location of event' rows='2' required></textarea>";
        echo "</div>";


        echo "<div class='row req-row'>";
        echo "<p style='margin-top: 1em; padding-left: 0'>Special Request</p>";
        echo "<textarea class='form-control' id='request' rows='3' name='request' style='margin-bottom: 1em' placeholder='Enter special request'></textarea>";
        echo "<input type='hidden' name='submitOrder'>";
        echo "</form>";
        echo "</div>";
        echo "<div class='row' style='margin-top: 1em'>";
        echo "<div class='col'>TOTAL PRICE</div>";
        echo "<div class='col text-right'>₱" . number_format((float)$_SESSION['totalPrice'], 2, '.', ',') . "</div>";
        echo "</div>";
        echo "<button type='button' name='checkout' onclick='submitOrder()' class='btn' style='border-radius: 8px;'>SUBMIT</button>";
    
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

function getCart($result, $pkg){
    if (is_array($pkg) && isset($pkg)) {
        echo '<div class="col-md-7 modal-body-left">';
        $subtotal = 0.00;
        $init = 0;
        $pax = 0;
        foreach ($pkg as $item) {
            if (isset($item->pax)) {
                $pax = $item->pax;
            }
        }
        foreach ($pkg as $item) {
            if (isset($item->prodId)) {
                mysqli_data_seek($result, 0); // Reset the pointer to the beginning of $result
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($item->prodId == $row["prodId"]){
                        $init++;
                        if($init != 1){
                            echo '<hr class="hr-modal" style="margin-top:0">';
                        }
                        echo '<div class="row pkg-mod">';
                        // echo '<div class="col-1"></div>';
                        echo '<div class="col-md-3 col-pkg-mod pkg-img"><img src="' . $row["prodImage"] . '" alt=""></div>';
                        echo '<div class="col-md-4 col-pkg-mod align-self-center">' . $row["prodName"] . "</div>";
                        echo '<div class="col-md-5 col-pkg-mod align-self-center">₱' . $row["prodPrice"] . " / ₱" . number_format(($row["prodPrice"] * $pax), 2, '.', ',') ."</div>";
                        echo '<input id="prodIdElement" type="hidden" name="prodId" value="' . $row['prodId'] . '">';
                        echo '<input id="locationElement" type="hidden" name="location" value="modal">';
                        $subtotal += $row['prodPrice'];
                        echo '</div>';
                    }
                }
            }        
        }
        echo '</div>';
        foreach ($pkg as $item) {
            if (isset($item->rice) && isset($item->pax)) {
                echo '<div class="col-md-5 modal-body-right">';
                echo '<div class="pkg-form">';
                echo '<div class="row pkg-row-mod">';
                echo '<div class="col d-flex align-items-center">';
                if($item->rice == "on"){$wRice = "Yes";$ricePrice = 10;}else{$wRice = "No";$ricePrice = 0;}
                echo '<p style="margin-bottom: 8px;">With Rice: ' . $wRice . '</p>';
                echo '</div></div>';
                echo '<div class="row pkg-row-mod">';
                echo '<div class="col d-flex align-items-center">';
                echo '<p style="margin-bottom: 8px;">PAX: ' . $item->pax . '</p>';
                echo '</div></div>';
                echo '<div class="row pkg-row-mod">';
                echo '<div class="col d-flex align-items-center">';
                echo '<p class="" style="margin-bottom: 0.5rem;">Rice: ₱' . number_format(($item->pax * $ricePrice), 2, '.', ',') . '</p>';
                echo '</div></div>';
                echo '<div class="row pkg-row-mod">';
                echo '<div class="col d-flex align-items-center">';
                echo '<p class="" style="margin-bottom: 0.5rem;">Subtotal: ₱' . number_format(($subtotal * $item->pax), 2, '.', ',') . '</p>';
                echo '</div></div>';
                echo '<div class="row pkg-row-mod">';
                echo '<div class="col d-flex align-items-center">';
                echo '<p class="">Total: ₱' . number_format(($subtotal * $item->pax) + ($item->pax * $ricePrice), 2, '.', ',') . '</p>';
                echo '</div></div>';
                echo '</div>';
                echo '</div>';
            }
        }
    }
}

function showPackageDetails($conn, $cart){
    $pkg = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
    $pkg = json_decode($pkg);
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);
    $pkg_count = 0;
    foreach($cart as $pkg){
        $pkg_count++;
        echo '<div class="modal fade" id="pkgWindow-' . $pkg_count . '" tabindex="-1" role="dialog" aria-labelledby="pkgWindow-' . $pkg_count . '" aria-hidden="true">';
        // Generate modal for package info
        echo '<form action="../../includes/cart.inc.php" method="post" id="editForm">';
        echo '<input type="hidden" name="packageId" value="' . $pkg_count-1 . '">';
        echo '<input type="hidden" name="editPkg">';
        echo '</form>';
        echo '<div class="modal-dialog pkg-modal-dialog" role="document" style="margin: 1.75rem auto;">';
        echo '<div class="modal-content">';
        echo '<div class="modal-header" style="padding: 10px 2rem; align-items: center;">';
        echo '<h5 class="modal-title" id="modal-Title">Package Summary</h5>';
        echo '<button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';
        echo '<div class="modal-body row" style="text-align:center; margin: 0; padding: 0rem 0;">';
        
        getCart($result, $pkg);

        echo '</div>';
        echo '<div class="modal-footer-2 px-0">';
        echo '<button id="addToCartBtn" name="editPackage" onclick="" class="d-flex justify-content-center align-items-center btn btn-pkg-mod edit-pkg-btn">';
        echo '<i class="bi bi-pencil-square" style="margin-right:5px;font-size:18px;"></i>';
        echo 'Edit Package</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}