<?php
    session_start();
    require 'component/connection.php';
    require 'component/add.php';
    require 'component/show.php';

    $show = new Show($conn, 'customer');
    $showCart = new Show($conn, 'cart');
    $showOrder = new Show($conn, 'orders');
    $addCart = new Add($conn, 'cart');


    if(isset($_POST['submit'])){ 
        $email = $_POST['email'];
        $password = $_POST['password'];

        $data = $show->showRecords("email = '$email'");

        if(count($data) > 0){
            if(password_verify($password, $data[0][5])){
                $_SESSION['customer_id'] = $data[0][0]; 

                $customer_id = $data[0][0]; 

                $cart = $showCart->showRecords("customer_id = $customer_id", "id DESC");

                if(count($cart) > 0){
                    $cart_id = $cart[0][0];
                    $order = $showOrder->showRecords("cart_id = $cart_id");

                    if(count($order) > 0){
                        $data = [];
                        $data['customer_id'] = $customer_id;

                        try {
                            $action = $addCart->addQuery($data);
                            $newCart = $showCart->showRecords("customer_id = $customer_id", "id DESC");
                            $_SESSION['cart_id'] = $newCart[0][0]; 
                            header("Location: index.php");
                        } catch (Exception $e) {
                            echo "Error: $e";
                        }
                    } else {
                        $_SESSION['cart_id'] = $cart_id; 
                        header("Location: index.php");
                    }
                } else {
                    $data = [];
                    $data['customer_id'] = $customer_id;

                    try {
                        $action = $addCart->addQuery($data);
                        $cart = $showCart->showRecords("customer_id = $customer_id", "id DESC");
                        $_SESSION['cart_id'] = $cart[0][0];
                        header("Location: index.php");
                    } catch (Exception $e) {
                        echo "Error: $e";
                    }
                }
            } else {
                $error = "Incorrect password";
            }
        } else {
            $error = "Invalid email";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="login.css">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.4)), url(hero.jpg);
            background-position: center;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <?php if(isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="on" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="on" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>
                <div class="links">
                    Don't have an account? <a href="signup.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
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
</body>
</html>
