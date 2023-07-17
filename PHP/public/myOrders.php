<?php
	include_once 'header.php';
	include_once '../../includes/showOrders.inc.php';
?>
<h1>My Orders</h1>
<div class="container-orders mb-5">
<div class="card p-0 pb-4 mb-5 ms-4 me-4" style="border-radius: 15px;">
<div class="row row-cols-1 row-cols-md-2 g-4">
	<?php
		displayMyOrders($_SESSION['userid']);
	?>
</div>
</div>
</div>
       

<?php
	include_once 'footer.php';
?>
