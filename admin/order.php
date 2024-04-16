<?php
    require '../component/connection.php';
    require '../component/show.php';
    require '../component/delete.php';
    require '../component/update.php';
    require '../component/add.php';

    $showOrder = new Show($conn, 'orders');
    $showCart = new Show($conn, 'cart');
    $showCustomer = new Show($conn, 'customer');
    $showList = new Show($conn, '`list`');
    $showProduct = new Show($conn, 'product');

    if(isset($_POST['update'])){
        $id = $_POST['order_id'];
        $payment_status = $_POST['payment_status'];

        $sql = "UPDATE orders SET payment_status = '$payment_status' WHERE id = '$id'";
        $conn->query($sql);
    }
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Admin Dashboard</title>
    <!-- bootstrap link  -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body data-bs-theme="light">
    <div class="wrapper">
        <?php include '../includes/adminHeader.php' ?>

        </aside>
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h4>Order Details</h4>
                    </div>
                    
                    <div class="row">
                        <?php
                            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                            $paginationData = $showOrder->showRecordsWithPagination($currentPage, 6, "id DESC");
                            $orders = $paginationData['records'];
                            if(count($orders) > 0){
                                $order_count = 0;
                                foreach ($orders as $order) {
                                    $cart = $showCart->showRecords("id = $order[1]");
                                    $customer = $showCustomer->showRecords("id = ".$cart[0][1]);;
                                    if($order_count < 6){
                                        echo "<div class='col-lg-4 col-md-6'>";
                                        echo "<form method='post'>";
                                        echo "<input type='hidden' name='order_id' value='$order[0]'>";
                                        echo "<div class='card border-0'>";
                                        echo "<div class='card-header'>";
                                        echo "<h5 class='card-title'>".$order[0]."</h5>";
                                        echo "";
                                        echo "</div>";
                                        echo "<div class='card-body'>";
                                        echo "<h5 class='card-title'>Name: ".$customer[0][1]."</h5>";
                                        echo "<h5 class='card-title'>Phone Number: ".$customer[0][3]."</h5>";
                                        echo "<h5 class='card-title'>Email: ".$customer[0][2]."</h5>";
                                        echo "<h5 class='card-title'>Address: ".$customer[0][4]."</h5>";
                                        echo "<h5 class='card-title'>Payment Method: ".$order[2]."</h5>";
                                        echo "<h5 class='card-title'>Product items:</h5>";
                                        echo "<div>";
                                        $lists = $showList->showRecords("cart_id = ".$cart[0][0]); 
                                        if(count($lists) > 0){
                                            $list_count = 0;
                                            foreach ($lists as $list) {
                                                echo "<div class='row'>"; 
                                                $product = $showProduct->showRecords("id = $list[1]");
                                                echo  "<h6>".$product[0][1]."</h6>";
                                                echo "</div><div class='col'>";
                                                echo  "<h6>Quantity: ".$list[2]."</h6>";
                                                echo "</div> <div class='col'>";
                                                echo  "<h6>Total Price: ".$list[3]."</h6>";
                                                echo "</div>";
                                            }
                                        }
                                        echo "</div>";
                                        echo "<h4 class='card-title'>Total Price: ".$order[3]."</h4>";
                                        echo "<label class='form-label'>Payment Status</label>";
                                        echo "<select name='payment_status' class='form-select'>";
                                        echo "<option value='".$order[5]."' selected>".$order[5]."</option>";
                                        if($order != "Complete")
                                            echo "<option value='Complete'>Complete</option>";
                                        else 
                                            echo "<option value='Not completed'>Not completed</option>";
                                        echo "</select>";
                                        echo "</div>";
                                        echo "<div class='card-footer'>";
                                        echo "<input type='submit' class='btn btn-primary' value='Submit' name='update'>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</form>";
                                        echo "</div>";
                                        $order_count++;
                                    }
                                }
                            }
                        ?>
                    </div>
                    <nav class="d-flex justify-content-center" aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?=($currentPage - 1)?>">Previous</a>
                            </li>
                            <?php endif; ?>
                            <?php for ($page = 1; $page <= $paginationData['totalPages']; $page++): ?>
                            <li class="page-item"><a class="page-link" href="?page=<?=$page?>"><?=$page?></a></li>
                            <?php endfor; ?>
                            <?php if ($currentPage < $paginationData['totalPages']): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?=($currentPage + 1)?>">Next</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </main>
        </div>
    </div>

    <script src="../js/script.js"></script>
</body>

</html>