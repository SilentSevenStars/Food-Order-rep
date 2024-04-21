<?php
    require 'component/connection.php';
    require 'component/show.php';
    require 'component/update.php';
    require 'component/add.php';

    session_start();
    $_SESSION['link'] = "index.php";

    $pid = $_GET['pid'] ?? NULL;
    if(!isset($_GET['pid']))
        header("Location: index.php");

    $showProduct = new Show($conn, 'product');
    $showCategory = new Show($conn, 'category');
    $showCart = new Show($conn, 'cart');
    $showList = new Show($conn, 'lists');
    $addList = new Add($conn, 'lists');
    $addCart = new Add($conn, 'cart');

    if(isset($_POST['add_to_cart'])){
        // Your logic for adding to cart
    }

    // Fetch product details
    $product = $showProduct->showRecords("id = $pid");
    if(count($product) > 0){
        $category = $showCategory->showRecords("id = ".$product[0][2]);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Ordering System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Your styles here */
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section id="details">
        <div class="container py-4">
            <div class="card">
                <div class="card-body">
                    <?php if(count($product) > 0 && count($category) > 0): ?>
                        <form method='post'>
                            <div class="row justify-content-center">
                                <div class='col-md-6'>
                                    <img src='upload_img/<?php echo $product[0][4]; ?>' class='img-fluid'>
                                </div>
                                <div class='col-md-6'>
                                    <input type='hidden' name='product_id' value='<?php echo $product[0][0]; ?>'>
                                    <input type='hidden' name='price' value='<?php echo $product[0][3]; ?>'>
                                    <h5 class='card-title'><?php echo $product[0][1]; ?></h5>
                                    <p><?php echo $category[0][1]; ?></p>
                                    <p>Price: <?php echo $product[0][3]; ?></p>
                                    <p>Quantity: <input type='number' name='quantity' value='1' min='1' class='form-control'></p>
                                    <button type='submit' class='btn btn-primary' name='add_to_cart'><i class='bi bi-cart'></i> Add to Cart</button>
                                </div>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class='col-md-12'>
                            This Food isn't Available
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Ratings</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-center">Average Rating: 4.5</p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <span class="text-warning">&#9733;</span>
                                <span class="text-warning">&#9733;</span>
                                <span class="text-warning">&#9733;</span>
                                <span class="text-warning">&#9733;</span>
                                <span class="text-muted">&#9733;</span>
                            </p>
                            <p>
                                <span class="text-warning">&#9733;</span>
                                <span class="text-warning">&#9733;</span>
                                <span class="text-warning">&#9733;</span>
                                <span class="text-warning">&#9733;</span>
                            </p>
                            <p>
                                <span class="text-warning">&#9733;</span>
                                <span class="text-warning">&#9733;</span>
                                <span class="text-warning">&#9733;</span>
                            </p>
                            <p>
                                <span class="text-warning">&#9733;</span>
                                <span class="text-warning">&#9733;</span>
                            </p>
                            <p>
                                <span class="text-warning">&#9733;</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="rating">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h5>View Reviews</h5>
                        </div>
                        <div class="col-md-3">
                            <div class="btn btn-primary">Add reviews</div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="media">
                        <img src="user_avatar.jpg" class="mr-3 rounded-circle" alt="User Avatar" style="width: 64px;">
                        <div class="media-body">
                            <h5 class="mt-0">User Name</h5>
                            Details of the review go here.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php' ?>

    <script src="js/sweetalert2.js"></script>
    <script src="js/sweetalert.js"></script>
    <script>
        <?php
            if(isset($_SESSION['message'])){
                echo "swal({
                    title: '".$_SESSION['message']."',
                    icon: 'success',
                    button: 'Okay',
                  });";
                unset($_SESSION['message']);
            }
        ?>
    </script>
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