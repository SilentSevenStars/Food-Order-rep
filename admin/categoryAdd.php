<?php
    require '../component/connection.php';
    require '../component/add.php';

    session_start();

    $add = new Add($conn, 'category');

    if(isset($_POST['add'])){
        $data=[];
        foreach ($_POST as $name => $value) {
            if($name != "add")
                $data[$name] = $value;
        }
        try {
            $action = $add->addQuery($data);
            $_SESSION['message'] = "New Category Added";
            header("Location: category.php");
        } catch (Exception $e) {
            echo "<div class='alert alert-danger' role='alert'>Error: $e</div>";
        }
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

<body>
    <div class="wrapper">
        <?php include '../includes/adminHeader.php' ?>
        
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h4>Category Details</h4>
                    </div>
                    
                    <!-- Table Element -->
                    <div class="card border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                Add Category
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <input type="submit" value="Submit" name="add" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
                
            </main>
            <a href="#" class="theme-toggle">
                <i class="fa-regular fa-moon"></i>
                <i class="fa-regular fa-sun"></i>
            </a>
        </div>
    </div>
    <script src="../js/script.js"></script>
</body>

</html>
