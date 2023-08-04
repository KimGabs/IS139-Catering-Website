<?php
	include_once 'header.php';
    if(!isset($_SESSION['userid'])){
        header('location: ../../index.php?nonAdmin');
        exit();
	}
?>
	<main>
		<section class="signup-form">
		<h1>Register account</h1>
		<div class="signup-form-2">
            
            <form action="../../../includes/register.inc.php" method="post">
                <input type="text" name="name" placeholder="Full name">
                <input type="text" name="email" placeholder="Email">
                <input type="text" name="uid" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password" class="password">
                <input type="password" name="pwdrepeat" placeholder="Repeat password">
                <button type="submit" name="submit" style="background-color: #0d6efd; color: white;">Sign Up</button>
            </form>
        </div>
        <?php
        if(isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Fill in all fields!</p>";
            }
            else if ($_GET["error"] == "invalidUid"){
                echo "<p>Enter a proper username!</p>";
            }
            else if ($_GET["error"] == "invalidEmail") {
                echo "<p>Enter a proper email!</p>";
            }
            else if ($_GET["error"] == "passwordsDontMatch") {
                echo "<p>Passwords doesn't match!</p>";
            }
            else if ($_GET["error"] == "stmtFailed") {
                echo "<p>Something went wrong, try again!</p>";
            }
            else if ($_GET["error"] == "usernameTaken") {
                echo "<p>Username already exists!</p>";
            }
            else if ($_GET["error"] == "none") {
                echo "<p>You have signed up!</p>";
            }
        }
        ?>
		</section>
	</main>
<?php
	include_once 'footer.php';
?>