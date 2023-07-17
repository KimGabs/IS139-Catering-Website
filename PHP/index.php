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
						<h1>Placeholder 1</h1>
						<a href="public/products.php">
							<img class="d-block w-100" src="https://fakeimg.pl/1200x400" alt="First slide">
						</a>
					</div>
					<div class="carousel-item">
					<h1 style="color: #fe5946;">Placeholder 2</h1>
						<a href="public/products.php?category=dog+food">
						<img class="d-block w-100" src="https://fakeimg.pl/1200x400" alt="Second slide">
						</a>
					</div>
					<div class="carousel-item">
					<h1 style="color: whitesmoke;">Placeholder 3</h1>
					<a href="public/products.php?category=cat+food">
						<img class="d-block w-100" src="https://fakeimg.pl/1200x400" alt="Third slide">
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