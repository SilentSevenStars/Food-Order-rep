<?php
    session_start();

    if(!isset($_SESSION['admin'])){
        header("Location: ../form/login.php");
    }
    require '../component/connection.php';
    require '../component/show.php';
    require '../component/delete.php';
    require '../component/update.php';
    require '../component/add.php';

    $showOrder = new Show($conn, 'orders');
    $showCart = new Show($conn, 'cart');
    $showCustomer = new Show($conn, 'customer');
    $showList = new Show($conn, 'lists');
    $showProduct = new Show($conn, 'product');

    if(isset($_POST['update'])){
        $id = $_POST['order_id'];
        $payment_status = $_POST['payment_status'];
        $service = $_POST['service'];

        $sql = "UPDATE orders SET payment_status = '$payment_status', service='$service' WHERE id = '$id'";
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
                    <div class="row">
                        <h4 class="text-center">Order Details</h4>
                        <div class="col-12">
                            <div class="d-flex justify-content-center flex-md-row flex-column align-items-md-center">
                                <form action="" method="post">
                                    <input type="hidden" name="services" value="Ongoing">
                                    <button type="submit" name="serv" class="btn btn-outline">Ongoing</button>
                                </form>
                                <form action="" method="post">
                                    <input type="hidden" name="services" value="Ready">
                                    <button type="submit" name="serv" class="btn btn-outline">Ready</button>
                                </form>
                                <form action="" method="post">
                                    <input type="hidden" name="services" value="Complete">
                                    <button type="submit" name="serv" class="btn btn-outline">Complete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                            if(isset($_POST['serv'])){
                                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                                $paginationData = $showOrder->showRecordsWithPagination($currentPage, "service='".$_POST['services']."'",3, "id DESC");
                                $orders = $paginationData['records'];
                                if(count($orders) > 0){
                                    foreach ($orders as $order) {
                                        $carts = $showCart->showRecords("id = $order[1]");
                                        if(count($carts) > 0){
                                            $customer = $showCustomer->showRecords("id = ".$carts[0][1]);
                                            if(count($customer) > 0){
                        ?>
                        <div class="card card-1">
                            <div class="card-header">
                                <div class="media flex-sm-row flex-column-reverse justify-content-between">
                                    <div class="col my-auto">
                                        <h4 class="mb-0">Order<span class="change-color">#<?= $order[0] ?></span></h4>
                                        <h4 class='mb-0'>Name: <?= $customer[0][1] ?></h4>
                                        <h4 class='mb-0'>Phone Number: <?= $customer[0][3] ?></h4>
                                        <h4 class='mb-0'>Email: <?= $customer[0][2] ?></h4>
                                        <h4 class='mb-0'>Address: <?= $customer[0][4] ?></h4>
                                        <h4 class='mb-0'>Payment Method: <?= $order[2] ?></h4>
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
                                    $lists = $showList->showRecords("cart_id = ".$carts[0][0]);
                                    if(count($lists) > 0){
                                        foreach ($lists as $list) { 
                                            $product = $showProduct->showRecords("id = $list[1]");
                                ?>
                                <div class="row">
                                    <div class="col">
                                        <div class="card card-2">
                                            <div class="card-body">
                                                <div class="media">
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
                                <div class="mb-3">
                                    <h4>Total Amount: &#8369;<?= $order[3] ?></h4>
                                </div>
                                <form action="" method="post">
                                    <input type="hidden" name="order_id" value="<?= $order[0] ?>">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Payment status</label>
                                        <select name="payment_status" id="" class="form-select">
                                            <?php
                                                echo "<option value='".$order[5]."' selected>".$order[5]."</option>";
                                                if($order[5] === 'Ongoing')
                                                    echo "<option value='Complete'>Complete</option>";
                                                else 
                                                    echo "<option value='Ongoing'>Ongoing</option>";
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Service</label>
                                        <select name="service" id="" class="form-select">
                                            <?php
                                                echo "<option value='".$order[6]."' selected>".$order[6]."</option>";
                                                if($order[6] != 'Ongoing'){
                                                    echo "<option value='Ongoing'>Ongoing</option>";
                                                }
                                                if($order[6] != "Ready"){
                                                    echo "<option value='Ready'>Ready</option>";
                                                }    
                                                if($order[6] != "Complete"){
                                                    echo "<option value='Complete'>Complete</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                        <?php
                                            }
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
                    <?php
                        }
                    ?>
                    
                </div>
            </main>
        </div>
    </div>


    <script src="../js/script.js"></script>
</body>

</html>