<?php
    session_start();

    require 'component/connection.php';
    require 'component/show.php';
    require 'component/add.php';

    $show = new Show($conn, 'customer');
    $add = new Add($conn, 'customer');

    if(isset($_POST['add'])) {
        $match = $show->showRecords("name = '".$_POST['name']."' OR email = '".$_POST['email']."'");
        if(count($match) > 0){
            $_SESSION['message'] = "Name or Email are already exist";
        } else {
            if($_POST['password'] === $_POST['cpassword']){
                $data=[];
                foreach ($_POST as $name => $value) {
                    if($name!="add" && $name!="cpassword") {
                        $data[$name] = ($name=="password") ? password_hash($value,PASSWORD_BCRYPT):$value;
                    }
                }
                try {
                    $action = $add->addQuery($data);
                    $_SESSION['message'] = "New account created successfully";
                    header('Location: login.php');
                } catch (Exception $e) {
                    echo "Error: $e";
                }
            } else {
                $_SESSION['message'] = "Password and Confirm your password are not matched";
            }
        }
    
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" autocomplete="on" >
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" autocomplete="on" >
                </div>

                <div class="field input">
                    <label for="phone_number">Phone Number</label>
                    <input type="tel" name="phone_number" pattern="09[0-9]{2}[0-9]{3}[0-9]{4}" />
                </div>

                <div class="field input">
                    <label for="address">Address</label>
                    <input type="text" name="address" autocomplete="on" >
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="on" >
                </div>

                <div class="field input">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="cpassword" id="password_confirmation" autocomplete="on" required>
                </div>

                <div class="links">
                    Already have an account? <a href="login.php">Login</a>
                </div>

                <div class="ok">
                    <input type="submit" class="btn" name="add" value="Register" >
                    <button class='btn' onclick="window.location.href='index.php';">Go Back</button>
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
                    icon: 'warning',
                    button: 'Okay',
                  });";
                unset($_SESSION['message']);
            }
        ?>
    </script>
</body>
</html>