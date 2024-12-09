<?php
session_start(); // Start the session for authentication and session variables

// Check if the user is logged in
if (!isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "Please log in first to access this page.";
    header('location: login.php'); // Redirect to login page
    exit(0);
}

include('includes/header.php');
include('includes/navbar.php');

include 'db_conn.php'; 

// Initialize the search query
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Pagination settings
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Results per page
$offset = ($page - 1) * $limit;

// Use prepared statements for SQL query
$sql = "SELECT * FROM products WHERE name LIKE ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$search_param = '%' . $search . '%';
$stmt->bind_param("sii", $search_param, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Count total rows for pagination
$total_sql = "SELECT COUNT(*) FROM products WHERE name LIKE ?";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->bind_param("s", $search_param);
$total_stmt->execute();
$total_stmt->bind_result($total_rows);
$total_stmt->fetch();
$total_pages = ceil($total_rows / $limit);
$total_stmt->close();
?>

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Link to Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Link to external CSS file -->
<link rel="stylesheet" href="styles3.css">

<div class="container mt-5 table-container glowing-table-container">
    <!-- Title -->
    <div class="mb-4 text-center">
        <h1>Inventory Management System</h1>
    </div>

    <!-- Status Message -->
    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION['status'];
            unset($_SESSION['status']); // Clear the message
            ?>
        </div>
    <?php endif; ?>

    <table class="table table-bordered">
        <tr>
            <td colspan="2">
                <!-- Search Form -->
                <div class="d-flex justify-content-between align-items-center">
                <div>
                        <a href="add_product.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus"></i> Add New Product
                        </a>
                    </div>

                    <div class="ms-auto">
                        <form method="POST" action="search_product.php" class="d-flex align-items-center">
                            <input type="text" name="search" class="form-control form-control-lg me-2" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>" style="max-width: 300px;">
                            <button type="submit" class="btn btn-primary btn-lg d-flex align-items-center">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                        </form>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <!-- Product Table -->
                <div class="table-responsive">
                    <table class="table glowing-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="glowing-row">
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo str_ireplace($search, "<mark>{$search}</mark>", htmlspecialchars($row['name'])); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td>₱<?php echo number_format($row['price'], 2); ?></td>
                                <td>
                                    <a href="edit_product.php?id=<?php echo $row['id']; ?>" title="Edit" class="text-warning">
                                        <i class="fas fa-edit"></i>
                                    </a> 
                                    | 
                                    <!-- Delete link with confirmation -->
                                    <a href="javascript:void(0);" class="text-danger" title="Delete" onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>

<!-- Modal for Confirmation -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <!-- Added modal-dialog-centered class -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<script>
    function confirmDelete(productId) {
        // Set the product ID for deletion
        const deleteUrl = 'delete_product.php?id=' + productId;
        
        // Set the href attribute of the "Delete" button in the modal
        document.getElementById('confirmDeleteBtn').setAttribute('href', deleteUrl);
        
        // Show the confirmation modal
        var myModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        myModal.show();
    }
</script>

</body>
</html>
