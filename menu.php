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
    $showList = new Show($conn, 'list');
    $addList = new Add($conn, 'list');
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
                    $query = "UPDATE list SET quantity = '".$quantity."', sub_price = '".$sub_price."' WHERE cart_id = '$cart_id' AND product_id  = ". $_POST['product_id'];
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
</head>
<body>
    <?php include 'includes/header.php'; ?>

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
                            if($product_count < 3){
                                $category = $showCategory->showRecords("id = $product[2]");
                                echo "<div class='col-12 col-md-6 col-lg-4'>
                                        <form action='' method='post'>
                                            <div class='card'>
                                                <img class='card-img-top img' src='upload_img/".$product[4]."' alt='Card image cap' style='height: 300px; width: auto;'>
                                                <div class='card-body'>
                                                    <input type='hidden' name='product_id' value='".$product[0]."'>
                                                    <input type='hidden' name='price' value='".$product[3]."'>
                                                    <h5 class='card-title'>".$product[1]."</h5>
                                                    <h5 class='card-title text-muted'>".$category[0][1]."</h5>
                                                    <input type='number' name='quantity' value='1' min='1' class='form-control'>
                                                    <div class='d-flex justify-content-around my-2'>
                                                    <h3>P".$product[3]."</h3>
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
                    }
                } elseif (isset($_POST['cat'])) {
                    $products = $showProduct->showRecords("category_id = ".$_POST['category_id']);
                    if(count($products) > 0){
                        $product_count = 0;
                        foreach ($products as $product) {
                            if($product_count < 3){
                                $category = $showCategory->showRecords("id = $product[2]");
                                echo "<div class='col-12 col-md-6 col-lg-4'>
                                    <form action='form/cartHandle.php' method='post'>
                                        <div class='card'>
                                            <img class='card-img-top img' src='upload_img/".$product[4]."' alt='Card image cap' style='height: 300px; width: auto;'>
                                            <div class='card-body'>
                                                <h5 class='card-title'>".$product[1]."</h5>
                                                <h5 class='card-title text-muted'>".$category[0][1]."</h5>
                                                <input type='number' name='quantity' value='1' min='1' class='form-control'>
                                                <div class='d-flex justify-content-around my-2'>
                                                    <h3>P".$product[3]."</h3>
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
                        echo "<div class='alert alert-danger'>No food </div>'";
                    }
                } else {
                    $products = $showProduct->showRecords();
                    if(count($products) > 0){
                        $product_count = 0;
                        foreach ($products as $product) {
                            if($product_count < 3){
                                $category = $showCategory->showRecords("id = $product[2]");
                                echo "<div class='col-12 col-md-6 col-lg-4'>
                                        <form action='form/cartHandle.php' method='post'>
                                            <div class='card'>
                                                <img class='card-img-top img' src='upload_img/".$product[4]."' alt='Card image cap' style='height: 300px; width: auto;'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>".$product[1]."</h5>
                                                    <h5 class='card-title text-muted'>".$category[0][1]."</h5>
                                                    <input type='number' name='quantity' value='1' min='1' class='form-control'>
                                                    <div class='d-flex justify-content-around my-2'>
                                                        <h3>P".$product[3]."</h3>
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
                    }
                }
            ?>
            </div>
        </div>
    </section>

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