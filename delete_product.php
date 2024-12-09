<?php
session_start();
include('db_conn.php'); // Database connection


// Check if the 'id' parameter is passed via GET request
if (isset($_GET['id'])) {
    $productId = (int)$_GET['id']; // Get the product ID from the URL

    // Prepare the SQL query to delete the product
    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Bind the product ID as an integer parameter
    $stmt->bind_param("i", $productId);
    
    // Execute the query
    if ($stmt->execute()) {
        // If successful, set a session message
        $_SESSION['status'] = "Product deleted successfully!";
    } else {
        // If an error occurred, set an error message
        $_SESSION['status'] = "Error deleting product.";
    }

    $stmt->close(); // Close the prepared statement
}

// Redirect back to the main page after deletion
header('location: inventory.php');
exit(0);
?>
