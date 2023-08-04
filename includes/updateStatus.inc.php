<?PHP

require_once 'database.inc.php';
require_once 'functions.inc.php';

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
            if($oldStatus = checkOrderStatusExist($conn, (int)$orderid, $status)){
                updateOrderStatus($conn, (int)$orderid, $status, $oldStatus);
                header("location: ../PHP/admin/manageOrders.php?Onchange=Success");
                exit();
            }   
        }
    }
    else if(isset($_POST['changeProdStatus'])){            
        $prodId = $_POST['prodId'];
        $prodStatus = $_POST['changeProdStatus'];        
        
        // Create an empty associative array
        $prodStatuses = array();

        for ($i = 0; $i < count($prodId); $i++) {
            // Add the current order ID and order status as a key-value pair to the associative array
            $prodStatuses[$prodId[$i]] = $prodStatus[$i];
        }
        foreach ($prodStatuses as $prodId => $status) {
            if($oldStatus = checkProdStatusExist($conn, (int)$prodId, $status)){
                updateProdStatus($conn, (int)$prodId, $status, $oldStatus);
                header("location: ../PHP/admin/manageProducts.php?statusChange=Success");
                exit();
            }   
            
        }
    }
    else{
        header("location: ../PHP/admin/manageOrders.php?error=stmtFailed");
        exit();
    }

