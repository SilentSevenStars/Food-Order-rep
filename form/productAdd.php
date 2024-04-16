<?php
    require '../component/connection.php';
    require '../component/add.php';
    require '../component/show.php';

    $add = new Add($conn, 'product');
    $showCategory = new Show($conn, 'category');
    if (isset($_POST['add'])) {
        $data = [];
        foreach ($_POST as $name => $value) {
            if ($name != "add" && $name != "image")
                $data[$name] = $value;
        }
        $fileName = $_FILES['image']['name'];
        $fileTmpName = $_FILES['image']['tmp_name'];
        $fileSize = $_FILES['image']['size'];
        $fileError = $_FILES['image']['error'];
        $fileType = $_FILES['image']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        if ($fileError === 0) {
            if ($fileSize < 5000000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = '../upload_img/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $data['image'] = $fileNameNew;
                try {
                    $action = $add->addQuery($data);
                    header('Location: ../admin/product.php');
                } catch (Exception $e) {
                    echo "Error: $e";
                }
            } else {
                echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                        File is too large.
                        <button class='btn-close' aria-label='close' data-bs-dismiss='alert'></button>
                      </div>";
            }
        } else {
            echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                    There was an error uploading image.
                    <button class='btn-close' aria-label='close' data-bs-dismiss='alert'></button>
                  </div>";
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
    <section>
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-9">

                    <h1 class="text-white mb-4">Add Product</h1>

                    <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
                        <form action="" class="form-signup" method="post" enctype="multipart/form-data">
                            <div class="row align-items-center pt-4 pb-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Name</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="text" name="name" class="form-control form-control-lg" />

                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Category</h6>

                                </div>
                                <div class="col-md-9 pe-5">
                                    <select name="category_id" class="form-select" aria-label="Default select example" required>
                                        <option selected>Open this select menu</option>
                                        <?php
                                            $categories = $showCategory->showRecords();
                                            if(count($categories) > 0){
                                                foreach ($categories as $category) {
                                                    echo "<option value='".$category[0]."'>".$category[1]."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center pt-4 pb-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Price</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="number" name="price" class="form-control form-control-lg" />

                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Upload Image</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="file" name="image" class="form-control form-control-lg" id="formFilelg" accept="image/jpg, image/jpeg, image/png, image/webp" required>

                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="px-5 py-4 d-flex justify-content-start">
                                <button type="submit" name="add" class="btn btn-primary btn-lg">Submit</button>
                                <a href="../admin/product" class="btn btn-warning btn-lg">Cancel</a>
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