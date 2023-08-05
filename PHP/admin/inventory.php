<?php
include_once 'header.php';
include_once '../../includes/adminSidePanel.inc.php';
require_once '../../includes/database.inc.php';
// ob_start();
?>
<link rel="stylesheet" href="../../css/inventory.css">
<div class='container' style='width: 1200px;'>
<div>
    <h1>Inventory Management</h1>
    <form action="../../includes/inventoryFunctions.inc.php" method="post">
        <input type="hidden" name="id" value="">
        <label for="">Item Name:</label>
        <input type="text" name="product_name" required> &nbsp;&nbsp;
        <label for="">Quantity:</label>
        <input type="number" name="quantity" required>&nbsp;&nbsp;
        <label for="">Price:</label>
        <input type="number" step="0.01" name="price" required>&nbsp;&nbsp;
        <button class="btn btn-primary" type="submit" name="submit">Add Item</button>
    </form>
</div>
<br>
<div>
    <form action="inventory.php" method="get">
        <label for="">Filter by Item Name:</label>
        <input type="text" name="filter_product_name"> &nbsp;
        <button class="btn btn-warning" type="submit" name="filter_submit">Filter</button> &nbsp;
        <button class="btn btn-primary" type="submit" name="reset_filter">Reset Filter</button>
    </form>
</div>
<br><br>
    <!-- Display the inventory table -->
    <table class="table table-striped table-hover" border="1">
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th></th>
            <th></th>
        </tr>
    <?php
        
        // Pagination variables
        $results_per_page = 12; // Number of messages to display per page
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $start_index = ($current_page - 1) * $results_per_page;


        if (isset($_GET['filter_submit'])) {
            $filter_product_name = $_GET['filter_product_name'];
            $sql = "SELECT * FROM inventory WHERE product_name LIKE '%$filter_product_name%' ORDER BY id DESC LIMIT $start_index, $results_per_page";
        }
        else{
            $sql = "SELECT * FROM inventory ORDER BY id DESC LIMIT $start_index, $results_per_page";
        }
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr id='row'>";
                echo "<td class='align-middle'>".ucfirst($row['product_name'])."</td>";
                echo "<td class='align-middle'>".$row['quantity']."</td>";
                echo "<td class='align-middle'>₱".number_format($row['price'], 2, '.', ',')."</td>";
                echo '<td class="align-middle"><button type="button" class="menu-btn btn" data-toggle="modal" data-target="#itemModal' . $row["id"] . '" style="background-color: #0D98BA; color: white;">Edit Item</button></td>';
                echo '<form action="../../includes/inventoryFunctions.inc.php" method="post">';
                echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                echo "<td class='align-middle'><button class='btn btn-danger' type='submit' name='delete' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</button></td>";
                echo '</form>';
                echo "</tr>";

                echo '<div class="modal fade in" id="itemModal' . $row["id"] . '" tabindex="-1" role="dialog" aria-labelledby="itemModal' . $row["id"] . 'Label" aria-hidden="true">';
                echo '<div class="modal-dialog modal-dialog-centered" role="document">';
                echo '<div class="modal-content">';
                echo '<div class="modal-header" style="padding-top: 0.5rem;">';
                echo '<h5 class="modal-title">Edit ' . $row["product_name"] . '</h5>';
                echo '<button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '</button>';
                echo '</div>';
                echo '<div class="modal-body">';
                echo '<form action="../../includes/inventoryFunctions.inc.php" method="post">
                <div class="d-flex flex-column flex-column bd-highlight mx-3">
                    <div class="row">
                        <input type="hidden" name="id" value="' . $row["id"] . '">
                        <label for="product_name">Product Name</label>
                        <input class="form-control" type="text" name="product_name" value="' . $row['product_name'] . '" required> &nbsp;&nbsp;
                    </div>
                    <div class="row">
                        <label for="quantity">Quantity</label>
                        <input class="form-control" type="number" name="quantity" value="' . $row['quantity'] . '" required>&nbsp;&nbsp;
                    </div>
                    <div class="row">
                        <label for="price">Price</label>
                        <input class="form-control" type="number" step="0.01" name="price" value="' . $row['price'] . '" required>&nbsp;&nbsp;
                    </div>
                    <button class="btn btn-primary" style="border-radius: 17px;" type="submit" name="update">Update</button>
                </div>
            </form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '<div class="modal"></div>'; // DON'T REMOVE THIS LINE PLEASE
            }
            } else {
                echo "<p>No items match the filter criteria.</p>";
            }
            
    ?>
    </table>
     <!-- Pagination -->
     <ul class="pagination">
			<?php
			// Calculate the total number of pages
			$sql_count = "SELECT COUNT(*) AS total FROM inventory;";
			$result_count = mysqli_query($conn, $sql_count);
			if (!$result_count) {
				die("Error: " . mysqli_error($conn)); 
			}    

			$row_count = mysqli_fetch_assoc($result_count);
			$total_pages = ceil($row_count['total'] / $results_per_page);

			// Display pagination links
			for ($i = 1; $i <= $total_pages; $i++) {
			echo "<li class='page-item" . ($i == $current_page ? ' active' : '') . "'>";
			echo "<a class='page-link' href='?page=$i'>$i</a>";
			echo "</li>";
			}
			mysqli_close($conn);
			?>
		</ul>
    </div>
    <?php
    // ob_end_flush();
include_once 'footer.php';
?>