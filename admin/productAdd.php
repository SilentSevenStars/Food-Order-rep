<?php
    require '../component/connection.php';
    require '../component/show.php';
    require '../component/add.php';

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
                    $_SESSION['message'] = "New Product Added Successfully";
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
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Add Product</title>
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
                        <h4>Product Details</h4>
                    </div>
                    
                    <!-- Table Element -->
                    <div class="card border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                Add Product
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Category</label>
                                    <select name="category_id" class="form-select">
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
                                <div class="mb-3">
                                    <label for="" class="form-label">Price</label>
                                    <input type="number" name="price" class="form-control form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Product Image</label>
                                    <input type="file" name="image" class="form-control form-control" id="formFilelg" accept="image/jpg, image/jpeg, image/png, image/webp" required>
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
