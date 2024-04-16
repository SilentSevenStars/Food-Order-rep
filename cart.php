<?php
    require 'component/connection.php';
    require 'component/delete.php';
    require 'component/update.php';
    require 'component/show.php';

    session_start();

    $showList = new Show($conn, 'list');
    $showProduct = new Show($conn, 'product');

    if(!isset($_SESSION['customer_id'])){
        $_SESSION['login']  = true;
        header("Location: ".$_SESSION['link']);
    }

    if(isset($_POST['update'])){
        $quantity = $_POST['quantity'];
        $product_price = $_POST['product_price'];
        $cart_id = $_SESSION['cart_id'];
        $product_id = $_POST['product_id'];
        $sub_price = $product_price *  $quantity;

        $query = "UPDATE list SET quantity = ".$quantity.", sub_price = ".$sub_price." WHERE cart_id = '".$cart_id."' AND product_id = '".$product_id."'";
        $result = $conn->query($query);

    }
    if(isset($_POST['delete'])){
        $cart_id = $_SESSION['cart_id'];
        $product_id = $_POST['product_id'];

        $query = "DELETE FROM list WHERE cart_id = '".$cart_id."' AND product_id = '".$product_id."'";
        $result = $conn->query($query);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'includes/header.php' ?>
    
    <section id="cart">
        <div class="container">
            <h1 class="text-center fw-bold display-1">Cart</h1>
            <div class="row">
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="bg-dark">
                                    <th>Food</th>
                                    <th>Quantity</th>
                                    <th>Price per item</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $total = 0;
                                    if(isset($_SESSION['cart_id'])){
                                        $data = $showList->showRecords("cart_id = ".$_SESSION['cart_id']);
                                        if(count($data) > 0){
                                            foreach ($data as $i) {
                                                echo "<tr>";
                                                echo "<form method='post'>";
                                                echo "<td>";
                                                $product = $showProduct->showRecords("id = ".$i[1]);
                                                if(count($product) > 0){
                                                    echo "<img src='upload_img/".$product[0][4]."' class='img-fluid' style='width: 50px; height: 50px; object-fit: contain;'>";
                                                    echo $product[0][1];
                                                } else {
                                                    echo "This product doesn't exist";
                                                }
                                                echo "</td>";
                                                echo "<td>
                                                        <div class='d-flex flex-md-row flex-column'> 
                                                            <input type='hidden' name='product_price' value='".$product[0][3]."'>
                                                            <input type='hidden' name='product_id' value='".$i[1]."'>
                                                            <input type='number' name='quantity' min='1' value='".$i[2]."' class='form-control'>
                                                            <button type='submit' name='update' class='btn btn-primary'>Update</button>
                                                        </div> <!-- Corrected closing tag -->
                                                    </td>";
                                                echo "<td>$".$product[0][3]."</td>";
                                                echo "<td>
                                                            <input type='hidden' name='product_id' value='".$i[1]."'>
                                                            <button type='submit' name='delete' class='btn btn-danger'>Delete</button>
                                                    </td>";
                                                echo "</form>";
                                                echo "</tr>";
                                                $total += $i[3];
                                            }
                                        } else {
                                            echo "<tr><td colspan='5' class='text-center'>No items in the cart</td></tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>No items in the cart</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="cartd-title">Checkout</h4>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Total: P<?= $total ?></h4>
                        </div>
                        <div class="card-footer">
                            <a href="checkout.php" class="btn btn-danger">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>