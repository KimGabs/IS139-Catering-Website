<?php
	include_once 'header.php';
	include_once '../../includes/showOrders.inc.php';
?>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0" style="background-color: #303030;">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-1 text-white min-vh-100">
                <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="d-none d-sm-inline" style="font-weight: bold;font-size: 1.8em;">Menu</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="manageOrders.php" class="nav-link align-middle px-0">
                            <i class="fs-5 bi-house"></i> <span class="ms-1 d-none d-sm-inline">My Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">My Website</span> </a>
							<div class="collapse" id="submenu1" data-bs-parent="#menu">
								<ul class="nav flex-column ms-1">
									<li class="w-100">
										<a href="../index.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Home</span></a>
									</li>
									<li>
										<a href="../public/menu.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Menu</span></a>
									</li>
									<li>
										<a href="../public/others/aboutUs.php" class="nav-link px-0"> <span class="d-none d-sm-inline">About us</span></a>
									</li>
									<li>
										<a href="../public/others/contactUs.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Contact us</span></a>
									</li>
								</ul>
							</div>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Events Calendar</span> </a>
                    </li>
                </ul>
            </div>
        </div>
	<div class="col py-3">
		<h1>Manage Orders</h1>
		<div class="container p-0 mb-5">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="table-responsive">
				<table class="table custom-table align-middle table-condensed">
					<thead>
						<tr>
							<th></th>
							<th style='text-align: center;'>Order No.</th>
							<th>Recipient</th>
							<th>Address</th>
							<th>Contact No.</th>			
							<th>Total Price</th>
							<th>Order Status</th>
						</tr>
					</thead>
					<tbody>	
						<?php
							displayOrders();
						?>
					</tbody>
				</table>
					</div>
				</div> 
			</div>
			</div>
			
	</div>
    </div>
</div>
<?php
	// include_once 'footer.php';
?>
