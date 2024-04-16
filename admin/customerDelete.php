<?php
    require '../component/connection.php';
    require '../component/delete.php';

    session_start();

    $id = $_GET['id'] ?? NULL;

    $delete = new Delete($conn, 'customer', ['id'=>$id]);

    if(isset($id)){
        try{
            $action = $delete->deleteQuery();
            $_SESSION['message'] = "Delete Successfully";
            header("Location: customer.php");
        } catch(Exception $e){
            echo "Error: $e";
        }
    } else {
        header("Location: customer.php");
    }

    
?>