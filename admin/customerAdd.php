<?php
    require '../component/connection.php';
    require '../component/add.php';
    session_start();

    $add = new Add($conn, 'customer');

    if(isset($_POST['add'])) {
        if($_POST['password'] === $_POST['cpassword']){
            $data=[];
            foreach ($_POST as $name => $value) {
                if($name!="add" && $name!="cpassword") {
                    $data[$name] = ($name=="password") ? password_hash($value,PASSWORD_BCRYPT):$value;
                }
            }
            try {
                $action = $add->addQuery($data);
                $_SESSION['message'] = "Customer Registered Successfully";
                header('Location: customer.php');
            } catch (Exception $e) {
                echo "Error: $e";
            }
        } else {
            echo "<div class='alert alert-danger'>Password and Confirm Password are not the same.</div>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Add Customer</title>
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
                        <h4>Customer Details</h4>
                    </div>
                    
                    <!-- Table Element -->
                    <div class="card border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                Add Customer
                            </h5>
                        </div>
                        <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="" class="form-label">Name: </label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Email: </label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Phone Number:</label>
                                <input type="tel" name="phone_number" pattern="09[0-9]{2}[0-9]{3}[0-9]{4}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Address:</label>
                                <input type="text" name="address" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Password:</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Confirm your password:</label>
                                <input type="password" name="cpassword"  class="form-control">
                            </div>
                            <input type="submit" value="Submit" name="add" class="btn btn-primary">
                        </form>
                        </div>
                    </div>
                </div>
            </main>
            <!-- <a href="#" class="theme-toggle">
                <i class="fa-regular fa-moon"></i>
                <i class="fa-regular fa-sun"></i>
            </a> -->
        </div>
    </div>

    <script src="../js/script.js"></script>
</body>

</html>
