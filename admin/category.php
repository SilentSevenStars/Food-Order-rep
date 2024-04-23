<?php
    require '../component/connection.php';
    require '../component/show.php';

    session_start();

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin =Category</title>
    <!-- bootstrap link  -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.bundle.js"></script>
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../bootstrap-icons-1.11.3/font/bootstrap-icons.css">
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
                        <div class="card-header d-flex justify-content-around">
                            <h5 class="card-title">
                                Category Information
                            </h5>
                            <a href="categoryAdd.php" class="btn btn-primary">Add</a>
                        </div>
                        <?php
                            $show = new Show($conn, 'category');
                            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                            $paginationData = $show->showRecordsWithPagination($currentPage, null, 10, null);
                            $categories = $paginationData['records'];
                        ?>
                        <div class="card-body table-responsive container">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $startIndex = ($currentPage - 1) * 10 + 1;
                                        $category_count = $startIndex - 1;
                                        if(count($categories) > 0){
                                            foreach ($categories as $category) {
                                                echo "<tr>";
                                                echo "<th scope='row'>".++$category_count."</th>";
                                                echo "<td>".$category[0]."</td>";
                                                echo "<td>".$category[1]."</td>";
                                                echo "<td>
                                                        <a href='categoryEdit.php?id=".$category[0]."' class='btn btn-primary'><i class='bi bi-pencil-square'></i></a>
                                                        <a class='btn btn-warning' href='../form/categoryDelete.php?id=".$category[0]."'><i class='bi bi-trash'></i></a>
                                                        </td>";   
                                            }
                                        } else {
                                            echo "<div class='alert alert-dark' role='alert'>No record Found</div>";
                                        }
                                    ?>
                                    
                                </tbody>
                            </table>
                            <nav class="d-flex justify-content-center" aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php if ($currentPage > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?=($currentPage - 1)?>">Previous</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php for ($page = 1; $page <= $paginationData['totalPages']; $page++): ?>
                                        <li class="page-item"><a class="page-link" href="?page=<?=$page?>"><?=$page?></a></li>
                                    <?php endfor; ?>
                                    <?php if ($currentPage < $paginationData['totalPages']): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?=($currentPage + 1)?>">Next</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                
            </main>
        </div>
    </div>
    <script src="../js/script.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/sweetalert.js"></script>
    <script>
        <?php
        if(isset($_SESSION['message'])){
            echo "swal({
                title: '".$_SESSION['message']."',
                icon: 'success',
                button: 'Okay',
              });";
            unset($_SESSION['message']);
        }
    ?>
    </script>
</body>

</html>
