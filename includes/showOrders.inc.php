<?php


	function displayOrders(){
		require_once '../../includes/database.inc.php';
		require_once '../../includes/functions.inc.php';


			$results_per_page = 7; // Number of messages to display per page
			$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
			$start_index = ($current_page - 1) * $results_per_page;
			// query to select all columns from orders and order_items table
			$query = "SELECT * FROM orders ORDER BY orderDate DESC LIMIT $start_index, $results_per_page";
			$result = mysqli_query($conn, $query);

			// Check if any rows were returned
			if (mysqli_num_rows($result) > 0) {
				echo "<form id='orderStatus' action='../../includes/manageOrder.inc.php' method='post'>";
				
				// Loop through rows and print data in table cells
				while ($row = mysqli_fetch_assoc($result)) {	
					// Trim date
					$orderDate = $row['orderDate'];
					$date = explode(" ", $orderDate);
					unset($date[1]);
					$date = implode(" ", $date);
					$totalP = $row['totalPrice'];
					$dateTime = DateTime::createFromFormat('H:i', $row['eventTime']);
					$formattedTime = $dateTime->format('g:i A');


					echo "
						<tbody>	
						<tr class='accordion-toggle'>
							<td><button type='button' data-toggle='collapse' data-target='#order-info-" . $row["orderId"] . "' class='btn btn-others btn-xs'>Collapse</button></td>
							<td style='vertical-align: middle;text-align: center;'>" . $row["orderId"] . "</td>
							<td style='vertical-align: middle;'>" . $row["cxName"] . "</td>
							<td style='vertical-align: middle;'>" . $row["eventDate"] . "</td>
							<td style='vertical-align: middle;'>". $formattedTime . "</td>
							<td style='vertical-align: middle;'>₱". number_format($totalP, 2, '.', ',') . "</td>";
							echo "<td style='vertical-align: middle;'>";
							// START OF FORM
							echo "<select class='status' name='changeOrderStatus[]' onchange='updateOrderStatus()'>";
							if ($row['orderStatus'] == 'processing'){
								echo "<option value='processing' selected='selected'>Processing</option>";
							}else{echo "<option value='processing'>Processing</option>";}
							if ($row['orderStatus'] == 'ongoing'){
								echo "<option value='ongoing' selected='selected'>Ongoing</option>";
							}else{echo "<option value='ongoing'>Ongoing</option>";}
							if ($row['orderStatus'] == 'completed'){
								echo "<option value='completed' selected='selected'>Completed</option>";
							}else{echo "<option value='completed'>Completed</option>";}
							if ($row['orderStatus'] == 'cancelled'){
								echo "<option value='cancelled' selected='selected'>Cancelled</option>";
							}else{echo "<option value='cancelled'>Cancelled</option>";}
							echo "</select>";
							echo "<input type='hidden' name='orderId[]' value=" . $row["orderId"] . ">";

							// END OF FORM
							echo "</td>";
							echo "<td><button type='button' class='btn-secondary status' data-toggle='modal' data-target='#myModal" . $row["orderId"] . "'>View Details</button></td>";
							echo "</tr>
								<tr>
									<td colspan='12' class='hiddenRow' style='background: transparent; padding: 5px 0px;'>
									<div class='accordion-body collapse' id='order-info-" . $row["orderId"] . "'> 
									<table class='table table-striped table-hover'>
									<thead>
										<tr class='info mb-2'>
											<th style='text-align: center;'>Order Date</th>
											<th>Contact Number</th>	
											<th>Location of Event</th>	
											<th>Request</th>
										</tr>
									</thead>	
							<tbody>	
								<tr data-toggle='collapse'  class='accordion-toggle'>
									<td class='col-md-2' style='text-align: center;'>" . $date . "</td>
									<td class='col-md-2' style='text-transform: capitalize;'>". $row['contactNo'] . "</td>	
									<td class='col-md-3'>". $row['eventLocation'] . "</td>
									<td class='col-md-5' style='word-wrap: break-word;min-width: 160px;max-width: 160px;line-height: 1.3em;'>" . $row['request'] . "</td> 
									
								</tr>
                      		</tbody>
              			</table>
                		</div> 
          				</td>
        				</tr>";

					// MODAL 
					$orderId = $row["orderId"];
					$sql2 = "SELECT oi.*, p.* 
							FROM order_items oi 
							INNER JOIN products p ON oi.prodId = p.prodId 
							WHERE oi.orderId = $orderId;";
					$result2 = mysqli_query($conn, $sql2);
					$rows = "";
					if (mysqli_num_rows($result2) > 0) {
						while($row2 = mysqli_fetch_assoc($result2)) {
							$totallProdPrice = ($row2["prodPrice"] * $row2["pax"]);
							if($row2["rice"] == "on"){
								$riceStmt = "Yes";
							}else{$riceStmt = "No";}
							
							$rows .= "<div class='row'><div class='col-2' style='text-align:center;'>" . $row2["pkgId"] . "</div><div class='col-1'>" . $riceStmt . "</div>
							<div class='col-3'>" . $row2["prodName"] . "</div><div class='col-1'>" . $row2["pax"] . "</div>
							<div class='col-2'>₱" . number_format($totallProdPrice, 2, '.', ',') . "</div>
							<div class='col-2'>₱" . number_format($row2['pkgTotal'], 2, '.', ',') . "</div></div>";
						}
					} else {
						$rows .= "<tr><td colspan='3'>No items found.</td></tr>";
					}
					// Generate modal HTML
					$table = "<div>
					<div class='row'>
							<div class='col-2' style='font-weight:bold;text-align:center;'>Package ID</div>
							<div class='col-1' style='font-weight:bold;'>Rice</div>
							<div class='col-3' style='font-weight:bold;'>Product Name</div>
							<div class='col-1' style='font-weight:bold;'>PAX</div>
							<div class='col-2' style='font-weight:bold;'>Price</div>
							<div class='col-2' style='font-weight:bold;'>Package Price</div>
					</div>
						$rows
					</div>";
					$modal = '<div class="modal fade" id="myModal' . $row["orderId"] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog" style="min-width: 1100px!important;">
							<div class="modal-content">
								<div class="modal-header">
									<h3 class="modal-title" id="myModalLabel" style="margin: 0">Order Items</h3>
									<button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true" style="border: none;background-color: transparent;">×</button>
								</div>
								<div class="modal-body">
									' . $table . '
								</div>
								<div class="modal-footer">
									<button type="button" class="btn col-12" data-dismiss="modal" style="color: white; background-color: #212529">Close</button>
								</div>
							</div>
						</div>
					</div>';

					// Output modal HTML
					echo $modal;
					echo "<tr class='spacer'>";
					echo "<td colspan='100'></td>";
					echo "</tr>";
				}
				echo "</form>";
			} else {
				// If no rows were returned, print message
				echo "<p style='text-align: center;font-weight:bold;'>No orders for now...<p>";
			}

			// close database connection
			// mysqli_close($conn);
			return array($results_per_page, $current_page, $conn);
	}	

