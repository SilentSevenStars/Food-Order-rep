<?php
    require '../component/connection.php';
    require '../component/add.php';

    $add = new Add($conn, 'category');

    if(isset($_POST['add'])){
        $data=[];
        foreach ($_POST as $name => $value) {
            if($name != "add")
                $data[$name] = $value;
        }
        try {
            $action = $add->addQuery($data);
            header("Location: ../admin/category.php");
        } catch (Exception $e) {
            echo "<div class='alert alert-danger' role='alert'>Error: $e</div>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        body{
            background: #2779e2;
        }
        .d-flex{
            gap: 5px;
        }
    </style>
</head>
<body>
<section class="vh-100">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-9">

                <h1 class="text-white mb-4">Add category</h1>

                <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row align-items-center pt-4 pb-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Name</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="text" name="name" class="form-control form-control-lg" />

                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="px-5 py-4 d-flex justify-content-start">
                                <button type="submit" name="add" class="btn btn-primary btn-lg">Submit</button>
                                <a href="../admin/category.php" class="btn btn-warning btn-lg">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
</body>
</html>