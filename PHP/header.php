<?php
	session_start();
	//initialize cart if not set or is unset
	if (!isset($_SESSION['cart']) and !isset($_SESSION['package'])) {
		$_SESSION['cart'] = array();
		$_SESSION['package'] = array();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CROMS Catering</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/login-form.css">
	<link rel="stylesheet" href="../css/profile-dropdown.css">
</head>
<body>
<header>
	<nav class="navbar navbar-expand-md navbar-dark">
	<div class="container-fluid">
		<a class="navbar-brand d-md-none" href="#">
		<img src="../img/logo-1.png" alt="">
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<!-- Cart icon -->
		
		<div class="collapse navbar-collapse" id="navbarNav">
			<div class="col-10 d-flex justify-content-center">
				<ul class="navbar-nav mx-auto">
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="index.php">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="public/menu.php">Menu</a>
					</li>
					<a class="navbar-brand d-none d-md-block" href="index.php">
						<img src="../img/logo-1.png" alt="CROMS">
					</a>
					<li class="nav-item">
						<a class="nav-link" href="public/others/aboutUs.php">About us</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="public/others/contactUs.php">Contact us</a>
					</li>
					<li class="nav-item hidden-link">
						<a class="nav-link" href="public/cart.php">Cart</a>
					</li>
					<li class="nav-item hidden-link">
						<a class="nav-link" href="public/entry/login.php">Login</a>
					</li>
				</ul>
			</div>
			<div class="nav-link-cart col-4 d-md-block cart-icon-container">
				<?php
					if(!isset($_SESSION['userid'])){
						echo "<a class='mr-3' href='public/cart.php'><img src='../img/cart.png' alt='My Cart' class='cart-icon'></a>";
						echo "<a href='public/entry/login.php'><button type='button' class='btn btn-primary login-btn'>Login Admin</button></a>";
					}
					else{
						echo "<div class='dropdown my-1'>";
						echo "<img class='profile-pic' src='../img/logo-1.png' alt='Profile Picture' style='width:45px;height:auto;'>";
						echo "<span class='ml-2' style='color:white;font-weight:bold'>CROMS Catering</span>";
						echo "<div class='dropdown-content'>";
						echo "<a href='admin/manageOrders.php'>Admin Page</a>";
						echo "<a href='../includes/logout.inc.php'>Log out</a>";
						echo "<a href='public/entry/register.php'>Register Admin</a>";
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
	