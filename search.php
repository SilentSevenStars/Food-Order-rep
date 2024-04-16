<?php
    require 'component/connection.php';
    require 'component/show.php';

    $showProduct = new Show($conn, 'product');
    $showCategory = new Show($conn, 'category');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Ordering System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-...">
    <link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        .img{
            background-size: cover;
        }

        /* Center the search form */
        #search {
            margin-top: 50px; /* Adjust as needed */
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section id="search" class="d-flex justify-content-center">
        <div class="col-md-6">
            <form action="" method="get" class="form-control">
                <div class="input-group">
                    <input type="search" name="search" class="form-control">
                    <button type="submit" name="searchBtn" class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </section>

    <section class="search">
        <div class="container py-5">
            <div class="row row-cols-1 row-cols-md-3 g-4 py-5">
            <?php
                if(isset($_GET['searchBtn'])){
                    $search = $_GET['search'];
                    $search_query = "name LIKE '%$search%' OR price LIKE '%$search%'";
                    $data = $showProduct->showRecords($search_query);
                    if(count($data) > 0){
                        $product_count = 0;
                        foreach ($data as $key => $product) {
                            if($product_count < 3){
                                $category = $showCategory->showRecords("id = $product[2]");
                                echo "<div class='col'>
                                            <form action='' method='post'>
                                                <div class='card'>
                                                    <img class='card-img-top img' src='upload_img/".$product[4]."' alt='Card image cap' style='height: 300px; width: auto;'>
                                                    <div class='card-body'>
                                                        <h5 class='card-title'>".$product[1]."</h5>
                                                        <h5 class='card-title text-muted'>".$category[0][1]."</h5>
                                                        <input type='number' name='quantity' value='1' min='1' class='form-control'>
                                                        <div class='d-flex justify-content-around my-2'>
                                                            <h3>P".$product[3]."</h3>
                                                            <button type='submit' class='btn btn-primary'><i class='bi bi-cart'></i></button>
                                                        </div>
                                                    </div>             
                                                </div>
                                            </form>
                                    </div>";
                                $product_count++;
                            } else {
                                $product_count=0;
                                echo '</div><div class="row row-cols-1 row-cols-md-3 g-4 py-5">';
                            }
                        }
                    } else {
                        echo "<div class='col-md-12'>
                            <div class='alert alert-danger'>
                                <h1>No Product Found</h1>
                            </div>
                        </div>";
                    }
                }
            ?>
        </div>
    </section>
    

</body>
</html>