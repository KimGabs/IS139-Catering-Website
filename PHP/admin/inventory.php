<?php
include_once 'header.php';
include_once '../../includes/adminSidePanel.inc.php';
require_once '../../includes/database.inc.php';
ob_start();
?>
<link rel="stylesheet" href="../../css/inventory.css">
<div class='d-flex flex-column' style='width: 1251px;'>
<div>
    <h1>Inventory Management</h1>
    <form action="inventory.php" method="post">
        <input type="hidden" name="id" value="">
        Product Name: <input type="text" name="product_name" required> &nbsp;&nbsp;
        Quantity: <input type="number" name="quantity" required>&nbsp;&nbsp;
        Price: <input type="number" step="0.01" name="price" required>&nbsp;&nbsp;
        <input type="submit" name="submit" value="Add Item">
    </form>
</div>
<br>
<div>
    <form action="inventory.php" method="post">
        Filter by Product Name: <input type="text" name="filter_product_name"> &nbsp;
        <input type="submit" name="filter_submit" value="Filter"> &nbsp;
        <input type="submit" name="reset_filter" value="Reset Filter">
    </form>
</div>
<br><br>
    <!-- Display the inventory table -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    <?php
        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM inventory";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr id='row'>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['product_name']."</td>";
                echo "<td>".$row['quantity']."</td>";
                echo "<td>".$row['price']."</td>";
                echo "<td><a href='edit.php?edit=".$row['id']."'>Edit</a></td>";
                echo "<td><a href='inventory.php?delete=".$row['id']."' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</a></td>";
                echo "</tr>";
            }
            } else {
                echo "<p>No items match the filter criteria.</p>";
            }

        
        // CRUD Operations
        // Add item to inventory
        if (isset($_POST['submit'])) {
            $product_name = $_POST['product_name'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];

            $sql = "INSERT INTO inventory (product_name, quantity, price) VALUES ('$product_name', $quantity, $price)";
            $result = $conn->query($sql);

            if ($result) {
                echo "Item added successfully.";
            } else {
                echo "Error: " . $conn->error;
            }

            $sql = "SELECT * FROM inventory";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['product_name']."</td>";
                    echo "<td>".$row['quantity']."</td>";
                    echo "<td>".$row['price']."</td>";
                    echo "<td><a href='edit.php?edit=".$row['id']."'>Edit</a></td>";
                    echo "<td><a href='inventory.php?delete=".$row['id']."' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
                } else {
                    echo "<p>No items match the filter criteria.</p>";
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
                echo "Item updated successfully.";
            } else {
                echo "Error: " . $conn->error;
            }
            $sql = "SELECT * FROM inventory";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['product_name']."</td>";
                    echo "<td>".$row['quantity']."</td>";
                    echo "<td>".$row['price']."</td>";
                    echo "<td><a href='inventory.php?edit=".$row['id']."'>Edit</a></td>";
                    echo "<td><a href='inventory.php?delete=".$row['id']."' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
                } else {
                    echo "<p>No items match the filter criteria.</p>";
                }
        }

        // Delete item from the inventory
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];

            $sql = "DELETE FROM inventory WHERE id=$id";
            $result = $conn->query($sql);

            if ($result) {
                echo "Item deleted successfully.";
            } else {
                echo "Error: " . $conn->error;
            }

            $sql = "SELECT * FROM inventory";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['product_name']."</td>";
                    echo "<td>".$row['quantity']."</td>";
                    echo "<td>".$row['price']."</td>";
                    echo "<td><a href='inventory.php?edit=".$row['id']."'>Edit</a></td>";
                    echo "<td><a href='inventory.php?delete=".$row['id']."' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
                } else {
                    echo "<p>No items match the filter criteria.</p>";
                }
            }
        
        //Filter items by Name
        if (isset($_POST['filter_submit'])) {
            $filter_product_name = $_POST['filter_product_name'];

            if(empty($filter_product_name)){
                header('location: ?emptyfilter');
                exit();
            }
        
            // Adjust the SQL query with the filter
            $sql = "SELECT * FROM inventory WHERE product_name LIKE '%$filter_product_name%'";
            $result = $conn->query($sql);
               
            // Display the filtered inventory table
            if ($result->num_rows > 0) {
        
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['product_name']."</td>";
                    echo "<td>".$row['quantity']."</td>";
                    echo "<td>".$row['price']."</td>";
                    echo "<td><a href='inventory.php?edit=".$row['id']."'>Edit</a></td>";
                    echo "<td><a href='inventory.php?delete=".$row['id']."' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
                } else {
                    echo "<p>No items match the filter criteria.</p>";
                }
        }
        if (isset($_POST['reset_filter'])) {
            // Clear the filter_product_name variable to reset the filter
            $filter_product_name = "";

            // Fetch all inventory items from the database
            $sql = "SELECT * FROM inventory";
            $result = $conn->query($sql);

            // Display the full inventory table
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['product_name']."</td>";
                    echo "<td>".$row['quantity']."</td>";
                    echo "<td>".$row['price']."</td>";
                    echo "<td><a href='inventory.php?edit=".$row['id']."'>Edit</a></td>";
                    echo "<td><a href='inventory.php?delete=".$row['id']."' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</a></td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No items in the inventory.</p>";
            }
        }
            
        $conn->close();
    ?>
    </table>
    </div>
    <?php
    ob_end_flush();
include_once 'footer.php';
?>