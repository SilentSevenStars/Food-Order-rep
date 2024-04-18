<?php
    require '../component/connection.php';
    require '../component/show.php';
    require '../component/update.php';
    require '../component/add.php';

    session_start();

    $showProduct = new Show($conn, 'product');
    $showCategory = new Show($conn, 'category');
    $showCart = new Show($conn, 'cart');
    $showList = new Show($conn, 'list');
    $addList = new Add($conn, 'list');
    $addCart = new Add($conn, 'cart');

    if(isset($_POST['add_to_cart'])){
        if(!isset($_SESSION['customer_id'])){
            $_SESSION['login'] = true;
            header("Location: ../menu.php");
        } else {
            if(isset($_SESSION['cart_id'])){
                $cart_id = $_SESSION['cart_id'];
                $list = $showList->showRecords("cart_id = $cart_id AND product_id  = ". $_POST['product_id']);
                if(count($list) > 0){
                    $data =[];
                    $quantity = $_POST['quantity'];
                    $sub_price = $_POST['quantity'] * $_POST['price'];
                    $query = "UPDATE list SET quantity = '".$quantity."', sub_price = '".$sub_price."' WHERE cart_id = '$cart_id' AND product_id  = ". $_POST['product_id'];
                    $result = $conn->query($query);
                    if($result){
                        $_SESSION['message'] = "Update product successfully";
                        header("Location: ../menu.php"); 
                    }
                    $_SESSION['message'] = "Update product successfully";
                    header("Location: ../menu.php");
                } else {
                    $data = [];
                    foreach ($_POST as $name => $value) {
                        if($name!="add_to_cart" && $name!="price")
                            $data[$name] = $value;
                    }
                    $data['sub_price'] = $_POST['quantity'] * $_POST['price'];
                    $data['cart_id'] = $_SESSION['cart_id'];
                    $action = $addList->addQuery($data);
                    if($action){
                        $_SESSION['message'] = "Added to cart Successfully";
                        header("Location: ../menu.php");
                    } else {
                        echo "Error ";
                    }
                } 
            } else {
                $customer_id = $_SESSION['customer_id'];
                $data = [];
                $data['customer_id'] = $customer_id;
                $action = $addCart->addQuery($data); 
                if($action){
                    $cart = $showCart->showRecords("customer_id = $customer_id", "id DESC");
                    $_SESSION['cart_id'] = $cart[0][0]; 

                    $product = [];
                    foreach ($_POST as $name => $value) {
                        if($name!="add_to_cart" && $name!="price")
                            $product[$name] = $value;
                    }
                    $product['sub_price'] = $_POST['quantity'] * $_POST['price'];
                    $product['cart_id'] = $_SESSION['cart_id'];

                    $action = $addList->addQuery($product);
                    if($action){
                        $_SESSION['message'] = "Added to cart Succesfully";
                        header("Location: ../menu.php");
                    } else {
                        echo "Error";
                    }
                }
            }
        }
    }
?>