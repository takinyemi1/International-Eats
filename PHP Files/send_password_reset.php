<?php 

    session_start();
    include "database.php";

?>

<!-- html -->
<!DOCTYPE html>
<html>
    <head>
        <title>International Eats | Send Password Reset</title>
        <!-- <link href = "./iEats_traveler_style.css" rel = "stylesheet"> -->

        <meta charset = "UTF-8">

        <!-- icon fonts stylesheet -->
        <link rel="stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    </head>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abel&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            background-color: #e2f5eb;
            font-family: "Abel"; 
        }

        .footer {
            /* position: fixed; */
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #e2f5eb;
            color: black;
            text-align: center;
        }

        /* input fields */
        .forgot-password-input {
            border: none;
            border-bottom: 2px solid #8a89e0;
            width: 100%;
            padding: 15px;
            padding: 24px;
            font-weight: bold;
            transition: .2s;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: none;
            font-family: "Abel";
            color: black;
        }

        .forgot-password-input:focus, .forgot-password-input:active, .forgot-password-input:hover {
            background-color: white;
            outline: none;
            color: black;
            border-bottom-color: #8f46d3;
        }

        .forgot-password-modal-content hr {
            border: 1px solid #5c268f;
            margin-bottom: 25px;
        }

        /* style for buttons */
        .forgot-password-submit {
            background-color: #b29ec0;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 25%;
            opacity: 0.9;
        }

        .forgot-password-submit:hover {
            opacity: 3;
        }

        .forgot-password-submit {
            float: left;
            width: 100%;
        }

        .main-inteats {
            position: relative;
        }

        .main-inteats span {
            position: relative;
            display: inline-block;
            font-size: 40px;
            font-weight: 700;
            color: #3f7744;
            text-transform: uppercase;
            animation: flip 2s infinite;
            animation-delay: calc(.2s * var(--i))
        }

        @keyframes flip {
            0%, 80% {
                transform: rotateY(360deg)
            }
        }

        /* add padding the container elements */
        .forgot-password-container-form {
            padding: 16px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        /* modal content box */
        .modal-content-forgot-password {
            z-index: 1;
            background-color: #8a89e0;
            /* 15% from the top and centered */
            margin: 5px auto;
            border: 1px solid #8f46d3;
            width: 100%;
            border-radius: 8px;
        }

        .main-img {
            border-radius: 400px;
            width: 200px;
            height: 200px;
        }

        /* clear the floats */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        /* change the styles for the cancel button and the forgot-password button on extra small screens */
        @media screen and (max-width: 300px) {
            .cancel-btn, .forgot-password-submit {
                width: 100%;
            }
        }

        /* for the forgot-password */
        @media screen and (max-width: 300px) {
            .cancel-btn, .forgot-password-submit {
                width: 100%;
            }
        }

        /* background of the modal */
        .modal-forgot-password {
            /* position: fixed; */
            z-index: 1;
            /* left: 25%; */
            /* top: 5%; */
            width: 80%;
            height: 70%;
            border-radius: 10px;
            margin: auto;
            /* scroll enabled if needed */
            overflow: auto;
            background-color: #5c268f;
            padding-top: 60px;
        }

        #button-icon-forgot-password {
            color: #8f46d3;
            font-size: 25px;
        }

        .carousel-img {
            align-items: center;
            display: flex;
            justify-content: center;
            height: 15vh;
        }

        /* to have the styling for the image classes to work, you must first call the further outside
        container and then the actual class of the images */
        .carousel-img .carousel-image {
            margin: 0 auto;
            width: 80px;
            height: 80px;
            border-radius: 50px;
            display: flex;
        }

        .carousel-img-slider {
            height: 110px;
            margin: auto;
            overflow: hidden;
            position: relative;
            width: 80%;
        }

        .carousel-img-slider .carousel-img-slide-track {
            animation: scroll 200s linear infinite;
            display: flex;
            animation-iteration-count: infinite; /* ensures an infinite loop */
        }

        .carousel-img-slider .img {
            height: 80px;
            width: 80px;
            margin-right: 10px;
        }

        @-webkit-keyframes scroll {
            0% {
                transform: translateX(0);
            } 100% {
                transform: translateX(calc(-250px * 7));
            }
        }

        @keyframes scoll {
            0% {
                transform: translateX(0);
            } 100% {
                transform: translateX(calc(-250px * 7));
            } 100.1% { /* adds a kayeframe immediately after the last image */
                transform: translateX(0); /* resets the translation back to the initial position */
            }
        }

        .forgot-password-traveler-title {
            text-align: center;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 18px;
        }

        .forgot-password-submit {
            background-color: #8f46d3;
        }

        .text-danger {
            padding: 20px;
            background-color: #f44336;
            color: white;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .text-success {
            padding: 20px;
            background-color: #63b354;
            color: white;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 15px;
        }

        /* close button */
        .close-btn {
            margin-left: 15px;
            color: white;
            font-weight: 700;
            float: right;
            font-size: 15px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .close-btn:hover {
            color: black;
        }

        .forgot-password-profile {
            padding-left: 10px;
            padding-right: 10px;
        }

    </style>

    <body>

        <br><br>

        <!-- earth rotation picture -->
        <div style = "text-align: center;">
            <img src = "./images/reset-password.gif" class = "main-img">
        </div>

        <br><br>

        <div class = "main-inteats" style = "text-align: center;">
            <span style = "--i:1">F</span>
            <span style = "--i:2">o</span>
            <span style = "--i:3">r</span>
            <span style = "--i:4">g</span>
            <span style = "--i:5">o</span>
            <span style = "--i:6">t</span>
            <span style = "--i:6"> </span>
            <span style = "--i:7">P</span>
            <span style = "--i:8">a</span>
            <span style = "--i:9">s</span>
            <span style = "--i:10">s</span>
            <span style = "--i:11">w</span>
            <span style = "--i:12">o</span>
            <span style = "--i:13">r</span>
            <span style = "--i:14">d</span>
            <span style = "--i:15">.</span>
        </div>

        <br><br>

        <!-- the forgot-password modal -->
        <div id = "id02" class = "modal-forgot-password">
            <div class = "forgot-password-container-form">
                <div class = "modal-content-forgot-password">

                    <?php

                        use PHPMailer\PHPMailer\PHPMailer;
                        use PHPMailer\PHPMailer\SMTP;
                        use PHPMailer\PHPMailer\Exception;

                        require 'mail/Exception.php';
                        require 'mail/PHPMailer.php';
                        require 'mail/SMTP.php';
                        require "vendor/autoload.php";

                        $errors = array();

                        // if (isset($_POST["email"]) && (!empty($_POST["email"]))) {
                        // if ($_SERVER["REQUEST_METHOD"] == "POST") { 
                        if (isset($_POST["forgot-password-submit"])) {
                            // retrieve the email form data
                            $email = $_POST["email"];

                            // validate the email
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                array_push($errors, "Please enter a valid email address.");
                            }

                            // check if the email exists
                            $sql_select = "SELECT * FROM traveler WHERE email = ?";
                            $stmt_select = mysqli_stmt_init($conn);

                            if (mysqli_stmt_prepare($stmt_select, $sql_select)) {
                                mysqli_stmt_bind_param($stmt_select, "s", $email);
                                mysqli_stmt_execute($stmt_select);
                                mysqli_stmt_store_result($stmt_select);

                                // check if there are any rows with that address
                                if (mysqli_stmt_num_rows($stmt_select) == 0) {
                                    // if there isn't an email matching the one entered
                                    array_push($errors, "Email Not Found");
                                } 

                                // check if there are any errors in the array
                                if (count($errors) > 0) {

                                    foreach ($errors as $error) {
                                        echo "<div class = 'text-danger'>
                                            <span class = 'close-btn' onclick = 'alertBox()'>&times;</span>
                                            $error
                                        </div>";
                                    }

                                } else {

                                    // token value that will contain characters to be used in the URL through the random bytes function which will return unprintable characters
                                    // convert to a hexadecimal string
                                    $token = bin2hex(random_bytes(16));

                                    // for extra security, store a hash of the value using the sha-256 algorithm
                                    $token_hash = hash("sha256", $token);

                                    // expiration value that will make the token valid for only a short amount of time
                                    // if it does expire, the user can just request another one
                                    // time function represents the current time as a number of seconds
                                    $expiry_tine = date("Y-m-d H:i:s", time() + 60 * 30);

                                    // sql query
                                    $sql_update = "UPDATE traveler
                                                    SET reset_unique_key = ?, reset_unique_key_expiry_time = ?
                                                    WHERE email = ?";
                                    $stmt_update = mysqli_stmt_init($conn);

                                    // if an error occurs, this will return false
                                    $prepare_stmt = mysqli_stmt_prepare($stmt_update, $sql_update);

                                    if ($prepare_stmt) {
                                        // bind the values
                                        mysqli_stmt_bind_param($stmt_update, "sss", $token_hash, $expiry_tine, $email);
                                        // execute
                                        mysqli_stmt_execute($stmt_update);

                                        // instantiate PHPMailer and pass true to enable exceptions
                                        $mail = new PHPMailer(true);

                                        try {
                                            // server settings
                                            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // enable verbose debug output
                                            // send using SMTP
                                            $mail->isSMTP();
                                            // set the SMTP server to send through
                                            $mail->Host = 'smtp.gmail.com';
                                            // enable SMTP authentication
                                            $mail->SMTPAuth = true;
                                            // SMTP username
                                            $mail->Username = "international.eats.23@gmail.com";
                                            // SMTP password
                                            // $mail->Password = "hSecur1tty._";
                                            $mail->Password = "nkzb lqfb betf dkyt";
                                            // enable TLS excryption
                                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                                            // TCP port to connect to, use 465 for 'PHPMailer::ENCRYPTION_SMTPS' above
                                            $mail->Port = 587;
                                            
                                            // receipients
                                            $mail->setFrom("international.eats.23@gmail.com", "International Eats");
                                            // email to
                                            $mail->addAddress($email);

                                            // content
                                            $mail->isHTML(true);
                                            // set email format to HTML
                                            $mail->Subject = "Password Reset";
                                            // compose the email message
                                            // $message = "Click the following link to reset your password: ";
                                            // $reset_link = "<a href = 'http://localhost/IntEats/reset_password.php?key=" . $unique_key . "&email=" . $email . "&action=reset'>http://international.eats.com/reset_password.php?key=" . $unique_key . "&email=" . $email . "&action=reset</a>.";

                                            // use an absolute url
                                            // don't user double quotes
                                            $mail->Body = <<<END
                                            
                                                Click the follwing link to reset your password: <a href = 'http://localhost/IntEats/reset_password.php?token=$token&email=$email'>http://international.eats.com/reset-password.php?token=$token</a> 

                                            END;
                                            // the file to reset the password 

                                            // send the email
                                            $mail->send();

                                            // let the user know that the message has been sent
                                            echo "<div class = 'text-success'>
                                                <span class = 'close-btn' onclick = 'alertBox()'>&times</span>
                                                Message has been sent. Please check your inbox.
                                            </div>";

                                        } catch (Exception $e) {
                                            // tell the user that the message has not been sent
                                            echo "<div class = 'text-danger'>
                                                <span class = 'close-btn' onclick = 'alertBox()'>&times</span>
                                                Message could not be sent. Mailer Error: {$mail->ErrorInfo}
                                            </div>";
                                        }

                                    } else { // error in preparing the statement
                                        echo "<div class = 'text-danger'>
                                            <span class = 'close-btn' onclick = 'alertBox()'>&times</span>
                                            Something went wrong.
                                        </div>";
                                    } 
                                }

                            } else {
                                // error in preparing the select statement
                                echo "<div class = 'text-danger'>
                                    <span class = 'close-btn' onclick = 'alertBox()'>&times</span>
                                    Something went wrong.
                                </div>";
                            }   
                        }
                    ?>
                    <!-- php ends -->

                    <!-- content in the modal -->
                    <form class = "forgot-password-modal-content" action = "send_password_reset.php" method = "post">
                        <br>
                        <!-- image container -->
                        <div class = "carousel-img" style = "text-align: center;">
                            <div class = "carousel-img-slider">
                                <div class = "carousel-img-slide-track">
                                    <div class = "img">
                                        <img src = "./images/broccoli_gif.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/food1.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/food2.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/food3.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/food4.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/food5.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/food6.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/food7.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/food8.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/food9.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/food10.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/food11.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/food12.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/food13.gif" class = "carousel-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- image slideshow container ends -->
                        <br>

                        <div class = "forgot-password-traveler-title">
                            <h1 style = "text-align: center;">Forgot Password</h1>
                        </div>

                        <br>
                        <p style = "text-align: center;">Please enter your email to <b>Reset Your Password.</b></p>
                        <hr>

                        <div class = "forgot-password-profile">
                            <div class = "forgot-password-field">
                                <i id = "button-icon-forgot-password" class = "bi bi-envelope-paper-fill"></i>
                                <label for = "email"><b>Email</b></label>
                                <input type = "email" class = "forgot-password-input" placeholder = "email@example.com" name = "email">
                            </div>

                            <div class = "forgot-password-field">
                                <hr>
                                <!-- forgot-password button -->
                                <button type = "submit" name = "forgot-password-submit" class = "forgot-password-submit">Send Password</button>
                                <!-- <br><br><br>     -->
                                <br>
                            </div>
                            <br>
                            <!-- button to return to login -->
                            <div style = "text-align: center;">
                                <span class = "forgot-password"><a href = "login.php">Return to Login</a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <br><br>

        <!-- footer  begins -->
        <hr>
        <footer class = "footer">
            <a href = "iEats_homepage_intro.php"><img src = "./images/iEats_logo.png" width = "35" height = "35"></a><span style = "font-size: medium;">International Eats | &copy; 2024 Copyright</span>
        </footer>
        <!-- footer ends -->

        <script>
            function alertBox() {
                this.parentElement.style.display = "none";
            }
        </script>
    </body>
</html>