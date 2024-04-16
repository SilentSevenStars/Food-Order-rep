<?php
    require 'component/connection.php';
    session_start();
    unset($_SESSION['customer_id']);
    if(isset($_SESSION['cart_id'])){
        unset($_SESSION['cart_id']);
    }
    $conn->close();
    header("Location: index.php");
?>