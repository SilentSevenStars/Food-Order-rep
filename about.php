<?php
    session_start();

    require 'component/connection.php';
    require 'component/show.php';

    $_SESSION['link'] = "about.php";

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
    <link rel="stylesheet" href="css/style.css">

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        .about {
            max-width: 968px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: auto 1fr; 
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 40px; 
        }

        .about img {
            max-width: 100%; 
            height:auto; 
            max-width: 200px; 
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
            background-color: #b8860b; 
            color: #fff; 
        }

        .about .btn:hover {
            background-color: #cdad00; 
        }

        .slideshow {
            max-width: 968px;
            margin: 40px auto; 
            overflow: hidden;
            position: relative;
            margin-top: 40px;
        }
        .slides {
            display: flex;
            animation: slide 20s linear infinite; 
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
                transform: translateX(-100%); 
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

    <?php include 'includes/footer.php' ?>

    <script src="js/sweetalert2.js"></script>
    <script>
        <?php
            if(isset($_SESSION['login'])){
                echo "swal.fire({
                    icon: 'info',
                    title: 'Please login or sign up to continue',
                    showConfirmButton: false,
                    html: '<a class=\"btn btn-primary\" href=\"login.php\">Login</a>&nbsp;&nbsp;<a class=\"btn btn-success\" href=\"signup.php\">Sign Up</a>',
                });";
                unset($_SESSION['login']);
            }
        ?>
    </script>
    <script>
        function moveSlides(direction) {
            const slides = document.querySelector('.slides');
            const slideWidth = slides.clientWidth;
            slides.style.transform = `translateX(${direction * slideWidth}px)`;
        }
    </script>



</body>

</html>