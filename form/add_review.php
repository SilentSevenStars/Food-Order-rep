<?php
   session_start();
   require '../component/connection.php';
   require '../component/add.php';

   if(!isset($_SESSION['customer_id'])){
        if(isset($_SESSION['link'])){
            $_SESSION['login'] = true;
            header("Location: ../".$_SESSION['link']);
        } else {
            $_SESSION['login'] = true;
            header("Location: index.php");
        }
    }
      

   $pid = $_GET['pid'] ?? NULL;

   if($pid == NULL)
      header("Location: ../view_product.php?pid=$pid");

   $add = new Add($conn, 'reviews');

    if(isset($_POST['add'])) {
         $data = [];
         foreach ($_POST as $name => $value) {
            if($name != 'add')
               $data[$name] = $value;
        }
        $data['customer_id'] = $_SESSION['customer_id'];
        $data['product_id'] = $pid;
        try {
            $action = $add->addQuery($data);
            $_SESSION['message'] = "Reviews Added";
            header('Location: ../view_product.php?pid='.$pid);
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
    <title>Food Ordering System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-...">
    <link rel="stylesheet" href="../bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/review.css">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <section class="account-form">

   <form action="" method="post">
      <h3>post your review</h3>
      <p>Review title</p>
      <input type="text" name="title" required maxlength="50" placeholder="enter review title" class="box">
      <p>Review description</p>
      <textarea name="description" class="box" placeholder="enter review description" maxlength="1000" cols="30" rows="10"></textarea>
      <p>Review rating </p>
      <select name="rating" class="box" required>
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
         <option value="4">4</option>
         <option value="5">5</option>
      </select>
      <input type="submit" value="submit review" name="add" class="btn btn-primary">
      <a href="#" class="btn btn-warning">go back</a>
   </form>

   
</section>
</body>
</html>