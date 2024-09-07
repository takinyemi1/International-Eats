<?php 

    session_start();
    include "database.php";

?>

<!-- html -->
<!DOCTYPE html>
<html>
    <head>
        <title>International Eats | Reset Password</title>
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
        .process-password-input {
            border: none;
            border-bottom: 2px solid #e29dbf;
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

        .process-password-input:focus, .process-password-input:active, .process-password-input:hover {
            background-color: white;
            outline: none;
            color: black;
            border-bottom-color: #d34688;
        }

        .process-password-modal-content hr {
            border: 1px solid #8f2675;
            margin-bottom: 25px;
        }

        /* style for buttons */
        .process-password-submit {
            background-color: #e29dbf;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 25%;
            opacity: 0.9;
        }

        .process-password-submit:hover {
            opacity: 3;
        }

        .process-password-submit {
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
        .process-password-container-form {
            padding: 16px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        /* modal content box */
        .modal-content-process-password {
            z-index: 1;
            background-color: #e29dbf;
            /* 15% from the top and centered */
            margin: 5px auto;
            border: 1px solid #8f2675;
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

        /* change the styles for the cancel button and the process-password button on extra small screens */
        @media screen and (max-width: 300px) {
            .cancel-btn, .process-password-submit {
                width: 100%;
            }
        }

        /* for the process-password */
        @media screen and (max-width: 300px) {
            .cancel-btn, .process-password-submit {
                width: 100%;
            }
        }

        /* background of the modal */
        .modal-process-password {
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
            background-color: #d34688;
            padding-top: 60px;
        }

        #button-icon-process-password {
            color: #b42555;
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

        .process-password-traveler-title {
            text-align: center;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 18px;
        }

        .process-password-submit {
            background-color: #b42555;
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

        .process-password-profile {
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
            <span style = "--i:1">N</span>
            <span style = "--i:2">e</span>
            <span style = "--i:3">w</span>
            <span style = "--i:4"> </span>
            <span style = "--i:5">P</span>
            <span style = "--i:6">a</span>
            <span style = "--i:6">s</span>
            <span style = "--i:7">s</span>
            <span style = "--i:8">w</span>
            <span style = "--i:9">o</span>
            <span style = "--i:10">r</span>
            <span style = "--i:11">d</span>
            <span style = "--i:15">.</span>
        </div>

        <br><br>

        <!-- the process-password modal -->
        <div id = "id02" class = "modal-process-password">
            <div class = "process-password-container-form">
                <div class = "modal-content-process-password">

                    <?php

                        $errors = array();

                        //  if the reset password button was clicked
                        // if (isset($_POST["process-password-submit"])) {

                            // get the unique key value
                            $token = $_POST["token"];
                            // rehash the values
                            $token_hash = hash("sha256", $token);

                            // now select the user record where there exists that reset token hash column
                            $sql_select = "SELECT * FROM traveler WHERE reset_unique_key = ?";
                            $stmt_select = mysqli_stmt_init($conn);

                            // bind and prepare the statement
                            mysqli_stmt_prepare($stmt_select, $sql_select);

                            // bind the result
                            $stmt_select->bind_param("s", $token_hash);
                            // execute
                            $stmt_select->execute();

                            // get the result set and an associative array of the user record if it was found
                            $result_select = $stmt_select->get_result();
                            $user = $result_select->fetch_assoc();

                            // if there was no record found, the value will be NULL
                            if ($user === null) {
                                // let the user know that the token wasn't found
                                array_push($errors,"Token value not found.");
                            } 
                            // to check for this, user the stringtotime() function that converts the expiry column to a number of seconds
                            // if it expired, then it will be less than or equal to the current time expressed as a number of seconds
                            elseif (isset($user["reset_unique_key_expiry_time"]) && strtotime($user["reset_unique_key_expiry_time"]) <= time()) {
                                // if that's true the token value has expired
                                array_push($errors, "<b>Invalid Link</b>. The link is invalid/expired. Either the link that was clicked was incorrect, or the key generated has
                                already been used, in which case it is deactivated. 
                                <br>Click the following link to reset your password: <a href = 'http://localhost/IntEats/reset_password.php?key=$token&email=$email'>http://international.eats.com/reset-password.php?key=$token</a>.");

                            } else {
                                // check if the passwords are valid
                                $new_password = $_POST["pass"];
                                $new_repeat_password = $_POST["repass"];

                                if (empty($new_password)) {
                                    array_push($errors, "Password field cannot be left empty");

                                } else {
    
                                    // check the length of the password
                                    if (strlen($new_password) < 8) {
                                        array_push($errors, "Password must be at least 8 characters");
                                    }
    
                                    // check that the password contains at least one letter
                                    if (!preg_match("/[a-z]/i", $new_password)) {
                                        array_push($errors, "Password must contain at least one letter");
                                    }
    
                                    // now check if the password has at least one number
                                    if (!preg_match("/[0-9]/", $new_password)) {
                                        array_push($errors, "Password must contain at least one number");
                                    }
                                }

                                if (empty($new_repeat_password)) {
                                    array_push($errors, "Confirm password field cannot be left empty");
                                }

                                // validate the password confirmation field - simply check that the password = repeat_password
                                if ($new_password !== $new_repeat_password) {
                                    array_push($errors, "Passwords don't match");
                                }

                                // check if there are errors
                                if (count($errors) === 0) {
                                    // hash the new password
                                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                                    // used to identify the user to update the password for
                                    $email = $user["email"];

                                    // update query
                                    $sql_update = "UPDATE traveler SET password_hash = ?, reset_unique_key = NULL, reset_unique_key_expiry_time = NULL
                                                    WHERE email = ?";
                                    $stmt_update = mysqli_stmt_init($conn);

                                    $prepare_stmt = mysqli_stmt_prepare($stmt_update, $sql_update);
                                    
                                    if ($prepare_stmt) {
                                        // bind
                                        mysqli_stmt_bind_param($stmt_update, "ss", $password_hash, $email);
                                        // execute
                                        mysqli_stmt_execute($stmt_update);

                                        // success message
                                        echo "<div class = 'text-success'>
                                            <span class = 'close-btn' onclick = 'alertBox()'>&times;</span>
                                            Password has been successfully updated. You can now <a href = 'login.php'>Login</a>.
                                        </div>";

                                    } else {
                                        array_push($errors, "Something went wrong."); 
                                    }
                                }
                            }

                            // display the errors
                            if (!empty($errors)) {

                                foreach ($errors as $error) {
                                    echo "<div class = 'text-danger'>
                                        <span class = 'close-btn' onclick = 'alertBox()'>&times;</span>
                                        $error
                                    </div>";
                                }
    
                            }
                        // }
                    ?>
                    <!-- content in the modal -->
                    <form class = "process-password-modal-content" action = "process_reset_password.php" method = "post">
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

                        <div class = "process-password-traveler-title">
                            <h1 style = "text-align: center;">New Password</h1>
                        </div>

                        <br>
                        <p style = "text-align: center;">Please enter your <b>New Password.</b></p>
                        <hr>

                        <div class = "process-password-profile">

                            <div class = "process-password-field" style = "text-align: center;">
                                <i id = "button-icon-process-password" class = "bi bi-save-fill"></i>
                                <!-- <label for = "pass"><b>Unique Key</b></label> -->
                                <input type = "hidden" name = "token" value = "<?= htmlspecialchars($token) ?>">
                            </div>

                            <br>
                            
                            <div class = "process-password-field">
                                <i id = "button-icon-process-password" class = "bi bi-unlock-fill"></i>
                                <label for = "pass"><b>New Password</b></label>
                                <input type = "password" class = "process-password-input" placeholder = "Enter Password" name = "pass">
                            </div>

                            <div class = "process-password-field">
                                <i id = "button-icon-process-password" class = "bi bi-unlock-fill"></i>
                                <label for = "repass"><b>Confirm Password</b></label>
                                <input type = "password" class = "process-password-input" placeholder = "Confirm Password" name = "repass">
                            </div>

                            <div class = "process-password-field">
                                <hr>
                                <!-- process-password button -->
                                <button type = "submit" name = "process-password-submit" class = "process-password-submit">Reset Password</button>
                                <!-- <br><br><br>     -->
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