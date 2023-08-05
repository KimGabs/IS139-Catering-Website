<?php
include_once 'header.php';
require_once '../includes/database.inc.php';
?>
<main class='homepage'>
<section class='top'>
		<div class='home-header'>
			<div id="carousel-top" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carousel-top" data-slide-to="0" class="active"></li>
					<li data-target="#carousel-top" data-slide-to="1"></li>
					<li data-target="#carousel-top" data-slide-to="2"></li>
				</ol>
				<div class="carousel-inner">
					<div class="carousel-item active">
						<h1 style="color: #f0f0f0;">Beef Viands</h1>
						<a href="public/menu.php?category=beef+viands">
							<img class="d-block mx-auto" src="../img/cover-3.jpeg" style="width:100%;height:550px;object-fit:cover;" alt="First slide">
						</a>
					</div>
					<div class="carousel-item">
					<h1 style="color: #f0f0f0;">Chicken Viands</h1>
						<a href="public/menu.php?category=chicken+viands">
						<img class="d-block mx-auto" src="../img/cover-4.jpeg" style="width:100%;height:550px;object-fit:cover;" alt="Second slide">
						</a>
					</div>
					<div class="carousel-item">
					<h1 style="color: #f0f0f0;">Fish & Seafood Viands</h1>
					<a href="public/menu.php?category=fish+%26+seafood+viands+">
						<img class="d-block mx-auto" src="../img/cover-5.jpeg" style="width:100%;height:550px;object-fit:cover;" alt="Third slide">
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
	<div class="row" style="margin:40px"><hr></div>
	<section class='mid'>
		<div class="container">
			<div class="row">
				<div class="col-6 div-post-text">
					<h2 id='title-name'>CROMS Catering</h2>
					<p class="index-text">CROMS Catering Services, formerly known as DARDUS Food Stop and ROMS 8 Silver Spoon, is a reputable catering company with a vision of national expansion and a commitment to providing nutritious yet affordable food. Guided by Christian values and a culture of respect, they aim to become a respected and profitable enterprise while fostering customer satisfaction and care for the environment.</p>
				</div>
				<div class="col-6 div-post-pic">
					<img class="post-pic" src="../img/pic-1.jpeg" alt="post-pic">
				</div>
			</div>
		</div>
	</section>
	<section class="services">
	<div class="row" style="margin:40px"><hr></div>
	</section>
	<section class="testimonial-container" style="margin-bottom: 50px;">

<div class="row" style="max-width: 1200px;margin: 0 auto;">
   <div class="col-md-4 col-sm-12 testi-container-1">
      <div class="row testi-text-row" style="margin: 0 auto;">
         <div class="col-md-12 col-sm-12 testimonial-text">
            <div class="quote"></div>
            <blockquote>
               <p class="testimonial-p">CROMS Catering Services made our corporate event a huge success! The food was delicious, and their team was incredibly professional and attentive to our needs. Highly recommend their catering expertise!</p>
            </blockquote>
         </div><!--testimonial-text-->
      </div><!--testi-text-row-->
      <div class="row name-small-row" style="margin: 0 auto;">
         <div class="col-md-6 col-sm-12 name-small"><a href="http://ericwoneditor.com">Mark N. / Film Director</a></div>
         <div class="col-md-6 col-sm-12 image-cont-1">
            <div class="thumb thumb1"> </div>
         </div>
      </div><!---name-small-row-->
   </div><!---Testi-container-1-->
     <div class="col-md-4 col-sm-12 testi-container-1">
      <div class="row testi-text-row" style="margin: 0 auto;">
         <div class="col-md-12 col-sm-12 testimonial-text">
            <div class="quote"></div>
            <blockquote>
               <p class="testimonial-p">As a school, we trust CROMS for our canteen concession, and they never disappoint! The menu options are diverse, catering to all our students' preferences, and the quality of the food is consistently outstanding.</p>
            </blockquote>
         </div><!--testimonial-text-->
      </div><!--testi-text-row-->
      <div class="row name-small-row" style="margin: 0 auto;">
         <div class="col-md-6 col-sm-12 name-small"><a href="http://bleuestudio.com">Sol Cano / Teacher</a></div>
         <div class="col-md-6 col-sm-12 image-cont-1">
            <div class="thumb thumb2"> </div>
         </div>
      </div><!---name-small-row-->
   </div><!---Testi-container-1-->
     <div class="col-md-4 col-sm-12 testi-container-1">
      <div class="row testi-text-row" style="margin: 0 auto;">
         <div class="col-md-12 col-sm-12 testimonial-text">
            <div class="quote"></div>
            <blockquote>
               <p class="testimonial-p">CROMS Catering was a revelation at our company event! Delicious, healthy food, fantastic service, and a team that embodies professionalism and care for the environment. Thoroughly impressed!</p>
            </blockquote>
		</div><!--testimonial-text-->
      </div><!--testi-text-row-->
      <div class="row name-small-row" style="margin: 0 auto;">
         <div class="col-md-6 col-sm-12 name-small"><a href="https://www.galzivfilm.com/">Gal Ziv / CEO</a></div>
         <div class="col-md-6 col-sm-12 image-cont-1">
            <div class="thumb thumb3"> </div>
         </div>
      </div><!---name-small-row-->
   </div><!---Testi-container-1-->
</div><!---Row--->
</section>

</main>
<?php
include_once 'footer.php';
?>