// for myOrders.php
function displayMyOrders($userid){
	require_once '../../includes/database.inc.php';
	require_once '../../includes/functions.inc.php';
	
	// query to select all columns from orders and order_items table
	$query = "SELECT o.orderId, o.orderDate, o.shippingAddress, o.postal, o.city, o.contactNo, u.usersID, u.usersName,
	o.deliveryMethod, o.payment_method, o.deliveryFee, o.totalPrice, o.orderStatus,
	p.prodName, p.prodImage, SUM(oi.quantity) AS total_quantity
	FROM orders o 
	JOIN users u ON o.usersId = u.usersID 
	JOIN order_items oi ON o.orderId = oi.orderId
	JOIN products p ON oi.prodId = p.prodId
	WHERE u.usersID = $userid 
	GROUP BY o.orderId
	ORDER BY o.orderId ASC";

	$result = mysqli_query($conn, $query);

	// Check if any rows were returned
	if (mysqli_num_rows($result) > 0) {
		// Loop through rows and print data in table cells
		while ($row = mysqli_fetch_assoc($result)) {
			
			// Trim date
			$orderDate = $row['orderDate'];
			$date = explode(" ", $orderDate);
			unset($date[1]);
			$date = implode(" ", $date);
			$formatted_date = date('m/d/Y', strtotime("$date +7 day"));
			// Get Total Price + Delivery Fee
			$totalOrder = $row['totalPrice'] + $row['deliveryFee'];


			echo "<div class='col'>
		<div class='course'>
			  <div class='course-preview'>
				  <img src='" . $row['prodImage'] . "' alt='prodImage-" . $row["orderId"] . "'></img>
			  </div>
			  <div class='course-info'>
				  <div class='progress-container'>
				  	  <input type='hidden' id='progressStatus' value='". $row['orderStatus'] ."'></input>
					  <div class='progress' id='progress-bar-". $row['orderId'] ."' data-progress-stat='". $row['orderStatus'] ."'></div>
					  <span class='progress-text'>
					  ETA: $formatted_date <br>" . $row["total_quantity"] . " items
					  </span>
				  </div>";
				  
					switch ($row['orderStatus']) {
						case 'processing':
							echo '<h6 value="processing">processing</h6>';
							break;
						case 'completed':
							echo '<h6 value="completed" style="color:#16be16;">completed</h6>';
							break;
						case 'cancelled':
							echo '<h6 value="cancelled" style="color:#c1c1c1">cancelled</h6>';
							break;
					}
				echo "<h2>Order ID: " . $row["orderId"] ."</h2>
					<h5>Order Total: <span style='color: #fa5d94;'>₱$totalOrder</span></h5>
					<button class='btn' data-toggle='modal' data-target='#myOrderModal-" . $row["orderId"] . "'>View More</button>
						</div>
					</div>
					</div>";

			// MODAL
			$orderId = $row["orderId"];
			$sql2 = "SELECT oi.*, p.prodName, p.prodImage
					FROM order_items oi 
					INNER JOIN products p ON oi.prodId = p.prodId 
					WHERE oi.orderId = $orderId;";
			$result2 = mysqli_query($conn, $sql2);
			$rows = "";
			if (mysqli_num_rows($result2) > 0) {
				while($row2 = mysqli_fetch_assoc($result2)) {
					$rows .= "<div class='row prod-row align-items-center pb-2 mb-2'><div class='col prod-image'><img src='" . $row2['prodImage'] . "' alt='prodImage-" . $row["orderId"] . "
					'></img></div><div class='col'>" . $row2["prodName"] . "</div><div class='col'>Qty: " . $row2["quantity"] . "</div><div class='col'>Price: ₱" . $row2["price"] . "</div></div>";
				}
			} else {
				$rows .= "<tr><td colspan='3'>No items found.</td></tr>";
			}
			// Generate modal HTML
			
			$orderTime = date("m/d/Y H:i", strtotime("$orderDate"));
			$paymentTime = date("m/d/Y", strtotime("$orderDate +7 day"));
			$table = "
			<div class='col-12'>
				$rows
				<div class='row'>
					<div class='col-6' style='border-right: 1px solid #ddd'>
						<h2 class='modal-test-h'>Shipping Information</h2> 
						<label style='text-transform:capitalize;'>" . $row['deliveryMethod'] . " Delivery</label>
						<p>Delivery Fee: ₱" . $row['deliveryFee'] . "</p>
					</div>
					<div class='col-6'>
						<h2 class='modal-test-h'>Payment Method</h2> 
						<label style='text-transform:capitalize;'>" . $row['payment_method'] . "</label>
						<p>Order Time: $orderTime<span class='d-block'>Estimated Payment Date: $paymentTime</span></p>
					</div>
				</div>
				<hr>
				<div class='row'>
					<h2 class='modal-test-h'>Contact information</h2>
					<label style='text-transform:capitalize;'>Recipient: " . $row['usersName'] . "</label>
					<label style='text-transform:capitalize;'>Contact #: " . $row['contactNo'] . "</label>
					<p style='margin:0;'>Address: " . $row['shippingAddress'] . ", " . $row['city'] . ", " . $row['postal'] . "</p>
				</div>
			</div>
			";
			
			$modal = '<div class="modal fade myOrder" id="myOrderModal-' . $row["orderId"] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" style="min-width: 640px!important;">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title" id="myModalLabel" style="margin: 0;line-height:0;">Order Details</h3>
						<button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						' . $table . '
						
					</div>
					<div class="modal-footer" style="display:block;">
						<div class="row">
							<div class="col-6">
								<form action="" method="post">
									<button type="button" class="btn btn-secondary cancel">Cancel Order</button>
								</form>
							</div>
							<div class="col-6">
								<button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>';

			// Output modal HTML
			echo $modal;
			echo "<tr class='spacer'>";
			echo "<td colspan='100'></td>";
			echo "</tr>";

		}

		// Print HTML table footer
		// echo "</table>";
	} else {
		// If no rows were returned, print message
		echo "<div class='col-12' style='text-align:center;'><p>No orders for now...<p></div>";
	}

	// close database connection
	mysqli_close($conn);
	return;
}

	