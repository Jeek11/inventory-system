<div class="bg-info">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg bg-info animated-navbar">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#"><i class="fas fa-home"></i> <span class="navbar-brand">Home</span></a> 
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse animated-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                  <a class="nav-link active" href="index.php"><i class="fas fa-home"></i> Home</a>
                                </li>

                                <?php if(!isset($_SESSION['authenticated'])) : ?>
                                <li class="nav-item">
                                  <a class="nav-link" href="register.php"><i class="fas fa-user-plus"></i> Register</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                                </li>
                                <?php endif ?>

                                <?php if(isset($_SESSION['authenticated'])) : ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                </li>
                                <?php endif ?>

                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
