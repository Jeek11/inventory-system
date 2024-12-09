<?php 
session_start();

if(isset($_SESSION['authenticated']))
{
    $_SESSION['status'] = "You are already logged in";
    header('location: inventory.php');
    exit(0);
}

$page_title = "Login Form";
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
                        <div class="alert alert-success">
                            <h5><?=$_SESSION['status']; ?></h5>
                        </div>
                        <?php
                        unset($_SESSION['status']);
                    }
                   
                ?>

                <div class="card shadow">
                    
                <div class="card-header text-center">
                <h5><i class="fas fa-key"></i> Login</h5>
                 </div>

                    <div class="card-body">
                        <form action="logincode.php" method ="POST">
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
                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rememberMe">
                                    <label class="custom-control-label" for="rememberMe">Remember Me</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="login_now_btn" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </form>

                        <hr>
                        <h5>
                            Did not recieve your Verification email?
                            <a href="resend-email-verification.php">Resend</a>
                        </5>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php');?>