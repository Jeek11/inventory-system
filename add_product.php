<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('includes/header.php'); // Assumes header.php includes the opening HTML tags and styles
include('includes/navbar.php'); // Navigation bar

// Include database connection
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form input values
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];

    // Validate inputs
    if (empty($name) || empty($description) || $quantity <= 0 || $price <= 0) {
        $_SESSION['error_message'] = "Please provide valid inputs for all fields.";
        header("Location: add_product.php");
        exit;
    }

    // Check if the product already exists
    $check_sql = "SELECT id FROM products WHERE name = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        $_SESSION['error_message'] = "Error: A product with the name '$name' already exists in the inventory.";
        header("Location: add_product.php");
        exit;
    } else {
        // Insert the new product
        $insert_sql = "INSERT INTO products (name, description, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssii", $name, $description, $quantity, $price);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "New product added successfully.";
            header("Location: inventory.php");
            exit;
        } else {
            // Log the error for debugging and display a generic error message
            error_log("Database error: " . $stmt->error);
            $_SESSION['error_message'] = "An error occurred while adding the product. Please try again.";
            header("Location: add_product.php");
            exit;
        }
    }
}
?>
<div class="container">
    <h1>Add New Product</h1>

    <?php
    // Display feedback messages
    if (isset($_SESSION['error_message'])) {
        echo "<div class='alert alert-danger'>" . htmlspecialchars($_SESSION['error_message']) . "</div>";
        unset($_SESSION['error_message']);
    }

    if (isset($_SESSION['success_message'])) {
        echo "<div class='alert alert-success'>" . htmlspecialchars($_SESSION['success_message']) . "</div>";
        unset($_SESSION['success_message']);
    }
    ?>

    <form action="add_product.php" method="POST" id="addProductForm">
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required class="form-control" oninput="validateInput()">
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="3" class="form-control" oninput="validateInput()"></textarea>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" required class="form-control" oninput="validateInput()">
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" min="0.01" required class="form-control" oninput="validateInput()">
        </div>

        <!-- Add some margin to the "Add Product" button -->
        <button type="submit" class="btn btn-success mt-3 mb-3" id="submitBtn">Add Product</button>
        
    </form>

    <!-- Back to Inventory Button -->
    <a href="inventory.php" class="btn btn-secondary mt-0">Back to Inventory</a>
</div>

<script>
// Real-time form validation
function validateInput() {
    const name = document.getElementById('name').value;
    const description = document.getElementById('description').value;
    const quantity = document.getElementById('quantity').value;
    const price = document.getElementById('price').value;

    const submitBtn = document.getElementById('submitBtn');

    // Enable submit button only if all fields are valid
    if (name && description && quantity > 0 && price > 0) {
        submitBtn.disabled = false;
    } else {
        submitBtn.disabled = true;
    }
}

// Initialize validation state
validateInput();
</script>

<?php include('includes/footer.php'); // Assumes footer.php closes HTML tags ?>
<?php $conn->close(); ?>
