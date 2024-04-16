<?php
    require '../component/connection.php';
    require '../component/update.php';
    require '../component/show.php';

    $id = $_GET['id'] ?? NULL;
    if(!isset($id))
        header("Location: ../admin/product.php");

    $show = new Show($conn, 'product');
    $showCategory = new Show($conn, 'category');

    $update = new Update($conn, 'product', ['id' => $id]);

    $data = $show->showRecords("id = $id");

    if (isset($_POST['Update'])) {
        $data = [];
        $old_image = $_POST['old_image'];
        foreach ($_POST as $name => $value) {
            if ($name != "Update" && $name != "image" && $name != "old_image")
                $data[$name] = $value;
        }
        
        if ($_FILES['image']['name'] != "") { 
            $fileName = $_FILES['image']['name'];
            $fileTmpName = $_FILES['image']['tmp_name'];
            $fileSize = $_FILES['image']['size'];
            $fileError = $_FILES['image']['error'];
            $fileType = $_FILES['image']['type'];
    
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
    
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = '../upload_img/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $data['image'] = $fileNameNew;
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
        } else {
            $data['image'] = $old_image;
        }
        try {
            $action = $update->updateQuery($data);
            header('Location: ../admin/product.php');
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

                    <h1 class="text-white mb-4">Update Product</h1>

                    <div class="card" style="border-radius: 15px;">
                    <div class="card-body">
                        <form action="" class="form-signup" method="post" enctype="multipart/form-data">
                            <div class="row align-items-center pt-4 pb-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Name</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="text" name="name" value="<?= $data[0][1] ?>" class="form-control form-control-lg" />

                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Category</h6>

                                </div>
                                <div class="col-md-9 pe-5">
                                    <select name="category_id" class="form-select" aria-label="Default select example" required>
                                        <?php
                                            $categories = $showCategory->showRecords();
                                            if(count($categories) > 0){
                                                foreach ($categories as $category) {
                                                    if($data[0][2] == $category[0])
                                                        echo "<option value='".$category[0]."' selected>".$category[1]."</option>";
                                                    else
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

                                    <input type="number" name="price" value="<?= $data[0][3] ?>" class="form-control form-control-lg" />

                                </div>
                            </div>

                            <hr class="mx-n3">

                            <div class="row align-items-center py-3">
                                <div class="col-md-3 ps-5">

                                    <h6 class="mb-0">Upload Image</h6>

                                </div>
                                <div class="col-md-9 pe-5">

                                    <input type="file" name="image" class="form-control form-control-lg" id="formFilelg" accept="image/jpg, image/jpeg, image/png, image/webp">
                                    <input type="hidden" name="old_image" value="<?= $data[0][4] ?>">

                                </div>
                            </div>
                            <?php
                                    if(!empty($data[0][4])){
                                        echo "<div class='d-flex justify-content-center mt-1'>";
                                        echo "<img src='../upload_img/".$data[0][4]."' class='img-fluid'>";
                                        echo "</div>";
                                    }
                                ?>

                            <hr class="mx-n3">

                            <div class="px-5 py-4 d-flex justify-content-start">
                                <button type="submit" name="Update" class="btn btn-primary btn-lg">Submit</button>
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