<?php
    require 'component/connection.php';
    require 'component/show.php';
    require 'component/update.php';
    require 'component/add.php';

    if(!isset($_GET['pid']))
        header("Location: menu.php");
    $pid = $_GET['pid'] ?? NULL;

    session_start();
    $_SESSION['link'] = "view_product.php?pid=$pid";

    $showProduct = new Show($conn, 'product');
    $showCategory = new Show($conn, 'category');
    $showCustomer = new Show($conn, 'customer');
    $showCart = new Show($conn, 'cart');
    $showList = new Show($conn, 'lists');
    $showReview = new Show($conn, 'reviews');
    $addList = new Add($conn, 'lists');
    $addCart = new Add($conn, 'cart');

    

    if(isset($_POST['add_to_cart'])){
        if(!isset($_SESSION['customer_id'])){
            $_SESSION['login'] = true;
        } else {
            if(isset($_SESSION['cart_id'])){
                $cart_id = $_SESSION['cart_id'];
                $list = $showList->showRecords("cart_id = $cart_id AND product_id  = ".$pid);
                if(count($list) > 0){
                    $data =[];
                    $quantity = $_POST['quantity'];
                    $sub_price = $_POST['quantity'] * $_POST['price'];
                    $query = "UPDATE lists SET quantity = '".$quantity."', sub_price = '".$sub_price."' WHERE cart_id = '$cart_id' AND product_id  = ".$pid;
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
                    $data['product_id'] = $pid;
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
                    $product['product_id'] = $pid;
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
  <title>Food View</title>
  <link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>

  <?php include 'includes/header.php' ?>

  <section id="details" class="mb-1">
    <div class="container mt-4">
        <div class="card">
            <?php
                $product = $showProduct->showRecords("id = $pid");
                if(count($product) > 0){
            ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="upload_img/<?= $product[0][4] ?>" alt="Food" class="img-fluid">
                    </div>
                    <div class="col-md-6 justify-content-center">
                        <form action="" method="post">
                            <input type="hidden" name="product_id" value="<?= $pid ?>">
                            <h2><?= $product[0][1] ?></h2>
                            <?php
                                $category = $showCategory->showRecords("id = ".$product[0][2]);
                                if(count($category) > 0){
                            ?>
                            <p><?= $category[0][1] ?></p>
                            <?php } else { ?>
                            <p>None</p>
                            <?php } ?>
                            <div class="row">
                                <div class="col-6">
                                    <p>Quantity: <input type="number" value="1" name="quantity"></p>
                                </div>
                                <div class="col-6">
                                    <p>Price: <?= $product[0][3] ?></p>
                                    <input type="hidden" name="price" value="<?= $product[0][3] ?>" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" name="add_to_cart">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Ratings</h2>
            </div>
            <?php
                $reviews = $showReview->showRecords("product_id = ".$pid);
                if(count($reviews) > 0){
                    $total_ratings = 0;
                    $rating_1 = 0;
                    $rating_2 = 0;
                    $rating_3 = 0;
                    $rating_4 = 0;
                    $rating_5 = 0;
                    foreach ($reviews as $review){
                        $total_ratings += $review[1];
                        if($review[1] == 1){
                            $rating_1 += 1;
                         }
                         if($review[1] == 2){
                            $rating_2 += 1;
                         }
                         if($review[1] == 3){
                            $rating_3 += 1;
                         }
                         if($review[1] == 4){
                            $rating_4 += 1;
                         }
                         if($review[1] == 5){
                            $rating_5 += 1;
                         }
                    }
                        $average = round($total_ratings / count($reviews), 1);
            ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-center">Average Rating: <?= $average ?></p>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li style="list-style: none;">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <span><?= $rating_5 ?></span>
                            </li>
                            <li style="list-style: none;">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <span><?= $rating_4 ?></span>
                            </li>
                            <li style="list-style: none;">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <span><?= $rating_3 ?></span>
                            </li>
                            <li style="list-style: none;">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <span><?= $rating_2 ?></span>
                            </li>
                            <li style="list-style: none;">
                                <i class="bi bi-star-fill text-warning"></i>
                                <span><?= $rating_1 ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php } else { ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger text-center">No reviews</div>
                        </div>
                    </div>
                </div>
                <?php } ?>
        </div>
    </div>
  </section>

  <section id="review" class="mb-3">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-9">
                        <h5>View Reviews</h5>
                    </div>
                    <div class="col-md-3">
                        <a href="form/add_review.php?pid=<?= $pid ?>" class="btn btn-primary">Add reviews</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php
                    $reviews = $showReview->showRecords(null, "id DESC", 10);
                    if(count($reviews) > 0){
                        foreach ($reviews as $review){
                            $customer = $showCustomer->showRecords("id = $review[5]");
                ?>
                <div class="media">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                                if(count($customer) > 0){
                                    echo $customer[0][1];
                                } else {
                                    echo "Anonymous";
                                }
                            ?>
                        </div>
                        <div class="col-md-6">
                            <i class="bi bi-star-fill text-warning"></i><?= $review[1] ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h4><?= $review[2] ?></h4>
                        </div>
                        <div class="col">
                            <p><?= $review[3] ?></p>
                        </div>
                    </div>
                </div>
                <?php  
                        }
                    } else {
                        // No reviews section
                        echo "<div class='alert alert-danger text-center'>No reviews available</div>";
                    }
                ?>
            </div>
        </div>
    </div>
  </section>
  <?php } else { ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger text-center">This food isn't available</div>
            </div>
        </div>
    <?php } ?>

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