<?php
	session_start();
	require_once '../../includes/database.inc.php';
	require_once '../../includes/functions.inc.php';
	include_once '../../includes/checkout.inc.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>My Pet Shop</title>
	<meta charset="utf-8">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../css/checkout.css">
</head>
<body>
	<main id="checkout">
	<div class="card d-flex justify-content-end">
			<div class="col-md-6 form">
				<div class="title">
					<div class="row">
						<div class='back-to-cart'><a href='cart.php'>&leftarrow;<span class='text-muted'>Back to Cart</span></a></div>
						<img src="../../img/logo-2.png" alt="logo">
						<section class="checkout-form">
						<hr>
							<form action="../../includes/submitOrder.inc.php" id="order-form-1" method="post" style="margin-top: 25px;">
								<div class="mb-3">
									<h6>Contact information</h6>
									<input type="text" class="form-control" name="contactNo" pattern="[0-9]{11}"  placeholder="Mobile phone number">
								</div>
								<div class="mb-3">
									<h6>Shipping address</h6>
									<select name="country-reg">
										<option value="ph">Philippines</option>
									</select>
									<input type="text" class="form-control" id="address" name="address" placeholder="Address">
									<div class="d-flex justify-content-between">
										<input type="text" class="form-control" id="postal" name="postal" pattern="[0-9]{4}" placeholder="Postal">
										<input type="text" class="form-control" id="city" name="city" placeholder="City">
										<input type='hidden' name='userId' value="<?php echo $_SESSION['userid']; ?>">
									</div>
									<hr>
								</div>
							</form>
						</section>
					</div>
				</div>
				<div class="mb-5" id="thanks">
					<h4>Thank you for your purchase!<br>Shop Again With Us Next Time!</h4>
				</div>
				<div class='pb-4 d-flex justify-content-center'>
					<div><img src="../../img/group-of-dogs.png" alt="pets"></div>
				</div>
			</div>
				<div class="col-md-5 summary pt-4">
					<div class="box p-4">
						<?php
							printCart($conn, $_SESSION['userid']);
						?>
						<hr>
						<div class="mb-3 mt-4">
							<form action="../../includes/checkout.inc.php" id="order-form-2" method="get" style="margin-top: 25px;">
								<h6>Payment method</h6>
								<select name="payMethod" id="">
									<option value="cod">Cash on Delivery (COD)</option>
								</select>
							</form>
						</div>
						<hr>
						<div class="mb-3">
							<?php 
								if(isset($_GET["error"])) {
									if ($_GET["error"] == "emptyInput") {
										echo "<p style='color:brown; text-align: center; margin-bottom: 2px'>Fill in all fields!</p>";
									}
								}
							?>
							<button type="submit" class="mb-3 btn" id="submit" name="order" form="order-form-1">Place order</button>
						</div>
				</div>
		</div>
	</main>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script type="text/javascript" type="text/javascript" src="../../js/script.js"></script>
<script type="text/javascript" src="../../js/script-2.js"></script>
