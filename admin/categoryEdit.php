<?php
    require '../component/connection.php';
    require '../component/show.php';
    require '../component/update.php';

    session_start();

    $id = $_GET['id'] ?? NULL;
    if(!isset($id))
        header("Location: category.php");

    $show = new Show($conn, 'category');
    $update = new Update($conn, 'category', ['id' => $id]);

    $data = $show->showRecords("id = $id");

    if (isset($_POST['update'])) {
        $data = [];
        $old_image = $_POST['old_image'];
        foreach ($_POST as $name => $value) {
            if ($name != "update")
                $data[$name] = $value;
        }
        try {
            $action = $update->updateQuery($data);
            $_SESSION['message'] = "Updated Successfully";
            header('Location: category.php');
            exit();
        } catch (Exception $e) {
            echo "Error: $e";
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

<body data-bs-theme="light">
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
                                Update Category
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="" class="form-label">Name</label>
                                    <input type="text" name="name"  value="<?= $data[0][1] ?>"  class="form-control">
                                </div>
                                <input type="submit" value="Submit" name="update" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
                
            </main>
        </div>
    </div>
    <script src="../js/script.js"></script>
</body>

</html>
