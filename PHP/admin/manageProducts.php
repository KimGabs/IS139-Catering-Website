<?php
	include_once 'header.php';
	include_once '../../includes/showProducts.inc.php';
	include_once '../../includes/adminSidePanel.inc.php';
?>
	<div class="col py-3" style="background-color: white;">
		<h1>Manage Products</h1>
		<div class="container p-0 mb-5">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="table-responsive">
								<table class="table custom-table align-middle table-condensed">
									<thead>
										<tr>
											<th></th>
											<th style='text-align: center;'></th>
											<th>Product</th>
											<th>Category</th>
											<th>Price</th>	
                                            <th>Status</th>			
										</tr>
									</thead>
									<tbody>	
										<?php
											list($var1, $var2, $conn) = displayProducts();
										?>
									</tbody>
								</table>
								<?php
									echo "<ul class='pagination'>";
									// Calculate the total number of pages
									$sql_count = "SELECT COUNT(*) AS total FROM products;";
									$result_count = mysqli_query($conn, $sql_count);
									if (!$result_count) {
										die("Error: " . mysqli_error($conn)); 
									}    

									$row_count = mysqli_fetch_assoc($result_count);
									$total_pages = ceil($row_count['total'] / $var1);

									// Display pagination links
									for ($i = 1; $i <= $total_pages; $i++) {
									echo "<li class='page-item" . ($i == $var2 ? ' active' : '') . "'>";
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
