<?php
    require 'component/connection.php';
    require 'component/show.php';
    require 'component/update.php';
    require 'component/add.php';

    session_start();
    $_SESSION['link'] = "menu.php";

    $showProduct = new Show($conn, 'product');
    $showCategory = new Show($conn, 'category');
    $showCart = new Show($conn, 'cart');
    $showList = new Show($conn, 'lists');
    $addList = new Add($conn, 'lists');
    $addCart = new Add($conn, 'cart');

    if(isset($_POST['add_to_cart'])){
        if(!isset($_SESSION['customer_id'])){
            $_SESSION['login'] = true;
        } else {
            if(isset($_SESSION['cart_id'])){
                $cart_id = $_SESSION['cart_id'];
                $list = $showList->showRecords("cart_id = $cart_id AND product_id  = ". $_POST['product_id']);
                if(count($list) > 0){
                    $data =[];
                    $quantity = $_POST['quantity'];
                    $sub_price = $_POST['quantity'] * $_POST['price'];
                    $query = "UPDATE lists SET quantity = '".$quantity."', sub_price = '".$sub_price."' WHERE cart_id = '$cart_id' AND product_id  = ". $_POST['product_id'];
                    $result = $conn->query($query);
                    if($result){
                        $_SESSION['message'] = "Update product successfully";
                    }
                    $_SESSION['message'] = "Update product successfully";
                } else {
                    $data = [];
                    foreach ($_POST as $name => $value) {
                        if($name!="add_to_cart" && $name!="price")
                            $data[$name] = $value;
                    }
                    $data['sub_price'] = $_POST['quantity'] * $_POST['price'];
                    $data['cart_id'] = $_SESSION['cart_id'];
                    $action = $addList->addQuery($data);
                    if($action){
                        $_SESSION['message'] = "Added to cart Successfully";
                    } else {
                        echo "Error ";
                    }
                } 
            } else {
                $customer_id = $_SESSION['customer_id'];
                $data = [];
                $data['customer_id'] = $customer_id;
                $action = $addCart->addQuery($data); 
                if($action){
                    $cart = $showCart->showRecords("customer_id = $customer_id", "id DESC");
                    $_SESSION['cart_id'] = $cart[0][0]; 

                    $product = [];
                    foreach ($_POST as $name => $value) {
                        if($name!="add_to_cart" && $name!="price")
                            $product[$name] = $value;
                    }
                    $product['sub_price'] = $_POST['quantity'] * $_POST['price'];
                    $product['cart_id'] = $_SESSION['cart_id'];

                    $action = $addList->addQuery($product);
                    if($action){
                        $_SESSION['message'] = "Added to cart Succesfully";
                    } else {
                        echo "Error";
                    }
                }
            }
        }
    }

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
            height: 100%;
            object-fit: cover;
        }
        @media(max-width: 600px){
            #blog{
                display: none;
            }
        }
        .contact li .hover:hover{
            color: yellow;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section id="blog">
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner c-item">
                <div class="carousel-item active">
                    <img src="image/pizza-hero.jpg" class="d-block w-100 c-img" alt="...">
                    <div class="carousel-caption top-0 mt-4 d-none d-md-block">
                        <h5 class="mt-5 display-1 fw-bolder">50% Off All Pizzas</h5>
                        <p class="fs-3">Enjoy a 50% discount on all pizzas. Limited time offer!</p>
                        <p class="fs-2">Expires on: April 30, 2024</p>
                    </div>
                </div>
                <div class="carousel-item c-item">
                    <img src="image/dessert-hero.jpg" class="d-block w-100 c-img" alt="...">
                    <div class="carousel-caption top-0 mt-4 d-none d-md-block">
                        <h5 class="mt-5 display-1 fw-bolder">Free Dessert with Every Order</h5>
                        <p class="fs-3">Get a free dessert with every order above $20.</p>
                        <p class="fs-2">Expires on: May 15, 2024</p>
                    </div>
                </div>
                <div class="carousel-item c-item">
                    <img src="image/combo-hero.jpg" class="d-block w-100 c-img" alt="...">
                    <div class="carousel-caption top-0 mt-4 d-none d-md-block">
                        <h5 class="mt-5 display-1 fw-bolder">Combo Meal Deal</h5>
                        <p class="fs-3">Save big with our combo meal deal. Includes entree, side, and drink.</p>
                        <p class="fs-2">No expiry date</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section id="latest">
        <div class="container py-5">
            <div class="row">
                <h1 class="text-center">Our Menu</h1>
                <div class="col-12">
                    <div class="d-flex justify-content-center flex-md-row flex-column align-items-md-center">
                        <form action="" method="post">
                            <button type="submit" class="btn btn-outline" name="all">All</button>
                        </form>
                        <?php
                            $cats = $showCategory->showRecords();
                            if(count($cats) > 0){
                                foreach ($cats as $cat) {
                                    echo "<form method='post' class='d-flex'>";
                                    echo "<input type='hidden' name='category_id' value='".$cat[0]."'>";
                                    echo "<button type='submit' class='btn btn-outline' name='cat'>".$cat[1]."</button>";
                                    echo "</form>";
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>  
            <div class="row row-cols-1 row-cols-md-3 g-4 py-5">
            <?php
                if(isset($_POST['all'])){
                    $products = $showProduct->showRecords(null,"name ASC");
                    if(count($products) > 0){
                        $product_count = 0;
                        foreach ($products as $product) {
                            if($product_count < 4){
                                $category = $showCategory->showRecords("id = $product[2]");
                                echo "<div class='col-12 col-md-6 col-lg-4 col-xl-3'>
                                        <form action='' method='post'>
                                            <div class='card'>
                                                <img class='card-img-top img' src='upload_img/".$product[4]."' alt='Card image cap' style='height: 300px; width: auto;'>
                                                <div class='card-body'>
                                                    <input type='hidden' name='product_id' value='".$product[0]."'>
                                                    <input type='hidden' name='price' value='".$product[3]."'>
                                                    <h5 class='card-title'>".$product[1]."</h5>
                                                    <h5 class='card-title text-muted'>".$category[0][1]."</h5>
                                                    <div class='d-flex justify-content-around'>
                                                    <div class='qty'>
                                                    <input type='number' name='quantity' value='1' min='1' class='form-control'>
                                                    </div>
                                                    <div class='price'>
                                                    <h3>P".$product[3]."</h3>
                                                    </div>
                                                    </div>
                                                    <div class='d-flex justify-content-around my-2'>
                                                    <a href='view_product.php?pid=".$product[0]."' class='btn btn-warning'>View</a>
                                                    <button type='submit' class='btn btn-primary' name='add_to_cart'><i class='bi bi-cart'></i></button>
                                                    </div>
                                                </div>             
                                            </div>
                                        </form>
                                </div>";
                            } else {
                                $product_count = 0;
                                echo "</><div class='row row-cols-1 row-cols-md-3 g-4 py-5'>";
                            }
                            
                        }
                    } else {
                        echo "
                            <div class='container text-center py-5'>
                                <h5 class='alert alert-danger'>No food available</h5>
                            </div>";
                    }
                } elseif (isset($_POST['cat'])) {
                    $products = $showProduct->showRecords("category_id = ".$_POST['category_id']);
                    if(count($products) > 0){
                        $product_count = 0;
                        foreach ($products as $product) {
                            if($product_count < 4){
                                $category = $showCategory->showRecords("id = $product[2]");
                                echo "<div class='col-12 col-md-6 col-lg-4 col-xl-3'>
                                    <form action='' method='post'>
                                        <div class='card'>
                                            <img class='card-img-top img' src='upload_img/".$product[4]."' alt='Card image cap' style='height: 300px; width: auto;'>
                                            <div class='card-body'>
                                                <h5 class='card-title'>".$product[1]."</h5>
                                                <h5 class='card-title text-muted'>".$category[0][1]."</h5>
                                                <div class='d-flex justify-content-around'>
                                                    <div class='qty'>
                                                    <input type='number' name='quantity' value='1' min='1' class='form-control'>
                                                    </div>
                                                    <div class='price'>
                                                    <h3>P".$product[3]."</h3>
                                                    </div>
                                                    </div>
                                                <div class='d-flex justify-content-around my-2'>
                                                    <a href='view_product.php?pid=".$product[0]."' class='btn btn-warning'>View</a>
                                                    <button type='submit' class='btn btn-primary' name='add_to_cart'><i class='bi bi-cart'></i></button>
                                                    <input type='hidden' name='product_id' value='".$product[0]."'>
                                                    <input type='hidden' name='price' value='".$product[3]."'>
                                                </div>
                                            </div>             
                                        </div>
                                    </form>
                                </div>";
                                $product_count++;
                            } else {
                                
                            }
                        }
                    } else {
                        echo "
                        <div class='container text-center py-5'>
                            <h5 class='alert alert-danger'>No food available in this category</h5>
                        </div>";
                    }
                } elseif (isset($_GET['cat_id'])) {
                    $products = $showProduct->showRecords("category_id = ".$_GET['cat_id']);
                    if(count($products) > 0){
                        $product_count = 0;
                        foreach ($products as $product) {
                            if($product_count < 4){
                                $category = $showCategory->showRecords("id = $product[2]");
                                echo "<div class='col-12 col-md-6 col-lg-4 col-xl-3'>
                                    <form action='' method='post'>
                                        <div class='card'>
                                            <img class='card-img-top img' src='upload_img/".$product[4]."' alt='Card image cap' style='height: 300px; width: auto;'>
                                            <div class='card-body'>
                                                <h5 class='card-title'>".$product[1]."</h5>
                                                <h5 class='card-title text-muted'>".$category[0][1]."</h5>
                                                <div class='d-flex justify-content-around'>
                                                <div class='qty'>
                                                <input type='number' name='quantity' value='1' min='1' class='form-control'>
                                                </div>
                                                <div class='price>
                                                <h3>P".$product[3]."</h3>
                                                </div>
                                                </div>
                                                <div class='d-flex justify-content-around my-2'>
                                                    <a href='view_product.php?pid=".$product[0]."' class='btn btn-warning'>View</a>
                                                    <button type='submit' class='btn btn-primary' name='add_to_cart'><i class='bi bi-cart'></i></button>
                                                    <input type='hidden' name='product_id' value='".$product[0]."'>
                                                    <input type='hidden' name='price' value='".$product[3]."'>
                                                </div>
                                            </div>             
                                        </div>
                                    </form>
                                </div>";
                                $product_count++;
                            } else {
                                
                            }
                        }
                    } else {
                        echo "
                        <div class='container text-center py-5'>
                            <h5 class='alert alert-danger'>No food available in this category</h5>
                        </div>";
                    }
                } else {
                    $products = $showProduct->showRecords();
                    if(count($products) > 0){
                        $product_count = 0;
                        foreach ($products as $product) {
                            if($product_count < 4){
                                $category = $showCategory->showRecords("id = $product[2]");
                                echo "<div class='col-12 col-md-6 col-lg-4 col-xl-3'>
                                        <form action='' method='post'>
                                            <div class='card'>
                                                <img class='card-img-top img' src='upload_img/".$product[4]."' alt='Card image cap' style='height: 300px; width: auto;'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>".$product[1]."</h5>
                                                    <h5 class='card-title text-muted'>".$category[0][1]."</h5>
                                                    <div class='d-flex justify-content-around'>
                                                    <div class='qty'>
                                                    <input type='number' name='quantity' value='1' min='1' class='form-control'>
                                                    </div>
                                                    <div class='price'>
                                                    <h3>P".$product[3]."</h3>
                                                    </div>
                                                    </div>
                                                    <div class='d-flex justify-content-around my-2'>
                                                        <a href='view_product.php?pid=".$product[0]."' class='btn btn-warning'>View</a>
                                                        <button type='submit' class='btn btn-primary' name='add_to_cart'><i class='bi bi-cart'></i></button>
                                                        <input type='hidden' name='product_id' value='".$product[0]."'>
                                                        <input type='hidden' name='price' value='".$product[3]."'>
                                                    </div>
                                                </div>             
                                            </div>
                                        </form>
                                </div>";
                            } else {
                                $product_count = 0;
                                echo "</><div class='row row-cols-1 row-cols-md-3 g-4 py-5'>";
                            }
                            
                        }
                    } else {
                        echo "
                        <div class='container text-center py-5'>
                            <h5 class='alert alert-danger'>No food available</h5>
                        </div>";
                    }
                }
            ?>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php' ?>

    <script src="js/sweetalert2.js"></script>
    <script src="js/sweetalert.js"></script>
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
</body>
</html>