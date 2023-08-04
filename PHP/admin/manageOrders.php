<?php
	include_once 'header.php';
	include_once '../../includes/showOrders.inc.php';
	include_once '../../includes/adminSidePanel.inc.php';
?>
	<div class="col py-3" style="background-color: white;">
		<h1>Manage Orders</h1>
		<div class="container p-0 mb-5">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="table-responsive">
								<table class="table custom-table align-middle table-condensed">
									<thead>
										<tr>
											<th></th>
											<th style='text-align: center;'>Order No.</th>
											<th>Customer Name</th>
											<th>Event Date</th>
											<th>Event Time</th>			
											<th>Total</th>
											<th>Order Status</th>
										</tr>
									</thead>
									<tbody>	
										<?php
											list($results_per_page, $current_page, $conn) = displayOrders();
										?>
									</tbody>
								</table>
								<?php
									echo "<ul class='pagination'>";
									// Calculate the total number of pages
									$sql_count = "SELECT COUNT(*) AS total FROM orders;";
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
									echo "</ul>";
									mysqli_close($conn);
								?>
							</div>
						</div> 
					</div>
				</div>
			</div>
    	</div>
	</div>
<?php
	include_once 'footer.php';
?>
