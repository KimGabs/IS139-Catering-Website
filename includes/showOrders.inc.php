<?php
	function displayOrders(){
		require_once '../../includes/database.inc.php';
		require_once '../../includes/functions.inc.php';


			$results_per_page = 12; // Number of messages to display per page
			$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
			$start_index = ($current_page - 1) * $results_per_page;
			// query to select all columns from orders and order_items table
			$query = "SELECT * FROM orders ORDER BY orderDate DESC LIMIT $start_index, $results_per_page";
			$result = mysqli_query($conn, $query);

			// Check if any rows were returned
			if (mysqli_num_rows($result) > 0) {
				echo "<form id='orderStatus' action='../../includes/updateStatus.inc.php' method='post'></form>";
				// Loop through rows and print data in table cells
				while ($row = mysqli_fetch_assoc($result)) {	
					echo '<form id="editOrderForm-'. $row['orderId'] .'" action="../../includes/editOrder.inc.php" method="post"></form>';
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
							<td style='vertical-align: middle;'><button type='button' data-toggle='collapse' data-target='#order-info-" . $row["orderId"] . "' class='btn btn-others btn-xs btn-collapse'>Collapse</button></td>
							<td style='vertical-align: middle;text-align: center;'>" . $row["orderId"] . "</td>
							<td style='vertical-align: middle;'>" . $row["cxName"] . "</td>
							<td style='vertical-align: middle;'>" . $row["eventDate"] . "</td>
							<td style='vertical-align: middle;'>". $formattedTime . "</td>
							<td style='vertical-align: middle;'>₱". number_format($totalP, 2, '.', ',') . "</td>";
							echo "<td style='vertical-align: middle;'>";
							// START OF FORM
							echo "<select form='orderStatus' class='status' name='changeOrderStatus[]' onchange='updateOrderStatus()'>";
							if ($row['orderStatus'] == 'pending'){
								echo "<option value='pending' selected='selected'>Pending</option>";
							}else{echo "<option value='pending'>Pending</option>";}
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
							echo "<input type='hidden' form='orderStatus' name='orderId[]' value=" . $row["orderId"] . ">";

							// END OF FORM
							echo "</td>";
							echo "<td><button type='button' class='btn btn-secondary status' data-toggle='modal' data-target='#myModal" . $row["orderId"] . "'>View Details</button></td>";
							echo "<td><button type='button' class='btn btn-others status' data-toggle='modal' data-target='#editOrder-" . $row["orderId"] . "'>Edit Order</button></td>";
							echo "</tr>
								<tr>
									<td colspan='12' class='hiddenRow' style='background: transparent; padding: 0px;'>
									<div class='accordion-body collapse' id='order-info-" . $row["orderId"] . "'> 
									<table class='table table-striped table-hover'>
									<thead>
										<tr class='info mb-2'>
											<th style='text-align: center;'>Order Date</th>
											<th>Contact Number</th>	
											<th>Event Location</th>	
											<th>Request</th>
										</tr>
									</thead>	
							<tbody>	
								<tr data-toggle='collapse'  class='accordion-toggle'>
									<td class='col-md-2' style='text-align: center;'>" . $date . "</td>
									<td class='col-md-2' style='text-transform: capitalize;'>". $row['contactNo'] . "</td>	
									<td class='col-md-3'>". $row['eventLocation'] . "</td>
									<td class='col-md-5' style='word-wrap: break-word;min-width: 160px;max-width: 160px;line-height: 1.3em;'>" . ucfirst($row['request']) . "</td> 
									
								</tr>
                      		</tbody>
              			</table>
                		</div> 
          				</td>
        				</tr>";

					// Modal for view package details
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
							
							$rows .= "<div class='row pkg-row'><div class='col-2 modal-td' style='text-align:center;'>" . $row2["pkgId"] . "</div><div class='col-1 modal-td'>" . $riceStmt . "</div>
							<div class='col-3 modal-td'>" . $row2["prodName"] . "</div><div class='col-1 modal-td'>" . $row2["pax"] . "</div>
							<div class='col-2 modal-td'>₱" . number_format($totallProdPrice, 2, '.', ',') . "</div>
							<div class='col-2 modal-td'>₱" . number_format($row2['pkgTotal'], 2, '.', ',') . "</div></div>";
						}
					} else {
						$rows .= "<tr><td colspan='3'>No items found.</td></tr>";
					}
					// Generate modal HTML
					$table = "<div>
					<div class='row' style='margin-bottom:5px;'>
							<div class='col-2 modal-th' style='font-weight:bold;text-align:center;'>Package ID</div>
							<div class='col-1 modal-th' style='font-weight:bold;padding-left: 11px !important;'>Rice</div>
							<div class='col-3 modal-th' style='font-weight:bold;'>Product Name</div>
							<div class='col-1 modal-th' style='font-weight:bold;'>PAX</div>
							<div class='col-2 modal-th' style='font-weight:bold;margin-right: -10px;'>Price</div>
							<div class='col-2 modal-th' style='font-weight:bold;'>Package Price</div>
					</div>
						$rows
					</div>";
					$modal = '<div class="modal fade" id="myModal' . $row["orderId"] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog" style="min-width: 1100px!important;">
							<div class="modal-content">
								<div class="modal-header">
									<h3 class="modal-title" id="myModalLabel" style="margin: 0">Order Details</h3>
									<button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true" style="border: none;background-color: transparent;">×</button>
								</div>
								<div class="modal-body" style="padding-bottom:0px;">
									' . $table . '
								</div>
								<div class="modal-footer">
									<button type="button" class="btn col-12" data-dismiss="modal" style="color: white; background-color: #212529">Close</button>
								</div>
							</div>
						</div>
					</div>';

					$rows_edit = "";
					$rows_edit .= "
					<div class='d-flex justify-content-start flex-column'>
					<div class='row'>
						<div class='col-12'>
							<label style='margin-bottom: 0.2rem;'>Customer Name </label>
						</div>
						<div class='col-12 form-group'>
							<input form='editOrderForm-". $row['orderId'] ."' class='form-control code' name='cxName' value='" . $row["cxName"] . "' type='text' style='margin-bottom:4px; width: 100%;padding: 4px 6px;'></input>
						</div>
					</div>
					<div class='row'>
						<div class='col-12 form-group'>
							<label style='margin-bottom: 0.2rem;'>Event Date </label>
							<input form='editOrderForm-". $row['orderId'] ."' class='form-control code' name='eventDate' value='" . $row["eventDate"] . "' type='text' style='margin-bottom:width: 100%;4px;padding: 4px 6px;'></input>
						</div>
					</div>
					<div class='row'>
						<div class='col-12 form-group'>
							<label style='margin-bottom: 0.2rem;'>Event Time </label>
							<input form='editOrderForm-". $row['orderId'] ."' class='form-control code' name='eventTime' value='" . $formattedTime . "' type='text' style='margin-bottom:4px; padding: 4px 6px;'></input>
						</div>
					</div>
					<div class='row'>
						<div class='col-12 form-group'>
							<label style='margin-bottom: 0.2rem;'>Contact Number </label>
							<input form='editOrderForm-". $row['orderId'] ."' class='form-control code' name='contactNo' value='" . $row["contactNo"] . "' type='text' style='margin-bottom:4px;padding: 4px 6px;'></input>
						</div>
					</div>
					<div class='row'>
						<div class='col-12 form-group'>
							<label style='margin-bottom: 0.2rem;'>Event Location </label>
							<textarea form='editOrderForm-". $row['orderId'] ."' class='form-control' name='eventLocation' style='resize: none;' rows='3' required>". $row["eventLocation"] . "</textarea>
						</div>
					</div>
					<div class='row'>
						<div class='col-12 form-group'>
							<label style='margin-bottom: 0.2rem;'>Special Request </label>
							<textarea form='editOrderForm-". $row['orderId'] ."' class='form-control' name='request' rows='3' style='resize: none;' required>". $row["request"] . "</textarea>
						</div>
					</div>
						<input form='editOrderForm-". $row['orderId'] ."' type='hidden' name='orderId' value='" . $row["orderId"] . "'></input>
						<input form='editOrderForm-". $row['orderId'] ."' type='hidden' name='editOrder'></input>
					</div>";
					
					
					// Generate Edit Order Modal HTML
					$table_edit = $rows_edit;
				

					$modal_edit = '
					<div class="modal fade" id="editOrder-' . $row["orderId"] . '" tabindex="-1" role="dialog" aria-labelledby="editOrderLabel" aria-hidden="true">
						<div class="modal-dialog" style="min-width: 480px!important;">
							<div class="modal-content">
								<div class="modal-header">
									<h3 class="modal-title" id="myModalLabel" style="margin: 0">Edit order information</h3>
									<button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true" style="border: none;background-color: transparent;">×</button>
								</div>
								<div class="modal-body" style="padding-bottom: 0;">
									' . $table_edit . '
								</div>
								<div class="modal-footer">
								<button type="button" onclick="submitEditOrder(' . (int)$row["orderId"] . ')" class="btn col-12" style="color: white; background-color: #0D98BA">Submit Edit</button>
									<button type="button" class="btn col-12" data-dismiss="modal" style="color: white; background-color: #6c757d">Cancel</button>
								</div>
							</div>
						</div>
						</div>';
						
						
						
						
						
				// Output modal HTML
				echo $modal;
				echo $modal_edit;
					echo "<tr class='spacer'>";
					echo "<td colspan='100'></td>";
					echo "</tr>";
				}
			} else {
				// If no rows were returned, print message
				echo "<p style='text-align: center;font-weight:bold;'>No orders for now...<p>";
			}

			// close database connection
			// mysqli_close($conn);
			return array($results_per_page, $current_page, $conn);
	}	
