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
        $data = [];
        foreach ($_POST as $name => $value){
            if($name != "update"){
                $data[$name] = $value;
            }
            try {
                $action = $update->updateQuery($data);
                header("Location: index.php");
            } catch (\Throwable $th) {
                echo "Error: $th";
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
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../login.css">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: #c8c4c9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box form-box">
        <header>Change Profile</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" value="<?= $data[0][1] ?>" id="name" autocomplete="on" >
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?= $data[0][2] ?>" id="email" autocomplete="on" >
                </div>

                <div class="field input">
                    <label for="phone_number">Phone Number</label>
                    <input type="tel" name="phone_number" value="<?= $data[0][3] ?>" pattern="09[0-9]{2}[0-9]{3}[0-9]{4}">
                </div>

                <div class="field input">
                    <label for="address">Address</label>
                    <input type="text" name="address" value="<?= $data[0][4] ?>" autocomplete="on" >
                </div>

                <div class="ok">
                    <input type="submit" class="btn" name="update" value="Update" >
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