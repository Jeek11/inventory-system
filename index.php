<?php 
session_start();
$page_title = "Registration Form";
include('includes/header.php');
include('includes/navbar.php');
?> 

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert">
                <?php
                            if(isset($_SESSION['status']) && $_SESSION['status'] == 'success')
                            {
                                ?>
                                <script>
                                    Swal.fire({
                                        title: '<?= $_SESSION['status']; ?>',
                                        icon: 'success',  // You can change the icon to 'error', 'warning', etc. based on your scenario
                                        confirmButtonText: 'Ok'
                                    });
                                </script>
                                <?php
                                unset($_SESSION['status']);
                            }
                            else if(isset($_SESSION['status']) && $_SESSION['status'] == 'error')
                            {
                            ?>
                            <script>
                                Swal.fire({
                                    title: '<?= $_SESSION['status']; ?>',
                                    icon: 'error',  // You can change the icon to 'error', 'warning', etc. based on your scenario
                                    confirmButtonText: 'Ok'
                                });
                            </script>
                            <?php
                            unset($_SESSION['status']);
                        }
                            ?>

                </div>
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h5>Registration Form</h5>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone">Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="tel" name="phone" class="form-control" id="phone" placeholder="Enter your phone number" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="register_btn" class="btn btn-primary btn-block">Register Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php');?> 







