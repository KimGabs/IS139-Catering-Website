<?php
	session_start();
	//initialize cart if not set or is unset
	if (!isset($_COOKIE['package'])) {
		$package = array();
		echo "<script>console.log('Package cookie is not set...');</script>";
		setcookie('package', json_encode($package), time() + (86400 * 30), '/'); // Cookie expires in 30 days
	}
	else if(!isset($_COOKIE['cart'])){
		$cart = array();
		echo "<script>console.log('Cart cookie is not set...');</script>";
		setcookie('cart', json_encode($cart), time() + (86400 * 30), '/'); // Cookie expires in 30 days
	}
	else{
		$cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
		$cart = json_decode($cart);
		$package = isset($_COOKIE["package"]) ? $_COOKIE["package"] : "[]";
		$package = json_decode($package);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>CROMS Catering</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../css/login-form.css">
	<link rel="stylesheet" href="../../css/profile-dropdown.css">
	<link rel="stylesheet" href="../../css/addProduct.css">
	<link rel="stylesheet" href="../../css/cart.css">
	<link rel="stylesheet" href="../../css/menu.css">
</head>
<body>
<header>
<?php
    // if(!isset($_COOKIE['package'])) {
    //     echo "<p style='text-align: center; background-color: whitesmoke;'>Please turn on your cookies! Cart and package will not work without cookies...</p>";
    // }
?>
<nav class="navbar navbar-expand-md navbar-dark">
	<div class="container-fluid">
		<a class="navbar-brand d-md-none" href="#">
		<img src="../../img/logo-1.png" alt="">
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<!-- Cart icon -->
		
		<div class="collapse navbar-collapse" id="navbarNav">
			<div class="col-10 d-flex justify-content-center">
				<ul class="navbar-nav mx-auto">
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="../index.php">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="menu.php">Menu</a>
					</li>
					<a class="navbar-brand d-none d-md-block" href="../index.php">
						<img src="../../img/logo-1.png" alt="CROMS">
					</a>
					<li class="nav-item">
						<a class="nav-link" href="others/aboutUs.php">About us</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="others/contactUs.php">Contact us</a>
					</li>
					<li class="nav-item hidden-link">
						<a class="nav-link" href="cart.php">Cart</a>
					</li>
					<li class="nav-item hidden-link">
						<a class="nav-link" href="entry/login.php">Login</a>
					</li>
				</ul>
			</div>
			<div class="nav-link-cart col-4 d-md-block cart-icon-container">
				<?php
					if(!isset($_SESSION['userid'])){
						echo "<a class='mr-3' href='cart.php'><img src='../../img/cart.png' alt='My Cart' class='cart-icon'></a>";
						echo "<a href='entry/login.php'><button type='button' class='btn btn-primary login-btn'>Login Admin</button></a>";
					}
					else{
						echo "<div class='dropdown my-1'>";
						echo "<img class='profile-pic' src='../../img/logo-1.png' alt='Profile Picture' style='width:45px;height:auto;'>";
						echo "<span class='ml-2' style='color:white;font-weight:bold'>CROMS Catering</span>";
						echo "<div class='dropdown-content'>";
						echo "<a href='../admin/manageOrders.php'>Admin Page</a>";
						echo "<a href='../../includes/logout.inc.php'>Log out</a>";
						echo "<a href='entry/register.php'>Register Admin</a>";
						echo "</div>";
						echo "</div>";
						// echo "<a href='../includes/logout.inc.php'><button type='button' class='btn btn-warning login-btn'>Sign out</button></a>";
					}
				?>
			</div>
		</div>
	</div>
	</nav>
</header>
	