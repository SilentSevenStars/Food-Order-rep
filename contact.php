<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;

        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;
        $mail->Username = "kentjustine.mercado@clsu2.edu.ph";
        $mail->Password = "ksvavpmwlkjzinzn";

        $mail->isHTML(true);
        $mail->setFrom($email, $name);
        $mail->addAddress("kentjustine.mercado@clsu2.edu.ph");

        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-...">
    <link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        .contact{
            width: 60%;
            padding: 45px;
            border-radius: 0;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

        <div class="container contact">
            <div class="row shadow-sm">
                <div class="col-md-7 p-5">
                    <form action="" method="POST">
                        <h4>Get in touch</h4>
                        <div class="mb-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Your subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Message</label>
                            <textarea name="message" id="" cols="30" rows="10" class="form-control" placeholder="Your message" required></textarea>
                        </div>
                        <input type="submit" value="send" name="send" class="btn btn-primary">
                    </form>
                </div>
                <div class="col-md-5 bg-warning p-4">
                    <h4>Contact Us</h4>
                    <div class="mt-5">
                        <hr class="mb-2">
                        <div class="d-flex"> 
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            <p>Lupao, Nueva Ecija</p>
                        </div>
                        <hr class="mb-2">
                        <div class="d-flex"> <hr>
                            <i class="bi bi-envelope-at-fill me-2"></i>
                            <p>Foodies@gmail.com</p>
                        </div>
                        <hr class="mb-2">
                        <div class="d-flex"> <hr>
                            <i class="bi bi-telephone-fill me-2"></i>
                            <p>+63911-123-1234</p>
                        </div> 
                        <hr class="mb-2">
                    </div>
                </div>
        </div>
    </div>
</body>
</html>