<?php

session_start();

$page_title = "Login form";
include('includes/header.php');
include('includes/navbar.php');

?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                        <?php
                            if(isset($_SESSION['status']))
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
                            ?>

            <div class="card">
                <div class="card-header">
                    <h5>Resend Email Verification</h5>
                </div>
                <div class="card-body">
                    <form action="resend-code.php" method="POST">
                        <div class="form-group  mb-3">
                            <label>Email Address</label>
                            <input type="text" name="email" class="form-control" placeholder="Enter email address">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="resend_email_verify_btn" class="btn btn-primary btn-block">Submit</button>
                           
                        </div>
                    </form>
                
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>