<?php
	include_once 'header.php';
?>
	<main>
        <h1>Add Product</h1>
		<section class="add-product-form">
            <form action="../../includes/addProduct.inc.php" method="POST" enctype="multipart/form-data">
                <div class="add-product-form-left">
                    <img id="preview" src="../../img/add-image.png" alt="your image" />
                    <input accept="image/*" type='file' id="image" name="image">
                </div>
                <div class="add-product-form-right">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" id="name">
                    <label for="name">Product Category</label>
                    <input type="text" name="category" id="category">
                    <label for="description">Product Description</label>
                    <textarea name="desc" id="description"></textarea>
                    <div class="add-product-form-right-2">
                        <input type="number" name="price" id="price" min="0" step=".01" placeholder="Price">
                        <input type="number" name="quantity" id="quantity" min="0" placeholder="Quantity">
                    </div>
                    <div class="error">
                    <?php
                        if(isset($_GET["error"])) {
                            if ($_GET["error"] == "emptyinput") {
                                echo "<p>Fill in all fields!</p>";
                            }
                            else if ($_GET["error"] == "emptyFile") {
                                echo "<p>Image file is empty!</p>";
                            }
                            else if ($_GET["error"] == "invalidFileType") {
                                echo "<p>Image file type is invalid!</p>";
                            }
                            else if ($_GET["error"] == "invalidFileSize") {
                                echo "<p>Image file size is invalid!</p>";
                            }
                            else if ($_GET["error"] == "stmtFailed") {
                                echo "<p>Something went wrong, try again!</p>";
                            }
                            else if ($_GET["error"] == "none") {
                                echo "<p>Product added!</p>";
                            }
                        }
                    ?>
                    </div>
                    <button type="submit" name="submit">Add Product</button>
                </div>
            </form>
		</section>
	</main>
<?php
	include_once 'footer.php';
?>