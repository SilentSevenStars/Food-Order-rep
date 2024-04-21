<?php
    session_start();

    require 'component/connection.php';
    require 'component/show.php';
    require 'component/update.php';

    $id = $_SESSION['customer_id'] ?? null;
    if(!isset($id))
        header("Location: index.php");

    $show = new Show($conn, 'customer');
    $update = new Update($conn, 'customer', ["id" =>  $id]);

    $data = $show->showRecords("id = $id");

    if(isset($_POST['update'])) {
        if(password_verify($_POST['old_password'], $data[0][5])){
            if($_POST['password'] == $_POST['confirm_password']){
                $data=[];
                foreach($_POST as $name => $value){
                    if($name!="update" && $name!="old_password" && $name!="confirm_password")
                        $data[$name] = ($name=="password") ? password_hash($value,PASSWORD_BCRYPT):$value;
                }
                try{
                    $action = $update->updateQuery($data);
                    header('Location: index.php');
                }catch(Exception $e){
                    echo "Error: $e";
                }
            } else{
                echo "New Password and Confirm Password does not matched";
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
    <title>Update Profile</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="box form-box">
        <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="name">Enter Old Password</label>
                    <input type="password" name="old_password"  id="name" autocomplete="on" >
                </div>

                <div class="field input">
                    <label for="email">Enter New Password</label>
                    <input type="password" name="password"  id="email" autocomplete="on" >
                </div>

                <div class="field input">
                    <label for="phone_number">Confirm new password</label>
                    <input type="password" name="confirm_password" autocomplete="on">
                </div>

                <div class="ok">
                    <input type="submit" class="btn" name="update" value="Register" >
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