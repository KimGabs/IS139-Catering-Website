<?php
include_once 'header.php';
require_once '../includes/database.inc.php';
?>
<main class='homepage'>
<section class='top'>
		<div class='home-header'>
			<!-- <a href="public/products.php"><img src="../img/cover-1.png" alt="Banner"></a> -->
			<div id="carousel-top" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carousel-top" data-slide-to="0" class="active"></li>
					<li data-target="#carousel-top" data-slide-to="1"></li>
					<li data-target="#carousel-top" data-slide-to="2"></li>
				</ol>
				<div class="carousel-inner">
					<div class="carousel-item active">
						<h1 style="color: #fe5946;;">Placeholder 1</h1>
						<a href="public/products.php">
							<img class="d-block mx-auto" src="https://media.istockphoto.com/id/650655146/photo/catering-food-wedding-event-table.webp?b=1&s=170667a&w=0&k=20&c=W3Gk6qixaUqF_lfIVEAOyL7O9zL99IKcxiO4f5nxQ0c=" style="width:100%;height:400px;object-fit:cover;" alt="First slide">
						</a>
					</div>
					<div class="carousel-item">
					<h1 style="color: #fe5946;">Placeholder 2</h1>
						<a href="public/products.php?category=dog+food">
						<img class="d-block mx-auto" src="https://images.pexels.com/photos/2291367/pexels-photo-2291367.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" style="width:100%;height:400px;object-fit:cover;" alt="Second slide">
						</a>
					</div>
					<div class="carousel-item">
					<h1 style="color: whitesmoke;">Placeholder 3</h1>
					<a href="public/products.php?category=cat+food">
						<img class="d-block mx-auto" src="https://images.pexels.com/photos/3843225/pexels-photo-3843225.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" style="width:100%;height:400px;object-fit:cover;" alt="Third slide">
					</a>
					</div>
				</div>
				<a class="carousel-control-prev" href="#carousel-top" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carousel-top" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</section>
	<section class='mid'>
		<h2>Other Products</h2>
	</section>
	<section class="services">
		<h2>Our Services</h2>
	</section>
</main>
<?php
include_once 'footer.php';
?>