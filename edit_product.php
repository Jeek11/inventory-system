<?php
// Start the session (if necessary)
session_start();

// Include database connection
include 'db_conn.php'; 

// Include the header file
include 'includes/header.php';  // Assuming your header.php includes HTML opening tags, CSS, etc.
include('includes/navbar.php'); // Navigation bar

// Get the product ID from the URL (assuming it's passed as a query parameter)
$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form input values
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Check if the product name already exists (except for the current product being edited)
    $check_sql = "SELECT id FROM products WHERE name = '$name' AND id != $id LIMIT 1";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Product already exists
        $_SESSION['error_message'] = "Error: A product with the name '$name' already exists in the inventory.";
        header("Location: edit_product.php?id=$id");  // Redirect back to the edit product page
        exit;
    } else {
        // If the product name doesn't exist, update the product
        $sql = "UPDATE products SET name = '$name', description = '$description', quantity = '$quantity', price = '$price' WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success_message'] = "Product updated successfully.";
            header("Location: inventory.php");  // Redirect to the inventory list
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<div class="container">
    <h1>Edit Product</h1>

    <?php
    // Show success or error messages if available
    if (isset($_SESSION['error_message'])) {
        echo "<div class='alert alert-danger'>{$_SESSION['error_message']}</div>";
        unset($_SESSION['error_message']);  // Clear the message after displaying it
    }

    if (isset($_SESSION['success_message'])) {
        echo "<div class='alert alert-success'>{$_SESSION['success_message']}</div>";
        unset($_SESSION['success_message']);  // Clear the message after displaying it
    }
    ?>

    <?php
    // Get product details to populate the form
    $product_sql = "SELECT * FROM products WHERE id = $id";
    $product_result = $conn->query($product_sql);

    if ($product_result->num_rows > 0) {
        $product = $product_result->fetch_assoc();
    ?>
        <form action="edit_product.php?id=<?php echo $id; ?>" method="POST">
            <div style="margin-bottom: 15px;">
                <label for="name">Product Name:</label><br>
                <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required style="width: 100%;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="4" required style="width: 100%;"><?php echo $product['description']; ?></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="quantity">Quantity:</label><br>
                <input type="number" id="quantity" name="quantity" value="<?php echo $product['quantity']; ?>" required style="width: 100%;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="price">Price:</label><br>
                <input type="number" step="0.01" id="price" name="price" value="<?php echo $product['price']; ?>" required style="width: 100%;">
            </div>

            <div>
            <button type="submit" class="btn btn-success" id="submitBtn">Update Product</button>
            </div>
        </form>
    <?php
    } else {
        echo "<p>Product not found.</p>";
    }
    ?>

    <!-- Back to Inventory Button -->
    <a href="inventory.php" class="btn btn-secondary mt-3">Back to Inventory</a>
    </a>
</div>


<?php
// Include the footer file
include 'includes/footer.php';  // Assuming your footer.php includes the closing HTML tags
$conn->close();
?>
