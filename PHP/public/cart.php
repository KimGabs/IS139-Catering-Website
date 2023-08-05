<?php
	include_once 'header.php';
	require_once '../../includes/database.inc.php';
	require_once '../../includes/functions.inc.php';
	require_once '../../includes/cartContent.inc.php';
?>
	<main id="cart">
		<div class="card">
			<div class="col-md-8 cart">
				<div class="title">
					<div class="row">
						<div class="col"><h4 style="margin:0; font-weight: 300;"><b>My Cart</b></h4></div>
                	</div>
				</div>
				<?php
					cartContent($conn, $cart);
				?>
			
				<div class='back-to-shop'>
					<a href='menu.php'>&leftarrow;<span class='text-muted'>Back to menu</span></a>		
				</div>
			</div>
				<div class="col-md-4 summary">
                    <div><h5><b>Summary</b></h5></div>
                    <hr>
						<?php
							summary($conn, $cart);
						?>
				</div>
		</div>
		<?php
			showPackageDetails($conn, $cart);
		?>
	</main>
<?php
	include_once 'footer.php';
?>