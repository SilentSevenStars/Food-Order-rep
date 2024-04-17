<?php
    require 'component/connection.php';
    require 'component/show.php';
    require 'component/update.php';
    require 'component/add.php';

    session_start();

    $showProduct = new Show($conn, 'product');
    $showCategory = new Show($conn, 'category');
    $showCart = new Show($conn, 'cart');
    $showList = new Show($conn, 'list');
    $addList = new Add($conn, 'list');
    $addCart = new Add($conn, 'cart');

    if(isset($_SESSION['cart']) && isset($_SESSION['customer_id'])){
        $cart = $_SESSION['cart'];
        $data = [];
        foreach ($cart as $key => $value) {
            $data[$key] = $value;
        }
        try {
            $action = $addList->addQuery($data);
        } catch (\Throwable $th) {
            echo "Error: $e";
        }
        unset($_SESSION['cart']);
    }

    if(isset($_POST['add_to_cart'])){
        if(!isset($_SESSION['customer_id'])){
            $sub_price = $_POST['quantity'] * $_POST['price'];
            $cart = array(
                'product_id' => $_POST['product_id'],
                'quantity' => $_POST['quantity'],
                'sub_price' => $sub_price
            );
            $_SESSION['cart'] = $cart;
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
                } else {
                    $data = [];
                    foreach ($_POST as $name => $value) {
                        if($name!="add_to_cart" && $name!="price")
                            $data[$name] = $value;
                    }
                    $data['sub_price'] = $_POST['quantity'] * $_POST['price'];
                    $data['cart_id'] = $_SESSION['cart_id'];
                    try {
                        $action = $addList->addQuery($data);
                    } catch (Exception $e) {
                        echo "Error: $e";
                    }
                } 
            } else {
                $customer_id = $_SESSION['customer_id'];
                $data = [];
                $data['customer_id'] = $customer_id;
                try {
                    $addCart->addQuery($data); // Create a new cart entry
                    $cart = $showCart->showRecords("customer_id = $customer_id", "id DESC");
                    $_SESSION['cart_id'] = $cart[0][0]; // Set cart_id session variable
                } catch (Exception $e) {
                    echo "Error: $e";
                }
                
                // Add the product to the newly created cart
                $product = [];
                foreach ($_POST as $name => $value) {
                    if($name!="add_to_cart" && $name!="price")
                        $product[$name] = $value;
                }
                $product['sub_price'] = $_POST['quantity'] * $_POST['price'];
                $product['cart_id'] = $_SESSION['cart_id'];
                try {
                    $action = $addList->addQuery($product);
                } catch (Exception $e) {
                    echo "Error: $e";
                }
            }
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
    <link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        .about {
    max-width: 968px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: auto 1fr; /* Image on the left, text on the right */
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 40px; /* Increase the bottom margin for more space */
}

.about img {
    max-width: 100%; /* Ensure the image is responsive */
    height:auto; /* Ensure the image maintains its aspect ratio */
    max-width: 200px; /* Adjust the maximum width as needed */
}


.about-text span {
    font-weight: 600;
    text-transform: uppercase;
    color: var(--green-color);
}

.about-text p {
    margin: 0.5rem 0 1rem;
}

.about .btn {
    background-color: #b8860b; /* Dirty yellow color */
    color: #fff; /* Text color */
}

.about .btn:hover {
    background-color: #cdad00; /* Darker dirty yellow color on hover */
}

.slideshow {
    max-width: 968px;
    margin: 40px auto; /* Increase the top margin for more space */
    overflow: hidden;
    position: relative;
    margin-top: 40px;
}
.slides {
    display: flex;
    animation: slide 20s linear infinite; /* Adjust duration as needed */
}

.slides img {
    max-width: 100%;
    height: auto;
}

button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    cursor: pointer;
    padding: 10px;
    z-index: 1;
}

.prev {
    left: 0;
}

.next {
    right: 0;
}

@keyframes slide {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-100%); /* Adjust based on the number of images */
    }
}




    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section id="latest">
        <div class="container py-5">
            <div class="row">
                <h1 class="text-center">About Us</h1>
                
            
        </div>
    </section>
    
    <section class="about" id="about"> <img src="image/about.jpg" alt=""> 
        <div class="about-text">
            <span>About Us:</span>
             <p>Lorem ipsum dolor sit, amet consectetur adipeagiueurgnherigjioegnrgnrtnibrbnwrvbnerijegvtrnisicing elit. Quo neque consed </p>
             <p>Lorem ipsum dolor, sit amet consectetur adipuyfhuerhguerhuehrf8erj8j89bjt98guje88eg87herggr89wrw89isicing elit. Dolorum, optio v </p>
             <a href="#" class="btn">Learn More<i class='bx bx-right-arrow-alt' ></i></a>
      </div> 
    </section>

<section class="slideshow">
    <div class="slides">
        <img src="image/image1.jpg" alt="">
        <img src="image/image2.jpg" alt="">
        <img src="image/image3.jpg" alt="">
    </div>

</section>

    <script>
        function moveSlides(direction) {
            const slides = document.querySelector('.slides');
            const slideWidth = slides.clientWidth;
            slides.style.transform = `translateX(${direction * slideWidth}px)`;
        }
    </script>



</body>

</html>