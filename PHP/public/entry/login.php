<?php
	include_once 'header.php';
    if(isset($_SESSION['useruid'])){
        header('location: ../../index.php?alreadylogin');
        exit();
    }
?>
	<main>
		<section class="signup-form mt-3">
            <h1>Login</h1>
            <div class="signup-form-2">
                <form action="../../../includes/login.inc.php" method="post">
                    <input type="text" name="uid" placeholder="Username/Email">
                    <input type="password" name="pwd" placeholder="Password">
                    <button class="btn submit-login-btn" type="submit" name="submitLogin">Log In</button>
                </form>
            </div>
            <?php
                if(isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo "<p>Fill in all fields!</p>";
                    }
                    else if ($_GET["error"] == "wronglogin"){
                        echo "<p>Incorrect username or password!</p>";
                        echo "<p>Only admins can log in!</p>";
                    }
                }
            ?>
    </section>
	</main>
<?php
	include_once 'footer.php';
?>