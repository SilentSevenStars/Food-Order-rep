<?php
require '../component/connection.php';
require '../component/delete.php';

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Category</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .btn {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Delete Category</h2>

    <form action="" method="post" onsubmit="return confirmDelete()">
        <p>Are you sure you want to delete this category?</p>
        <input type="submit" value="Yes, delete" class="btn btn-danger">
        <a href="../admin/category.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this category?");
    }
</script>

</body>
</html>

<?php
} else {
    echo "<div class='alert alert-danger' role='alert'>Category ID not provided</div>";
}
?>
