<?php
	include_once 'header.php';
	require_once '../../includes/database.inc.php';
?>
	<main>
	<div class="catalog-container">
		<div class="catalog-header d-flex flex-row bd-highlight align-items-center">
			<h1 class="p-2 bd-highlight mr-5">Menu</h1>
			<!-- <button type="submit" name="sortProd" class="p-2 bd-highlight option" value="1" style="margin-left: 50px;"> Sort by: Name </button> -->
			<div class="p-2 dropdown bd-highlight col-1">
				<form action="menu.php" method="get">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="sortMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top: 0px; border-radius:5px; font-weight:500;">
					Sort by: Asc
					</button>
					<div class="dropdown-menu" aria-labelledby="sortMenuButton" style="font-size: 20px;">
						<button type="submit" class="dropdown-item" name="sort" value="1">Name</button>
						<button type="submit" class="dropdown-item" name="sort" value="2">Price</button>
					</div>
				</form>
			</div>
			<div class="p-2 dropdown bd-highlight col-2" style="font-size: 20px;">
				<form action="menu.php" method="get">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="sortMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top: 0px; border-radius:5px; font-weight:500;">
					Sort by: Desc
					</button>
					<div class="dropdown-menu" aria-labelledby="sortMenuButton" style="font-size: 20px;">
						<button type="submit" class="dropdown-item" name="sort" value="3">Name</button>
						<button type="submit" class="dropdown-item" name="sort" value="4">Price</button>
					</div>
				</form>
			</div>
			<div class="p-2 dropdown bd-highlight col-md-4 col-sm-2" style="font-size: 20px;">
				<form action="menu.php" method="get">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="sortMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-top: 0px; border-radius:5px; font-weight:500;">
					Product Category
					</button>
					<div class="dropdown-menu" aria-labelledby="sortMenuButton" style="font-size: 20px;">
						<button type="submit" class="dropdown-item" name="category" value="">---</button>
					<?php
						// Retrieve product data from the database
						$sql = "SELECT DISTINCT prodCat FROM products";
						$result = mysqli_query($conn, $sql);
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<button type="submit" class="dropdown-item" name="category" value="' . $row['prodCat'] . '"> ' . ucfirst($row['prodCat']) . '</button>';
						}
					?>
					</div>
				</form>
			</div>
			<div class="p-2 bd-highlight col-0" style="font-size: 20px;">
			<?php
				$numElements = count($package);
				echo '<button type="button" class="btn pkg-btn" data-toggle="modal" data-target="#packageModal"> My Package ('. $numElements .')</button>';
			?>
			</div>
			<div class="p-2 bd-highlight col-1" style="font-size: 20px;">
				<button id="clearPackageBtn" type="button" class="btn btn-danger">Clear package</button>
			</div>
		</div>
		
    	<div class="row">
			<?php
				if(isset($_GET['sort'])){
					if($sortValue = $_GET['sort'] == 1){
						$sql = "SELECT * FROM products ORDER BY prodName ASC";
						$result = mysqli_query($conn, $sql);
					}
					if($sortValue = $_GET['sort'] == 2){
						$sql = "SELECT * FROM products ORDER BY prodPrice ASC";
						$result = mysqli_query($conn, $sql);
					}
					if($sortValue = $_GET['sort'] == 3){
						$sql = "SELECT * FROM products ORDER BY prodName DESC";
						$result = mysqli_query($conn, $sql);
					}
					if($sortValue = $_GET['sort'] == 4){
						$sql = "SELECT * FROM products ORDER BY prodPrice DESC";
						$result = mysqli_query($conn, $sql);
					}
				}
				else if(isset($_GET['category'])){
					if(($_GET['category']) == ""){
						$sql = "SELECT * FROM products";
						$result = mysqli_query($conn, $sql);
					}
					else{
						$category = $_GET['category'];
						$sql = "SELECT * FROM products WHERE prodCat='$category'";
						$result = mysqli_query($conn, $sql);
					}
				}
				else{
					// Retrieve product data from the database
					$sql = "SELECT * FROM products";
					$result = mysqli_query($conn, $sql);
				}
				// Generate Bootstrap cards for each product
				while ($row = mysqli_fetch_assoc($result)) {
					$flag = false;
					// echo '<p " ' . $package[''] . ' " />';
					foreach ($package as $p)
					{
						if ($p->prodId == $row["prodId"]){
							$flag = true;
							break;
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
					echo '<input type="hidden" name="quantity" value="1">';
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
					echo '<img src="' . $row["prodImage"] . '" class="img-fluid mb-2" style="max-height:250px;"' . $row["prodName"] . '">';
					echo '<p class="mb-2">₱' . $row["prodPrice"] . '</p>';
					echo '<p class="mb-4">' . $row["prodDesc"] . '</p>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
					echo '<div class="modal"></div>'; // Don't remove this line
				}
				// Generate modal for added to cart alert
					if(isset($_GET["addedToCart"])) {
						echo '<div class="modal fade" id="addToCartWindow" tabindex="-1" role="dialog" aria-labelledby="addToCartWindow" aria-hidden="false">';
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
							echo 'Added to cart successfully</div>';
						}
						else if ($_GET["addedToCart"] == "failed"){
							echo "<p>Add to Package failed!</p>";
						}
						echo '<div class="modal-footer-2">';
						echo '<button type="button" class="btn menu-btn" data-dismiss="modal" style="border-radius: 2px; background-color: #ddd;">';
						echo 'Close</button>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
					}
				
				// Generate modal for added to cart alert
				if(isset($_GET["addToWishlist"])) {
					echo '<div class="modal fade" id="addToCartWindow" tabindex="-1" role="dialog" aria-labelledby="addToCartWindow" aria-hidden="false">';
					echo '<div class="modal-dialog" role="document" style="margin: 11.75rem auto;">';
					echo '<div class="modal-content">';
					echo '<div class="modal-header" style="padding: 0 1rem">';
					echo '<h5 class="modal-title" id="modal-Title"></h5>';
					echo '<button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">';
					echo '<span aria-hidden="true">&times;</span>';
					echo '</button>';
					echo '</div>';
					echo '<div class="modal-body" style="text-align:center; margin: 5px 0 -15px; padding: 1rem 0; color: green;">';
					if ($_GET["addToWishlist"] == "success") {
						echo 'Added to wishlist successfully</div>';
					}
					else if ($_GET["addToWishlist"] == "failed"){
						echo "<p>Add to wishlist failed!</p>";
					}
					else if($_GET["addToWishlist"] == "wishExists"){
						echo "<p>Item already in wishlist!</p>";
					}
					echo '<div class="modal-footer-2">';
					echo '<button type="button" class="btn menu-btn" data-dismiss="modal" style="border-radius: 2px; background-color: #ddd;">';
					echo 'Close</button>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				}

				
				// Close the database connection
				mysqli_close($conn);
			?>
		</div>
	</div>	
	</main>
<?php
	include_once 'footer.php';
?>