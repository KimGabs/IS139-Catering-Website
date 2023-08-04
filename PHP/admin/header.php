<?php
	session_start();
	//initialize cart if not set or is unset
	if(!isset($_SESSION['userid'])){
		header('location: ../../index.php?nonAdmin');
	exit();
	}
	if (!isset($_COOKIE['cart']) and !isset($_COOKIE['package'])) {
		$cart = array();
		$package = array();
		setcookie('cart', json_encode($cart), time() + (86400 * 30), '/'); // Cookie expires in 30 days
		setcookie('package', json_encode($package), time() + (86400 * 30), '/'); // Cookie expires in 30 days
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Croms Catering</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/js/bootstrap.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../css/admin.css">
	<link rel="stylesheet" href="../../css/profile-dropdown.css">
	<link rel="stylesheet" href="../../css/addProduct.css">
	<link rel="stylesheet" href="../../css/manageOrders.css">
	<link rel="stylesheet" href="../../css/manageProducts.css">
	<link rel="stylesheet" href="../../css/inquiries.css">
</head>
<body>
<header>
<nav class="nav">
	<?php
			if (isset($_SESSION["useruid"])) {
					echo "<div class='col-10'></div>";
					echo "<div class='dropdown py-2'>";
					echo "<img class='profile-pic' src='../../img/logo-1.png' alt='Profile Picture' style='width:45px;height:auto;'>";
					echo "<span class='ml-2' style='color:white;font-weight:bold'>CROMS Catering</span>";
					echo "<div class='dropdown-content'>";
					if($_SESSION["userType"] == 'admin') {;
					echo "<a href='manageOrders.php'>Admin Page</a>";
					echo "<a href='../public/entry/register.php'>Register Admin</a>";
					echo "<a href='../../includes/logout.inc.php'>Log out</a>";
					}
					else{
						header("location: ../../index.php");
						exit();
					}
				
					echo "</div>";
					echo "</div>";
			}
		?>
</header>
	