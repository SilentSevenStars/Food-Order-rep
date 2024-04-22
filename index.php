<?php
    require 'component/connection.php';
    require 'component/show.php';
    require 'component/update.php';
    require 'component/add.php';

    session_start();
    $_SESSION['link'] = "index.php";

    $showProduct = new Show($conn, 'product');
    $showCategory = new Show($conn, 'category');
    $showCart = new Show($conn, 'cart');
    $showList = new Show($conn, 'lists');
    $addList = new Add($conn, 'lists');
    $addCart = new Add($conn, 'cart');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Ordering System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-...">
    <link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        .nav-link:hover{
            font-weight: bold;
        }
        .nav-link .bi:hover{
            color: red;
        }
        .c-item{
            height: 480px;
        }
        .c-img{
            height: auto; 
            max-width: 100%; 
            display: block; 
            margin: 0 auto; 
        }
        .caption {
            text-align: center;
        }
        #hero{
            background: linear-gradient(rgba(0, 0, 0, 0.507), rgba(0, 0, 0, 0.438)), url(image/hero.jpg);
            background-position: center;
            background-size: cover;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section id="hero" class="min-vh-100 d-flex align-items-center justify-content-center text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="fw-semibold display-1 text-warning">Welcome to Foodies</h1>
                    <div>
                        <a href="" class="btn btn-warning">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="feature" class="py-3 mt-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center pb-5">
                        <h2>Our services</h2>
                    </div>
                </div>
            </div>
            <div class="row gy-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card text-white text-center bg-dark pb-2">
                        <div class="card-body">
                            <i class="bi bi-basket" style="font-size: 40px"></i>
                            <h3 class="card-title">Easy Online Ordering</h3>
                            <p class="lead">Ordering your favorite dishes is just a few clicks away with our intuitive online ordering system.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card text-white text-center bg-dark pb-2">
                        <div class="card-body">
                            <i class="bi bi-truck" style="font-size: 40px"></i>
                            <h3 class="card-title">Fast Ordering</h3>
                            <p class="lead">No need to line up in the cashier just to order</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card text-white text-center bg-dark pb-2">
                        <div class="card-body">
                            <i class="bi bi-bag-heart-fill" style="font-size: 40px"></i>
                            <h3 class="card-title">Diverse Menu Options</h3>
                            <p class="lead">Explore our extensive menu featuring a wide variety of dishes to satisfy any craving.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="step" class="py-4">
        <div class="container">
            <h1 class="text-center mb-3 fw-semibold">Simple Steps to order</h1>
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <img src="image/step1.jpg" alt="Step 1" class="img-fluid c-img">
                </div>
                <div class="col-md-6">
                    <div class="caption">
                        <h2 class="text-center">Step 1</h2>
                        <h5 class="text-center">Choose your order</h5>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6 order-md-2">
                    <img src="image/step2.jpg" alt="Step 2" class="img-fluid c-img">
                </div>
                <div class="col-md-6 order-md-1">
                    <div class="caption">
                        <h2 class="text-center">Step 2</h2>
                        <h5 class="text-center">Wait for your order until it is ready</h5>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <img src="image/step3.jpg" alt="Step 3" class="img-fluid c-img">
                </div>
                <div class="col-md-6">
                    <div class="caption">
                        <h2 class="text-center">Step 3</h2>
                        <h5 class="text-center">Enjoy your Food</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php' ?>

    <script src="js/sweetalert2.js"></script>
    <script>
        <?php
            if(isset($_SESSION['login'])){
                echo "swal.fire({
                    icon: 'info',
                    title: 'Please login or sign up to continue',
                    showConfirmButton: false,
                    html: '<a class=\"btn btn-primary\" href=\"login.php\">Login</a>&nbsp;&nbsp;<a class=\"btn btn-success\" href=\"signup.php\">Sign Up</a>',
                });";
                unset($_SESSION['login']);
            }
        ?>
    </script>
</body>
</html>