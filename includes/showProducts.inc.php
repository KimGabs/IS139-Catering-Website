<?php


	function displayProducts(){
		require_once '../../includes/database.inc.php';
		require_once '../../includes/functions.inc.php';


			$results_per_page = 8; // Number of messages to display per page
			$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
			$start_index = ($current_page - 1) * $results_per_page;
			// query to select all columns from orders and order_items table
			$query = "SELECT * FROM products ORDER BY prodId ASC LIMIT $start_index, $results_per_page";
			$result = mysqli_query($conn, $query);

			// Check if any rows were returned
			if (mysqli_num_rows($result) > 0) {
				echo "<form id='prodStatus' action='../../includes/updateStatus.inc.php' method='post'></form>";
				// Loop through rows and print data in table cells
				while ($row = mysqli_fetch_assoc($result)) {	
					echo '<form id="editProdForm-'. $row['prodId'] .'" action="../../includes/editProduct.inc.php" method="post" enctype="multipart/form-data"></form>';
					// Trim date
					$prodPrice = $row['prodPrice'];
					list($monthCA, $dayCA, $yearCA, $timeCA) = formatTimestamp($row['prodCreated_at']);
					list($monthUA, $dayUA, $yearUA, $timeUA) = formatTimestamp($row['prodUpdated_at']);


					echo "
						<tbody>	
						<tr class='accordion-toggle'>
							<td style='vertical-align: middle;'><button type='button' data-toggle='collapse' data-target='#product-info-" . $row["prodId"] . "' class='btn btn-others btn-xs'>Collapse</button></td>
							<td style='vertical-align: middle; text-align: center;'>
								<img class='prod-mgmnt-img' src='" .$row['prodImage'] . "' alt='Product img'>
							</td>
							<td style='vertical-align: middle;'>" . ucfirst($row["prodName"]) . "</td>
							<td style='vertical-align: middle;'>" . ucfirst($row["prodCat"]) . "</td>
							<td style='vertical-align: middle;'>₱". number_format($prodPrice, 2, '.', ',') . "</td>";
							echo "<td style='vertical-align: middle;'>";
							// START OF FORM
							iconStatusCheck($row['prodStatus']);
							echo "<select form='prodStatus' class='status' name='changeProdStatus[]' onchange='updateProdStatus()'>";
							if ($row['prodStatus'] == 'draft'){
								echo "<option value='draft' selected='selected'>Draft</option>";
							}else{echo "<option value='draft'>Draft</option>";}
							if ($row['prodStatus'] == 'active'){
								echo "<option value='active' selected='selected'>Active</option>";
							}else{echo "<option value='active'>Active</option>";}
							if ($row['prodStatus'] == 'archived'){
								echo "<option value='archived' selected='selected'>Archived</option>";
							}else{echo "<option value='archived'>Archived</option>";}
							echo "</select>";
							echo "<input type='hidden' form='prodStatus' name='prodId[]' value=" . $row["prodId"] . ">";

							// END OF FORM
							echo "</td>";
							echo "<td style='vertical-align: middle;'><button type='button' class='btn btn-others status' data-toggle='modal' data-target='#editProduct-" . $row["prodId"] . "' data-backdrop='static' data-keyboard='false'>Edit Product</button></td>";
							echo "</tr>
								<tr>
									<td colspan='12' class='hiddenRow' style='background: transparent; padding: 0px;'>
									<div class='accordion-body collapse' id='product-info-" . $row["prodId"] . "'> 
									<table class='table table-striped table-hover'>
									<thead>
										<tr class='info mb-2'>
											<th>Created at</th>
											<th>Updated at</th>	
											<th>Description</th>	
										</tr>
									</thead>	
							<tbody>	
								<tr data-toggle='collapse'  class='accordion-toggle'>
								<td class='col-md-3'>". $monthCA . "-" . $dayCA . "-" . $yearCA . " at " . $timeCA ."</td>	
									<td class='col-md-3'>". $monthUA . "-" . $dayUA . "-" . $yearUA . " at " . $timeUA ."</td>	
									<td class='col-md-5' style='word-wrap: break-word;min-width: 160px;max-width: 160px;line-height: 1.5em;'>" . $row['prodDesc'] . "</td> 
									
								</tr>
                      		</tbody>
              			</table>
                		</div> 
          				</td>
        				</tr>";

					$rows_edit = "";
					$rows_edit .= "
					<div class='d-flex justify-content-start row'>
					<div class='col-5 d-flex align-items-center' style='margin-left: 15px;'>
					<div class='row'>
					<label style='margin-bottom: 0.8rem;text-align: center;'>Change Product Image</label>
						<div class='col-12' style='text-align:center;'>
							<img class='preview-" . $row['prodId'] . " edit-modal-img' src='" . $row['prodImage'] . "' alt='prodImage'/>
							<input form='editProdForm-". $row['prodId'] ."' class='edit-input-img edit-img-" . $row['prodId'] . "' accept='image/*' type='file' id='image-" . $row['prodId'] . "' name='image-". $row['prodId'] ."' data-prod-id='" . $row['prodId'] . "'>
						</div>
					</div>
					</div>
					<div class='col-6'>
					<div class='row'>
						<div class='col-12'>
							<label style='margin-bottom: 0.2rem;'>Product Name: </label>
						</div>
						<div class='col-12 form-group'>
							<input form='editProdForm-". $row['prodId'] ."' class='form-control code' name='prodName' value='" . $row["prodName"] . "' type='text' style='margin-bottom:4px; width: 100%;padding: 4px 6px;'></input>
						</div>
					</div>
					<div class='row'>
						<div class='col-12'>
							<label style='margin-bottom: 0.2rem;'>Category: </label>
						</div>
						<div class='col-12 form-group'>
							<input form='editProdForm-". $row['prodId'] ."' class='form-control code' name='prodCat' value='" . ucfirst($row["prodCat"]) . "' type='text' style='margin-bottom:4px; width: 100%;padding: 4px 6px;'></input>
						</div>
					</div>
					<div class='row'>
						<div class='col-12'>
							<label style='margin-bottom: 0.2rem;'>Price</label>
						</div>
						<div class='col-12 form-group'>
							<input form='editProdForm-". $row['prodId'] ."' class='form-control code' name='prodPrice' value='" . $row["prodPrice"] . "' type='text' style='margin-bottom:4px; width: 100%;padding: 4px 6px;'></input>
						</div>
					</div>
					<div class='row'>
						<div class='col-12 form-group'>
							<label style='margin-bottom: 0.2rem;'>Description </label>
							<textarea form='editProdForm-". $row['prodId'] ."' class='form-control' name='prodDesc' style='resize: none;' rows='3' required>". $row["prodDesc"] . "</textarea>
						</div>
					</div>
					</div>
					<input form='editProdForm-". $row['prodId'] ."' type='hidden' name='prodId' value='" . $row["prodId"] . "'></input>
						<input form='editProdForm-". $row['prodId'] ."' type='hidden' name='editProduct'></input>
						</div>";
					
					
					// Generate Edit Product Modal HTML
					$table_edit = $rows_edit;
				

					$modal_edit = '
					<div class="modal fade" id="editProduct-' . $row["prodId"] . '" tabindex="-1" role="dialog" aria-labelledby="editProductLabel" aria-hidden="true" data-bs-backdrop="static">
						<div class="modal-dialog" style="min-width: 880px!important;">
							<div class="modal-content">
								<div class="modal-header">
									<h3 class="modal-title" id="myModalLabel" style="margin: 0">Edit order information</h3>
									<button type="button" class="close-modal" data-dismiss="modal" aria-hidden="true" style="border: none;background-color: transparent;">×</button>
								</div>
								<div class="modal-body" style="padding-bottom: 0;">
									' . $table_edit . '
								</div>
								<div class="modal-footer">
								<button type="button" onclick="submitEditProduct(' . (int)$row["prodId"] . ')" class="btn col-12" style="color: white; background-color: #0D98BA">Submit Edit</button>
									<button type="button" id="reset-button' . $row['prodId'] . '" data-dismiss="modal" class="btn col-12 cancel-btn-' . $row['prodId'] . '" style="color: white; background-color: #6c757d">Cancel</button>
								</div>
							</div>
						</div>
						</div>';
						
						
						
						
						
				// // Output modal HTML
				// echo $modal;
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


function iconStatusCheck($status){
	if ($status == 'draft'){
		echo "<i class='bi bi-circle-fill icon-status' style='color: #fad346'></i>";
	}
	if ($status == 'active'){
		echo "<i class='bi bi-circle-fill icon-status' style='color: #5cb85c'></i>";
	}
	if ($status == 'archived'){
		echo "<i class='bi bi-circle-fill icon-status' style='color: #d0d1cf'></i>";
	}	
}