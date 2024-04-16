<?php
    session_start();

    $_SESSION['link'] = "index.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Ordering System</title>
    <link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.css"> 
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'includes/header.php' ?>

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
                            <h3 class="card-title">Fast Delivery</h3>
                            <p class="lead">Enjoy speedy delivery right to your doorstep, so you can savor your meal without waiting too long.</p>
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
    <section class="special-offers">
        <div class="container">
          <h2 class="text-center mb-4">Special Offers</h2>
          <div class="row">
            <div class="'col-12 col-md-6 col-lg-4">
              <div class="offer-card bg-warning">
                <h3 class="offer-title">50% Off All Pizzas</h3>
                <p class="offer-description">Enjoy a 50% discount on all pizzas. Limited time offer!</p>
                <p class="offer-expiry">Expires on: April 30, 2024</p>
              </div>
            </div>
            <div class="'col-12 col-md-6 col-lg-4">
              <div class="offer-card bg-warning">
                <h3 class="offer-title">Free Dessert with Every Order</h3>
                <p class="offer-description">Get a free dessert with every order above $20.</p>
                <p class="offer-expiry">Expires on: May 15, 2024</p>
              </div>
            </div>
            <div class="'col-12 col-md-6 col-lg-4">
              <div class="offer-card bg-warning">
                <h3 class="offer-title">Combo Meal Deal</h3>
                <p class="offer-description">Save big with our combo meal deal. Includes entree, side, and drink.</p>
                <p class="offer-expiry">No expiry date</p>
              </div>
            </div>
          </div>
        </div>
    </section>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
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