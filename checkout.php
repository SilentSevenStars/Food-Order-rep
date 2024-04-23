<?php
    date_default_timezone_set('Asia/Manila');
    require 'component/connection.php';
    require 'component/add.php';
    require 'component/show.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    session_start();
    $showCart = new Show($conn, 'cart');
    $showCustomer = new Show($conn, 'customer');
    $showProduct = new Show($conn, 'product');
    $showList = new Show($conn, 'lists');

    $add = new Add($conn, 'orders');

    if(isset($_POST['order'])){
        if($_POST['payment_method'] !== "none"){
            $data = [];
            foreach ($_POST as $name => $value) {
                if($name!="order")
                    $data[$name] = $value;
            }
            $data['cart_id'] = $_SESSION['cart_id'];
            $data['payment_status'] = 'Ongoing';
            $data['service'] = 'Ongoing';
            try {
                $action = $add->addQuery($data);
                
                $data = $showCart->showRecords("id = ".$_SESSION['cart_id']);
                    if(count($data) > 0){
                        $user_id = $data[0][1];
                        $customer = $showCustomer->showRecords("id = $user_id");
                        $name = $customer[0][1];
                        $email = $customer[0][2];
                        $address = $customer[0][4];
                        $cart_id = $_SESSION["cart_id"];
                            

                $subject = "Food Order Confirmation";
                $message = "Your order has been made. <br><br>";
                $lists = $showList->showRecords("cart_id = ".$_SESSION['cart_id']);
                    if(count($lists) > 0){
                        $total_price = 0;
                        foreach ($lists as $list) {
                            $products = $showProduct->showRecords("id = ".$list[1]);
                            if(count($products) > 0){
                                foreach ($products as $product) {
                                    $message .= "(".$list[2].")  ".$product[1]."  = Php".$list[3]."<br>";
                                    $total_price += $list[3];
                                                            }
                                                    }
                                            }
                        $message .= "<br>Total Payment: ".$total_price."<br><br>
                                    Recipient Name: $name<br>
                                    Address: $address<br>";

                                    }
                            }
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->SMTPAuth = true;

                $mail->Host = "smtp.gmail.com";
                $mail->SMTPSecure = "ssl";
                $mail->Port = 465;
                $mail->Username = "kentjustine.mercado@clsu2.edu.ph";
                $mail->Password = "ksvavpmwlkjzinzn";
        
                $mail->isHTML(true); 
                $mail->setFrom($email); 
                $mail->addAddress($email);

                $mail->Subject = $subject;
                $mail->Body = $message;

                $mail->send();
                            
                header("Location: order.php");
            } catch (\Throwable $th) {
                echo "Error: $th";
            }
        } else {
            $_SESSION['message'] = "Please Choose Payment Method";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h1 class="text-center fw-bold display-1 pt-2">Checkout</h1>
        <div class="row border rounded shadow mb-4">
            <div class="col-md-6 py-5 mt-3 ">
                <div class="border rounded">
                    <div class="p-2">
                        <h3 class="text-center">Order Summary</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>Items</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </thead>
                                <tbody>
                                    <?php
                                        $lists = $showList->showRecords("cart_id = ".$_SESSION["cart_id"]);
                                        if(count($lists) > 0){
                                            $total_price = 0;
                                            foreach ($lists as $list) {
                                                echo "<tr>";
                                                echo "<form method='post'>";
                                                $product = $showProduct->showRecords("id = $list[1]");
                                                echo "<td>".$product[0][1]."</td>";
                                                echo "<td>".$list[2]."</td>";
                                                echo "<td>₱".$list[3]."</td>";
                                                $total_price += $list[3];
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>

                            <?php
                            echo "<h4>Total Price: ₱".$total_price."</h4>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-3">
                <h3 class="text-center">Billing Information</h3>
                <hr>
                <form action="" method="post">
                    <?php
                        $total_price = 0;
                        $data = $showCart->showRecords("id = ".$_SESSION['cart_id']);
                        if(count($data) > 0){
                            $user_id = $data[0][1];
                            $customer = $showCustomer->showRecords("id = $user_id");
                            echo "<form method='post'>";
                            echo "<div class='mb-3'>";
                            echo "<h4 class='card-title'>Name: ".$customer[0][1]."</h4>";
                            echo "</div>";
                            echo "<div class='mb-3'>";
                            echo "<h4 class='card-title'>Phone Number: ".$customer[0][3]."</h4>";
                            echo "</div>";
                            echo "<div class='mb-3'>";
                            echo "<h4 class='card-title'>Email: ".$customer[0][2]."</h4>";
                            echo "</div>";
                            echo "<div class='mb-3'>";
                            echo "<h4 class='card-title'>Address: ".$customer[0][4]."</h4>";
                            echo "</div>";
                            echo "<div class='mb-3'>";
                            echo "<label class='form-label'>Payment Method</label>
                                    <select name='payment_method' class='form-select'>
                                        <option value='none' selected>Select Payment Method</option>
                                        <option value='GCASH'>GCASH</option>
                                        <option value='Credit Card'>Credit Card</option>
                                        <option value='Cashier'>Cashier</option>
                                    </select>";
                            echo "</div>";
                            echo "<input type='hidden' name='place_on' value='".date('Y-m-d')."'>";
                            $lists = $showList->showRecords("cart_id = ".$_SESSION["cart_id"]);
                            if(count($lists) > 0){
                                $total_price = 0;
                                foreach ($lists as $list) {
                                    $total_price += $list[3];
                                }
                                echo "<input type='hidden' name='total_price' value='".$total_price."'>";
                                echo "<h4>Place On: ".date('Y-m-d')."</h4>";
                            }
                            echo "<button type='submit' name='order' class='btn btn-danger col-12'>Order</button>";
                            echo "</form>";
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>

    <script src="js/sweetalert.js"></script>
    <script>
        <?php
            if(isset($_SESSION['message'])){
                echo "swal({
                    title: '".$_SESSION['message']."',
                    icon: 'warning',
                    button: 'Okay',
                  });";
                unset($_SESSION['message']);
            }
        ?>
    </script>

</body>
</html>