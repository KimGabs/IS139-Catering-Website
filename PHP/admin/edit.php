<?php
include_once 'header.php';
include_once '../../includes/adminSidePanel.inc.php';
require_once '../../includes/database.inc.php';
ob_start();
?>
<link rel="stylesheet" href="../../css/editInventory.css">
<?php
if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $sql = "SELECT * FROM inventory WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $product_name = $row['product_name'];
            $quantity = $row['quantity'];
            $price = $row['price'];
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
            header("Location: inventory.php"); // Redirect back to the inventory page after successful update
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $conn->close();
?>

    <h1>Edit Item</h1>
    <form action="edit.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        Product Name: <input type="text" name="product_name" value="<?php echo $product_name; ?>" required> &nbsp;&nbsp;
        Quantity: <input type="number" name="quantity" value="<?php echo $quantity; ?>" required>&nbsp;&nbsp;
        Price: <input type="number" step="0.01" name="price" value="<?php echo $price; ?>" required>&nbsp;&nbsp;
        <input type="submit" name="update" value="Update">
    </form>
    
 <?php
    ob_end_flush();
include_once 'footer.php';
?>