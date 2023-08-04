<?php
	include_once 'header.php';
	require_once '../../includes/database.inc.php';
?>
	<main>
	<div class="catalog-container">
		<div class="catalog-header d-flex flex-row bd-highlight align-items-center">
			<h1 class="p-2 bd-highlight mr-5">Menu</h1>
			<div class="p-2 dropdown bd-highlight col-2">
			<form action="menu.php" method="get" id="sortDescForm">
					 <!-- Handles sorting option -->
					<select class="form-select form-select-sm" onchange="submitSortForm(this)">
					<?php
						// Pagination variables
						$results_per_page = 9; // Number of messages to display per page
						$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
						$start_index = ($current_page - 1) * $results_per_page;

						if(isset($_GET['sort'])){
							$sortValue = $_GET['sort'];
							if($sortValue == 1){
								echo "<option value='0'>Sort by: Ascending</option>";
								echo "<option selected name='sort' value='1'>Name</option>";
								echo "<option name='sort' value='2'>Price</option>";
							}
							elseif($sortValue == 2){
								echo "<option value='0'>Sort by: Ascending</option>";
								echo "<option name='sort' value='1'>Name</option>";
								echo "<option selected name='sort' value='2'>Price</option>";
							}
							else{
								echo "<option selected value='0'>Sort by: Ascending</option>";
								echo "<option name='sort' value='1'>Name</option>";
								echo "<option name='sort' value='2'>Price</option>";
							}
						}
						else{
							echo "<option selected value='0' selected>Sort by: Ascending</option>";
							echo "<option name='sort' value='1'>Name</option>";
							echo "<option name='sort' value='2'>Price</option>";
						}
						?>
					</select>
				</form>
			</div>
			<div class="p-2 dropdown bd-highlight col-2">
				<form action="menu.php" method="get" id="sortDescForm">
					<select class="form-select form-select-sm" onchange="submitSortForm(this)">
					<?php
						if(isset($_GET['sort'])){
							$sortValue = $_GET['sort'];
							if($sortValue == 3){
								echo "<option value='0'>Sort by: Descending</option>";
								echo "<option selected name='sort' value='3'>Name</option>";
								echo "<option name='sort' value='4'>Price</option>";
							}
							elseif($sortValue == 4){
								echo "<option value='0'>Sort by: Descending</option>";
								echo "<option name='sort' value='3'>Name</option>";
								echo "<option selected name='sort' value='4'>Price</option>";
							}
							else{
								echo "<option selected value='0'>Sort by: Descending</option>";
								echo "<option name='sort' value='3'>Name</option>";
								echo "<option name='sort' value='4'>Price</option>";
							}
						}
						else{
							echo "<option value='0' selected>Sort by: Descending</option>";
							echo "<option name='sort' value='3'>Name</option>";
							echo "<option name='sort' value='4'>Price</option>";
						}
						?>
					</select>
				</form>
			</div>
			<div class="p-2 dropdown bd-highlight col-md-2 col-sm-2 mr-5" style="font-size: 20px;">
				<form action="menu.php" method="get">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="sortMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top: 0px; border-radius:5px; font-weight:500;">
					<i class="bi bi-funnel" style="margin-right:5px;"></i>Product Category
					</button>
					<div class="dropdown-menu" aria-labelledby="sortMenuButton" style="font-size: 20px;">
						<button type="submit" class="dropdown-item" name="category" value="">------</button>
					<?php
						// Handles product category button
						$sql = "SELECT DISTINCT prodCat FROM products";
						$result = mysqli_query($conn, $sql);
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<button type="submit" class="dropdown-item" name="category" value="' . $row['prodCat'] . '"> ' . ucfirst($row['prodCat']) . '</button>';
						}
					?>
					</div>
				</form>
			</div>
			<div class="col-md-1 col-sm-0" style="font-size: 20px;margin-left:-80px;"></div>
			<div class="p-2 bd-highlight col-0" style="font-size: 20px;">
			<?php
			if($package == null){
				$package = [];
			}
			$numElements = count($package);
			echo '<button id="pkgbButton" type="button" class="btn pkg-btn" data-toggle="modal" data-target="#pkgModal"> My Package ('. $numElements .')</button>';
			
			?>
			</div>
			<div class="p-2 bd-highlight col-2" style="font-size: 20px;">
				<button id="clearPackageBtn" type="button" class="btn btn-danger">Clear package</button>
			</div>
		</div>
		
    	<div class="row">
			<?php
				// Handles the sorting process based on product category
				if (isset($_GET['sort']) && isset($_GET['category'])) {
					$sortValue = $_GET['sort'];
					$category = $_GET['category'];
					
					// Sort by prodName ASC
					if ($sortValue == 1) {
						$sql = "SELECT * FROM products WHERE prodCat='$category' AND prodStatus='active' ORDER BY prodName ASC LIMIT $start_index, $results_per_page";
					}
					// Sort by prodPrice ASC
					elseif ($sortValue == 2) {
						$sql = "SELECT * FROM products WHERE prodCat='$category' AND prodStatus='active' ORDER BY prodPrice ASC LIMIT $start_index, $results_per_page";
					}
					// Sort by prodName DESC
					elseif ($sortValue == 3) {
						$sql = "SELECT * FROM products WHERE prodCat='$category' AND prodStatus='active' ORDER BY prodName DESC LIMIT $start_index, $results_per_page";
					}
					// Sort by prodPrice DESC
					elseif ($sortValue == 4) {
						$sql = "SELECT * FROM products WHERE prodCat='$category' AND prodStatus='active' ORDER BY prodPrice DESC LIMIT $start_index, $results_per_page";
					}
					// No sort value specified, use category filter only
					else {
						$sql = "SELECT * FROM products WHERE prodCat='$category' AND prodStatus='active' LIMIT $start_index, $results_per_page";
					}
				}
				// Handles the sorting process based on product info
				else if (isset($_GET['sort'])){
					$sortValue = $_GET['sort'];
					if($sortValue == 1){
						$sql = "SELECT * FROM products ORDER BY prodName AND prodStatus='active' ASC LIMIT $start_index, $results_per_page";
					}
					elseif($sortValue == 2){
						$sql = "SELECT * FROM products ORDER BY prodPrice AND prodStatus='active' ASC LIMIT $start_index, $results_per_page";
					}
					elseif($sortValue == 3){
						$sql = "SELECT * FROM products ORDER BY prodName AND prodStatus='active' DESC LIMIT $start_index, $results_per_page";
					}
					elseif($sortValue == 4){
						$sql = "SELECT * FROM products ORDER BY prodPrice AND prodStatus='active' DESC LIMIT $start_index, $results_per_page";
					}
					else{
						// Retrieve product data from the database
						$sql = "SELECT * FROM products AND prodStatus='active' LIMIT $start_index, $results_per_page";
					}
				}
				// Retrieves all products based on category
				else if(isset($_GET['category'])){
					if(($_GET['category']) == ""){
						$sql = "SELECT * FROM products WHERE prodStatus='active' LIMIT $start_index, $results_per_page";
					}
					else{
						$category = $_GET['category'];
						$sql = "SELECT * FROM products WHERE prodCat='$category' AND prodStatus='active' LIMIT $start_index, $results_per_page";
					}
				}
				else{
					// Retrieve all products from the database without filter
					$sql = "SELECT * FROM products WHERE prodStatus='active' LIMIT $start_index, $results_per_page";
					$result = mysqli_query($conn, $sql);
				}

				
				// Execute and filter the retrieved result
				$result = mysqli_query($conn, $sql);
				// Generate Bootstrap cards for each product
				while ($row = mysqli_fetch_assoc($result)) {
					$flag = false;
					foreach ($package as $p)
					{
						if(isset($p->prodId)){
							if ($p->prodId == $row["prodId"]){
								$flag = true;
								break;
							}
						}
					};

					// check if product is available
					echo '<div class="col-p-sm-0 col-md-12 col-lg-6 col-xl-4 pb-4 card-prods">';
					echo '<div class="card card-horizontal h-100 d-flex align-items-center shadow-sm">';
					echo '<a href="" data-toggle="modal" data-target="#productModal' . $row["prodId"] . '"><img src="' . $row["prodImage"] . '" class="card-img-responsive" alt="' . $row["prodName"] . '"></a>';
					echo '<div class="card-body">';
					echo '<h5>' . $row["prodName"] . '</h5>';
					echo '<p class="card-text">₱' . $row["prodPrice"] . '</p>';
					echo '<form method="post" action="../../includes/addToPackage.inc.php">';
					echo '<input type="hidden" name="prodId" value="' . $row['prodId'] . '">';
					echo '<input id="locationElement" type="hidden" name="location" value="menu">';
					echo '<button type="button" class="menu-btn" data-toggle="modal" data-target="#productModal' . $row["prodId"] . '">View Details</button>';
					if ($flag){
						echo '<button type="submit" id="rf_package" name="rf_package" class="menu-btn">Remove from Package</button>';
					}else{
						echo '<button type="submit" id="add_to_package" name="add_to_package" class="menu-btn">Add to Package</button>';
					}
					echo '</form>';
					echo '</div>';
					echo '</div>';
					echo '</div>';

					// Generate modal for each product
					echo '<div class="modal fade in" id="productModal' . $row["prodId"] . '" tabindex="-1" role="dialog" aria-labelledby="productModal' . $row["prodId"] . 'Label" aria-hidden="true">';
					echo '<div class="modal-dialog modal-dialog-centered" role="document">';
					echo '<div class="modal-content">';
					echo '<div class="modal-header" style="padding-top: 0.5rem;">';
					echo '<h5 class="modal-title">' . $row["prodName"] . '<small class="text-muted d-flex" style="text-transform:capitalize;">Category: ' . $row["prodCat"] . '</small></h5>';
					echo '<button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">';
					echo '<span aria-hidden="true">&times;</span>';
					echo '</button>';
					echo '</div>';
					echo '<div class="modal-body">';
					echo '<img src="' . $row["prodImage"] . '" class="img-fluid mb-2" style="max-height:250px;border-radius:8px;"' . $row["prodName"] . '">';
					echo '<hr><p class="mb-2">₱' . $row["prodPrice"] . '</p>'; 
					echo '<p class="mb-4">' . $row["prodDesc"] . '</p>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
					echo '<div class="modal"></div>'; // Don't remove this line
				}
				// End of while loop

				// Generate modal for added to cart alert
					if(isset($_GET["addedToCart"])) {
						echo '<div class="modal fade" id="addToCartWindow" tabindex="-1" role="dialog" aria-labelledby="addToCartWindow" aria-hidden="False">';
						echo '<div class="modal-dialog" role="document" style="margin: 11.75rem auto;">';
						echo '<div class="modal-content">';
						echo '<div class="modal-header" style="padding: 0 1rem">';
						echo '<h5 class="modal-title" id="modal-Title"></h5>';
						echo '<button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">';
						echo '<span aria-hidden="true">&times;</span>';
						echo '</button>';
						echo '</div>';
						echo '<div class="modal-body" style="text-align:center; margin: 5px 0 -15px; color: green;">';
						if ($_GET["addedToCart"] == "success") {
							echo 'Package added to Cart successfully</div>';
							echo '<a href="cart.php" style="text-align:center;">Check my cart</a>';
						}
						else if ($_GET["addedToCart"] == "failed"){
							echo "<p>Add to Cart failed!</p>";
						}
						echo '<div class="modal-footer-2">';
						echo '<button type="button" class="btn menu-btn" data-dismiss="modal" style="border-radius: 2px; background-color: #ddd;">';
						echo 'Close</button>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
					}

				// Generate modal for package info
				echo '<div class="modal fade" id="pkgModal" tabindex="-1" role="dialog" aria-labelledby="package-Window" aria-hidden="true">';
				echo '<div class="modal-dialog pkg-modal-dialog" role="document" style="margin: 1.75rem auto;">';
				echo '<div class="modal-content">';
				echo '<div class="modal-header" style="padding: 10px 2rem; align-items: center;">';
				echo '<h5 class="modal-title" id="modal-Title">Package Summary</h5>';
				echo '<button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">';
				echo '<span aria-hidden="true">&times;</span>';
				echo '</button>';
				echo '</div>';
				echo '<div class="modal-body row" style="text-align:center; margin: 0px 0 -20px; padding: 0rem 0;">';
				echo '<div class="col-md-7 modal-body-left">';
				$package = isset($_COOKIE["package"]) ? $_COOKIE["package"] : "[]";
				$package = json_decode($package);
				$flag_empty = false;
				$phpSubtotal = 0.00;
				if (empty($package)) {
					$flag_empty = true;
					echo "<p style='padding-top:50px'>Package is empty...</p>";
				} else{
					$sql = "SELECT * FROM products";
					$result = mysqli_query($conn, $sql);
					$init = 0;
					while ($row = mysqli_fetch_assoc($result)) {
						foreach ($package as $p)
						{ 
							if(isset($p->prodId)){
								if ($p->prodId == $row["prodId"]){
									$init++;
									if($init != 1){
										echo '<hr class="hr-modal">';
									}
									echo '<form id="pkgForm" method="post" action="../../includes/addToPackage.inc.php">';
									echo '<div class="row pkg-mod">';
									echo '<div class="col-md-3 col-pkg-mod pkg-img"><img src="' . $row["prodImage"] . '" alt=""></div>';
									echo '<div class="col-md-4 col-pkg-mod align-self-center">' . $row["prodName"] . "</div>";
									echo '<div class="col-md-3 col-pkg-mod align-self-center">₱' . $row["prodPrice"] . "</div>";
									echo '<input id="prodIdElement" type="hidden" name="prodId" value="' . $row['prodId'] . '">';
									echo '<input id="locationElement" type="hidden" name="location" value="modal">';
									echo '<div class="col col-pkg-mod"><button class="rf-modal" type="submit" name="rf_package" onclick="submitRfForm()"><i class="bi bi-x-circle"></button></i></div>';
									echo '</div>';
									echo '</form>';
									$phpSubtotal += $row['prodPrice'];
									break;
								}
							}
						};
					}
				}

				echo '</div>';
				echo '<div class="col-md-5 modal-body-right">';
				echo '<form id="addToCartForm" class="pkg-form" action="../../includes/addToCart.inc.php" method="post"><p style="margin:10px 0 5px 0;text-align:start;font-weight:bold;">Others:</p>';
				echo '<div class="row pkg-row-mod">';
				echo '<div class="col d-flex align-items-center justify-content-start">';
				echo '<div class="checkbox">';
				echo '<input type="checkbox" name="rice" class="form-check-input rice-check" id="rice">'; //Checkbox - Rice
				echo '<label class="form-check-label" for="rice">Rice (Additional ₱10 per PAX)</label>';
				echo '</div></div></div>';
				echo '<div class="row pkg-row-mod">';
				echo '<div class="col d-flex align-items-center">';
				echo '<div class="pax">';
				echo '<label class="form-check-label" for="pax">PAX</label>';
				echo '<input type="number" class="pax-input" name="pax" id="pax" aria-describedby="paxinput" min="30" placeholder="0">'; //PAX input
				echo '<small class="form-text text-muted">Minimum of 30 PAX</small>';
				echo '<input id="locationElement" type="hidden" name="location" value="toCart">';
				echo '</div></div></div>';
				echo '<input type="hidden" id="phpSubtotal" value="' . $phpSubtotal . '">';
				echo '<input type="hidden" name="addPackage">';
				echo '<div class="row pkg-row-mod">';
				echo '<div class="col d-flex align-items-center">';
				echo '<div class="subinfo">';
				echo '<p>Rice: ₱<span id="ricePrice">0</span></p>';
				echo '<p>Total: <span id="subtotal"></span></p>';
				echo '</div>';
				echo '</div></div>';
				if(isset($_GET['error'])){
					$error = $_GET['error'];
					if($error == "emptyInput"){
						echo '<p style="color: #DC3545; margin: 5px 0 0;">Error: PAX input is empty...</p>';}
					if($error == "invalidpax"){
						echo '<p style="color: #DC3545; margin: 5px 0 0;">Error: PAX is invalid...</p>';}
				}
				echo '</form>';
				echo '</div>';
				echo '<div class="modal-footer-2 px-0">';
				// Add to cart button
				echo '<button id="addToCartBtn" name="addPackage" onclick="addToCart()" class="d-flex justify-content-center align-items-center btn btn-pkg-mod pkg-btn-success">';
				echo '<i class="bi bi-check-circle pkg-close-icon" style="margin-right:5px;"></i>';
				echo 'Add to Cart</button>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				
				// Close the database connection
				// mysqli_close($conn);
			?>
		</div>

		  <!-- Pagination -->
		  <ul class="pagination">
			<?php
			// Calculate the total number of pages
			$sql_count = "SELECT COUNT(*) AS total FROM products;";
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
	</form>
	</main>
<?php
	include_once 'footer.php';
?>