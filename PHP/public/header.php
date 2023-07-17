<?php
	session_start();
	//initialize cart if not set or is unset
	if(isset($_SESSION['userid'])){
		if (!isset($_SESSION['cart'])) {
			$_SESSION['cart'] = array();
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>CROMS Catering</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../css/login-form.css">
	<link rel="stylesheet" href="../../css/profile-dropdown.css">
	<link rel="stylesheet" href="../../css/addProduct.css">
	<link rel="stylesheet" href="../../css/cart.css">
	<link rel="stylesheet" href="../../css/aboutUs.css">
	<link rel="stylesheet" href="../../css/contactUs.css">
</head>
<body>
<header>
	<section class="header-section">
		<div class="navbar-container row">
			<div class="col-1"></div>
			<div class="col-3">
				<nav class="navbar navbar-expand-lg">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0" style="justify-content:flex-end">
						<li><a href="../index.php">Home</a></li>
						<li><a href="menu.php">Menu</a></li>
					</ul>
				</nav>
			</div>
			<div class="logo col-2">
				<a href="../index.php">
					<img src="../../img/logo-1.png" alt="Website logo">
				</a>
			</div>
			<div class="col-3">
				<nav class="navbar navbar-expand-lg">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li><a href="others/aboutUs.php">About Us</aß></li>
						<li><a href="others/contactUs.php">Contact Us</a></li>
					</ul>
				</nav>
			</div>
			<div class="navbar-cart col-1">
					<div class='cart-icon'><a href='cart.php'><img src='../../img/cart.png' alt='My Cart'></a></div>
			</div>
		</div>
	</section>
</header>