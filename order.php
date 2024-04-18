<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
    require 'component/connection.php';
    require 'component/add.php';
    require 'component/show.php';

    if(!isset($_SESSION['customer_id'])){
        if(isset($_SESSION['link'])){
            $_SESSION['login'] = true;
            header("Location: ".$_SESSION['link']);
        } else {
            $_SESSION['login'] = true;
            header("Location: index.php");
        }
        
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
                ?>
                <div class="card card-1">
                    <div class="card-header bg-white">
                        <div class="media flex-sm-row flex-column-reverse justify-content-between">
                            <div class="col my-auto">
                                <h4 class="mb-0">Order<span class="change-color">#<?= $order[0] ?></span></h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-between mb-3">
                            <div class="col-auto">
                                <h6 class="color-1 mb-0 change-color">Receipt</h6>
                            </div>
                        </div>
                        <?php
                        $lists = $showList->showRecords("cart_id = $cart[0]");
                        if(count($lists) > 0){
                            foreach ($lists as $list) { 
                                $product = $showProduct->showRecords("id = $list[1]");
                        ?>
                        <div class="row">
                            <div class="col">
                                <div class="card card-2">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="sq align-self-center">
                                                <img class="img-fluid  my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0" src="upload_img/<?= $product[0][4] ?>" width="135" height="135" />
                                            </div>
                                            <div class="media-body my-auto text-right">
                                                <div class="row  my-auto flex-column flex-md-row">
                                                    <div class="col my-auto">
                                                        <h6 class="mb-0"><?= $product[0][1] ?></h6>
                                                    </div>
                                                    <div class="col my-auto">
                                                        <p style="font-size: 20px;">Price per item : <?= $product[0][3] ?></p>
                                                    </div>
                                                    <div class="col my-auto">
                                                        <p style="font-size: 20px;">Quantity : <?= $list[2] ?></p>
                                                    </div>
                                                    <div class="col my-auto">
                                                        <h6 class="mb-0" style="font-size: 20px;">&#8369;<?= $list[3] ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <hr class="my-3 ">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <h4>Track Order <span></span></h4>
                        </div>
                        <div class="col mt-auto">
                            <div>
                                <h4>Total Amount: &#8369;<?= $order[3] ?></h4>
                            </div>
                            <div class="media row justify-content-between ">
                                <div class="col-auto text-right">
                                    <span><small class="text-right mr-sm-2"></small></span>
                                </div>
                                <div class="flex-col">
                                    <span><small class="text-right mr-sm-2">Out for delivery</small></span>
                                </div>
                                <div class="col-auto flex-col-auto">
                                    <small class="text-right mr-sm-2">Delivered</small><span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                            }
                        }
                    }
                } else {
                    echo "This order has been remove";
                }
                ?>
            </div>
        </div>
    </section>
    
</body>
</html>
