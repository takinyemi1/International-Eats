<?php

    session_start();

    // if the user is already logged in, redirect them to the homepage
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("Location: iEats_homepage_intro.php");
        exit;
    }

    include "database.php";

    $errors = array();

    // process the form data when submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["login-submit"])) {

            // check if the email field is empty
            if (empty($_POST["email"])) {
                array_push($errors, "Email field cannot be left empty");

            } else {
                $email = $_POST["email"];
            }

            // check if the password field is empty
            if (empty($_POST["pass"])) {
                array_push($errors, "Password field cannot be left empty");

            } else {
                $password = $_POST["pass"];
            }

            // validate the credentials
            if (count($errors) == 0) {
                // prepare the select statement
                $sql = "SELECT email, password_hash FROM traveler WHERE email = ?";
                $stmt = mysqli_prepare($conn, $sql);

                if ($stmt) {
                    // bind variables to the prepared statement as parameteres
                    mysqli_stmt_bind_param($stmt, "s", $param_email);

                    // set the parameters
                    $param_email = $email;

                    // attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        // store the result
                        mysqli_stmt_store_result($stmt);

                        // check if the email exists, and if so, verify the password
                        if (mysqli_stmt_num_rows($stmt) == 1) {
                            // bind the result variables
                            mysqli_stmt_bind_result($stmt, $email, $password_hash);

                            if (mysqli_stmt_fetch($stmt)) { 
                                if (password_verify($password, $password_hash)) {

                                    // if the password is correct, start a new session
                                    session_start();

                                    // store the data in session variables
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["email"] = $email;

                                    // redirect the user to the loading page, which when done, will direct to the homepage
                                    header("Location: iEats_homepage_intro.php");

                                } else {
                                    // if the password is invalid, display an error message
                                    array_push($errors, "Invalid email or password.");
                                }
                            }

                        } else {
                            // if the email doesn't exist, display an error message
                            array_push($errors, "Invalid email or password.");
                        }
                        
                    } else {
                        array_push($errors, "Something went wrong. Please try again.");
                    }

                    // close the statement
                    mysqli_stmt_close($stmt);
                }
            }
            // close the connection
            mysqli_close($conn);
        }
    }

?>

<!-- html -->
<!DOCTYPE html>
<html>
    <head>
        <title>International Eats | Traveler Login</title>
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
        .login-input {
            border: none;
            border-bottom: 2px solid #cde089;
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

        .login-input:focus, .login-input:active, .login-input:hover {
            background-color: white;
            outline: none;
            color: black;
            border-bottom-color: #748f29;
        }

        .login-modal-content hr {
            border: 1px solid #3d771c;
            margin-bottom: 25px;
        }

        /* style for buttons */
        .login-submit {
            background-color: #97a09c;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 25%;
            opacity: 0.9;
        }

        .login-submit:hover {
            opacity: 3;
        }

        .login-submit {
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
        .login-container-form {
            padding: 16px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        /* modal content box */
        .modal-content-login {
            z-index: 1;
            background-color: #99d178fa;
            /* 15% from the top and centered */
            margin: 5px auto;
            border: 1px solid #7bb46d;
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

        /* change the styles for the cancel button and the login button on extra small screens */
        @media screen and (max-width: 300px) {
            .cancel-btn, .login-submit {
                width: 100%;
            }
        }

        /* for the login */
        @media screen and (max-width: 300px) {
            .cancel-btn, .login-submit {
                width: 100%;
            }
        }

        /* background of the modal */
        .modal-login {
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
            background-color: #3d771c;
            padding-top: 60px;
        }

        #button-icon-login {
            color: #4678c4;
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

        .experienced-traveler-title {
            text-align: center;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 18px;
        }

        .login-submit {
            background-color: #4678c4;
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

        .login-profile {
            padding-left: 10px;
            padding-right: 10px;
        }

    </style>

    <body>

        <br><br>

        <!-- earth rotation picture -->
        <div style = "text-align: center;">
            <img src = "./images/earth_rotate.gif" class = "main-img">
        </div>

        <br><br>

        <div class = "main-inteats" style = "text-align: center;">
            <span style = "--i:1">I</span>
            <span style = "--i:2">n</span>
            <span style = "--i:3">t</span>
            <span style = "--i:4">e</span>
            <span style = "--i:5">r</span>
            <span style = "--i:6">n</span>
            <span style = "--i:6">a</span>
            <span style = "--i:7">t</span>
            <span style = "--i:8">i</span>
            <span style = "--i:9">o</span>
            <span style = "--i:10">n</span>
            <span style = "--i:11">a</span>
            <span style = "--i:12">l</span>
            <span style = "--i:13">E</span>
            <span style = "--i:14">a</span>
            <span style = "--i:15">t</span>
            <span style = "--i:16">s</span>
            <span style = "--i:17">.</span>
        </div>

        <br><br>

        <!-- the login modal -->
        <div id = "id02" class = "modal-login">
            <div class = "login-container-form">
                <div class = "modal-content-login">

                    <?php 

                        if (count($errors) > 0) {

                            foreach ($errors as $error) {
                                echo "<div class = 'text-danger'>
                                    <span class = 'close-btn' onclick = 'alertBox()'>&times;</span>
                                    $error
                                </div>";
                            }

                        } elseif (isset($_POST["login-submit"])) {
                            echo "<div class = 'text-danger'>
                                <span class = 'close-btn' onclick = 'alertBox()'>&times;</span>
                                Invalid email or password.
                            </div>";
                        }

                    ?>

                    <!-- php ends -->

                    <!-- content in the modal -->
                    <form class = "login-modal-content" action = "login.php" method = "post">
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

                        <div class = "experienced-traveler-title">
                            <h1 style = "text-align: center;">Experienced Traveler</h1>
                        </div>

                        <br>
                        <p style = "text-align: center;">Welcome back to <b>International Eats.</b></p>
                        <hr>

                        <div class = "login-profile">
                            <div class = "login-field">
                                <i id = "button-icon-login" class = "bi bi-envelope-at-fill"></i>
                                <label for = "email"><b>Email</b></label>
                                <input type = "email" class = "login-input" placeholder = "Enter Email" name = "email" autocomplete = "off">
                            </div>

                            <div class = "login-field">
                                <i id = "button-icon-login" class = "bi bi-lock-fill"></i>
                                <label for = "pass"><b>Password</b></label>
                                <input type = "password" class = "login-input" placeholder = "Enter Password" name = "pass" autocomplete = "off">
                            </div>

                            <div class = "login-field">
                                <label for = "remember-login">
                                    <input type = "checkbox" name = "remember-login" value = "remember-login"> Remember Me?
                                </label>

                                <br><br>

                                <hr>
                                <div style = "text-align: right;">
                                    <span class = "forgot-password"><a href = "send_password_reset.php">Forgot Password?</a></span>
                                    <br><br>
                                </div>

                                <!-- login button -->
            
                                <button type = "submit" name = "login-submit" class = "login-submit">Login</button>

                                <br><br><br>
                                
                                <div style = "text-align: center;">
                                    <br>
                                    <span>Not an Experienced Traveler? <b>Create an account <a href = "register_process.php"><i style = "color: #4678c4;" class = "bi bi-arrow-right"></i></a></b></span>
                                </div>
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