<?php
	include_once 'header.php';
	include_once '../../../includes/database.inc.php';
?>
<?php
    // Function to clean and sanitize input data
    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

	if (isset($_POST["SubmitInquiry"])){
		$name = clean_input($_POST["name"]);
        $email = clean_input($_POST["email"]);
        $subject = clean_input($_POST["subject"]);
        $message = clean_input($_POST["message"]);

		$stmt = $conn->prepare("INSERT INTO inquiries (senderName, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        $stmt->execute();

        // Close the database connection
        $stmt->close();
		header("location: contactUs.php?inquiry=success");
	}
?>	
	<main>
		<section class="contact-us-box">
                <div class="contact-us-box-header"> 
                    <h1> Contact Us </h1>
                    <h3 style='margin-bottom:5px'> Questions? We're here to help! </h3>
                </div>
				<div class="row container" style="font-weight: 700;font-size:1.2em;">
				<form method="post" action="contactUs.php">
				<div class="form-group row" style='margin-bottom:0px'>
				<div class="form-group col-1"></div>
					<div class="form-group col-md-3 d-flex justify-content-end align-items-center">
						<label for="name">Name:</label>
					</div>
					<div class="form-group col-md-6 d-flex justify-content-end align-items-center">
						<input class="form-control" type="text" id="name" name="name" required><br>
					</div>
					<div class="form-group col-2"></div>
				</div>
				<div class="form-group row" style='margin-bottom:0px'>
					<div class="form-group col-1"></div>
					<div class="form-group col-md-3 d-flex justify-content-end align-items-center">
						<label for="email">Email:</label>
					</div>
					<div class="form-group col-md-6 d-flex justify-content-end align-items-center">
						<input class="form-control" type="email" id="email" name="email" required><br>
					</div>
					<div class="form-group col-2"></div>
				</div>
				<div class="form-group row" style='margin-bottom:0px'>
					<div class="form-group col-1"></div>
					<div class="form-group col-md-3 d-flex justify-content-end align-items-end">
						<label for="subject">Subject:</label>
					</div>
					<div class="form-group col-md-6 d-flex justify-content-end align-items-center">
						<input class="form-control" type="text" id="subject" name="subject" required><br>
					</div>	
					<div class="form-group col-2"></div>
				</div>
				<div class="form-group row" style='margin-bottom:0px'>
					<div class="form-group col-md-3 d-flex justify-content-end align-items-center" style='margin-bottom:5px'>
						<label for="message">Message:</label><br>
					</div>	
				</div>
				<div class="form-group row" style='margin-bottom:0px'>
				<div class="form-group col-2"></div>
					<div class="form-group col-md-9 d-flex justify-content-end align-items-center">
						<textarea class="form-control"  id="message" name="message" rows="4" required></textarea><br>
					</div>	
				</div>
				<div class="form-group row">
					<div class="form-group col-3"></div>
					<div class="form-group col-6 d-flex justify-content-center align-items-center">
						<button class="btn btn-primary mb-2" type="submit" name="SubmitInquiry" style="padding:.375rem 2.45rem">Submit</button>
					</div>		
					<div class="form-group col-3"></div>
				</div>
				</form>
				</div>
				
		</section>
		<?php
			if(isset($_GET["inquiry"])) {
				echo '<div class="modal fade" id="inquiryWindow" tabindex="-1" role="dialog" aria-labelledby="inquiryWindow" aria-hidden="False">';
				echo '<div class="modal-dialog" role="document" style="margin: 11.75rem auto;">';
				echo '<div class="modal-content">';
				echo '<div class="modal-header" style="padding: 0 1rem">';
				echo '<h5 class="modal-title" id="modal-Title"></h5>';
				echo '<button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">';
				echo '<span aria-hidden="true">&times;</span>';
				echo '</button>';
				echo '</div>';
				echo '<div class="modal-body" style="text-align:center; margin: 5px 0 -15px; color: green;">';
				if ($_GET["inquiry"] == "success") {
					echo 'Message sent successfully!</div>';
				}
				else if ($_GET["addedToCart"] == "failed"){
					echo "<p>Failed to send message! Please try again next time.</p>";
				}
				echo '<div class="modal-footer-2" style="padding: 15px 0">';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}
		?>
	</main>
<?php
	include_once 'footer.php';
?>