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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../login.css">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: #e8e4c9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Admin Login</header>
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
                    <input type="submit" class="btn" name="Login" value="Login">
                </div>

                <div class="field">
                    <button class='btn' onclick="window.location.href='../login.php';">User Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
