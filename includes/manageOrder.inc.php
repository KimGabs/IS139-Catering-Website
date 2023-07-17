<?PHP

require_once 'database.inc.php';
require_once 'functions.inc.php';

$count=0;
    if(isset($_POST['changeOrderStatus'])){            
        $orderid = $_POST['orderId'];
        $orderStatus = $_POST['changeOrderStatus'];        
        
        // Create an empty associative array
        $orderStatuses = array();

        for ($i = 0; $i < count($orderid); $i++) {
            // Add the current order ID and order status as a key-value pair to the associative array
            $orderStatuses[$orderid[$i]] = $orderStatus[$i];
        }
        foreach ($orderStatuses as $orderid => $status) {
            if($oldStatus = checkStatusExist($conn, (int)$orderid, $status)){
                updateOrderStatus($conn, (int)$orderid, $status, $oldStatus);
                header("location: ../PHP/admin/manageOrders.php?Onchange=Success");
                exit();
            }   
            
        }
    }
    else{
        header("location: ../PHP/admin/manageOrders.php?error=stmtFailed");
        exit();
    }

    // echo "Order ID: " . $orderid . ", Status: " . $status . "<br>";