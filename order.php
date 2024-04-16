<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
    require 'component/connection.php';
    require 'component/add.php';
    require 'component/show.php';

    if(!isset($_SESSION['customer_id'])){
        $_SESSION['login'] = true;
        header("Location: ".$_SESSION['link']);
        exit; 
    }

    unset($_SESSION['cart_id']);
    $showCart = new Show($conn, 'cart');
    $showCustomer = new Show($conn, 'customer');
    $showProduct = new Show($conn, 'product');
    $showList = new Show($conn, '`list`');
    $showOrder = new Show($conn, 'orders');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/sweetalert.js"></script>
</head>
<body>
    <?php require 'includes/header.php'; ?>

    <section id="order">
        <div class="container">
            <div class="row">
                <h1 class="text-center">Order</h1>
            </div>
            <div class="row row-cols-1 rows-cols-md-3 g-4 py-5">
                <?php
                    $carts = $showCart->showRecords("customer_id = ".$_SESSION['customer_id'], "id DESC");
                    $customer = $showCustomer->showRecords("id = ".$_SESSION['customer_id']);
                    if(count($carts) > 0){
                        foreach ($carts as $cart) {
                            $orders = $showOrder->showRecords("cart_id = $cart[0]");
                            if(count($orders) > 0){
                                foreach ($orders as $order) {
                                    echo "<div class='card' style='border-radius: 15px;'>";
                                    echo "<div class='card-header'>";
                                    echo "<div class='row'>";
                                    echo "<div class='col-lg-6 col-12'>";
                                    echo "<h3>Order: ".$order[0]."</h3>";
                                    echo "</div>";
                                    echo "<div class='col-lg-6 col-12'>";
                                    echo "<h3>Payment Status: ".$order[5]."</h3>";
                                    echo "</div>";
                                    echo "</div>"; 
                                    echo "</div>"; 
                                    echo "<div class='card-body'>";
                                    echo "<h4 class='card-title text-center'>Product items:</h4>";
                                    echo "<div class='row'>";
                                    $lists = $showList->showRecords("cart_id = $cart[0]"); 
                                    if(count($lists) > 0){
                                        foreach ($lists as $list) { 
                                            echo "<div class='col-md-4'>";
                                            $product = $showProduct->showRecords("id = $list[1]");
                                            echo  "<h4>".$product[0][1]."</h4>";
                                            echo  "<p>Quantity: ".$list[2]."</p>";
                                            echo  "<p>Total Price: ".$list[3]."</p>";
                                            echo "</div>";
                                        }
                                    }
                                    echo "</div>"; // Close row
                                    echo "<h4 class='card-title'>Total Price: ".$order[3]."</h4>";
                                    echo "<h4 class='card-title'>Place on: ".$order[4]."</h4>";
                                    echo "</div>"; // Close card-body
                                    echo "</div>"; // Close card
                                }
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </section>
</body>
</html>
