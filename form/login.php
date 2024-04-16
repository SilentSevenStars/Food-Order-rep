<?php
    require '../component/connection.php';
    require '../component/add.php';
    require '../component/show.php';

    $show = new Show($conn, 'customer');
    $showCart = new Show($conn, 'cart');
    $showOrder = new Show($conn, 'orders');
    $addCart = new Add($conn, 'cart');

    session_start();

    if(isset($_POST['Login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        
        if($email === 'admin@admin.com' && $password === 'admin123') {
            $_SESSION['admin'] = true;
            header("Location: ../admin/index.php");
            exit;
        } else {
            echo "Incorrect email or password";
        }
    }

    // Logout functionality
    if(isset($_GET['logout'])) {
        session_destroy();
        header("Location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body class="container">
    <form action="" method="post">
        <label for="" class="form-label">Email</label>
        <input type="text" name="email" id="" class="form-control">
        <label for="" class="form-label">Password</label>
        <input type="password" name="password" id="" class="form-control">
        <input type="submit" value="Login" name="Login" class="btn btn-primary">
    </form>
    <br>
</body>
</html>
