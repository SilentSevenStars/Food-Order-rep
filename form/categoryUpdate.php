<?php
    require '../component/connection.php';
    require '../component/update.php';
    require '../component/show.php';

    $id = $_GET['id'] ?? NULL;
    if(!isset($id))
        header("Location: ../admin/category.php");

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
            header('Location: ../admin/category.php');
            exit();
        } catch (Exception $e) {
            echo "Error: $e";
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
        .d-flex{
            gap: 5px;
        }
    </style>
</head>
<body style="background: #2779e2;">
    <section class="vh-100">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-9">

                    <h1 class="text-white mb-4">Update Category</h1>

                    <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row align-items-center pt-4 pb-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Name</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="text" name="name" value="<?= $data[0][1] ?>" class="form-control form-control-lg" />

                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="px-5 py-4 d-flex justify-content-start">
                                <button type="submit" name="update" class="btn btn-primary btn-lg">Submit</button>
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