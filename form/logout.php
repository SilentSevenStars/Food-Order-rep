<?php
    require '../component/connection.php';
    session_start();
    unset($_SESSION['admin']);
    $conn->close();
    header("Location: login.php");
?>