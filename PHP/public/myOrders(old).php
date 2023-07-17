<?php
	include_once 'header.php';
	include_once '../../includes/showOrders.inc.php';
?>
<h1>My Orders</h1>
<div class="container p-0 mb-5">
	<div class="col-md-12">
    	<div class="panel panel-default myOrders">
        	<div class="table-responsive">
		<table class="table custom-table align-middle table-condensed">
			<thead>
				<tr>
					<th></th>
					<th style="text-align: center;">Order No.</th>
					<th>Address</th>	
					<th>Delivery Fee</th>
					<th>Subtotal</th>	
					<th>Total Price</th>
					<th style="text-align: center;">Order Status</th>
					<th></th>
				</tr>
			</thead>
    		<tbody>	
				<?php
					displayMyOrders($_SESSION['userid']);
				?>
    		</tbody>
		</table>
            </div>
          </div> 
      </div>
	</div>
       

<?php
	include_once 'footer.php';
?>
