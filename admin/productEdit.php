<?php
    require '../component/connection.php';
    require '../component/show.php';
    require '../component/update.php';

    $id = $_GET['id'] ?? NULL;
    if(!isset($id))
        header("Location: product.php");

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
            $_SESSION['message'] = "Updated Successfully";
            header('Location: ../admin/product.php');
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
    <title>Admin Edit Product</title>
    <!-- bootstrap link  -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .img{
            width: 250px;
            height: 250x;
        }
    </style>
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
                        <h4>Product Details</h4>
                    </div>
                    <div class="card border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                Update Product
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row justify-content-center mb-3">
                                    <div class="col-6 text-center">
                                        <?php
                                            if(!empty($data[0][4])){
                                                echo "<img src='../upload_img/".$data[0][4]."' alt='Product Image' class='img rounded-circle'>";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Product Image</label>
                                    <input type="file" name="image" class="form-control form-control" id="formFilelg" accept="image/jpg, image/jpeg, image/png, image/webp">
                                    <input type="hidden" name="old_image" value="<?= $data[0][4] ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="" class="form-label">Name</label>
                                    <input type="text" name="name" value="<?= $data[0][1] ?>" class="form-control form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Category</label>
                                    <select name="category_id" class="form-select">
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
                                <div class="mb-3">
                                    <label for="" class="form-label">Price</label>
                                    <input type="number" name="price" value="<?= $data[0][3] ?>" class="form-control form-control" required>
                                </div>
                                <input type="submit" value="Submit" name="Update" class="btn btn-primary">
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