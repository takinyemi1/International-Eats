<?php
    
    session_start();
    include "database.php";

?>

<!-- html -->
<!DOCTYPE html>
<html>
    <head>
        <title>International Eats | password change-password</title>
        <!-- <link href = "./iEats_password_style.css" rel = "stylesheet"> -->

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
        .change-password-input {
            border: none;
            border-bottom: 2px solid #923030;
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

        .change-password-input:focus, .change-password-input:active, .change-password-input:hover {
            background-color: white;
            outline: none;
            color: black;
            border-bottom-color: #ca6565;
        }

        .change-password-modal-content hr {
            border: 1px solid #923030;
            margin-bottom: 25px;
        }

        /* style for buttons */
        .change-password-submit {
            background-color: #923030;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 25%;
            opacity: 0.9;
        }

        .change-password-submit:hover {
            opacity: 3;
        }

        .change-password-submit {
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
            color: #cc8e8e;
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
        .change-password-container-form {
            padding: 16px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        /* modal content box */
        .modal-content-change-password {
            z-index: 1;
            background-color: #cc8e8e;
            /* 15% from the top and centered */
            margin: 5px auto;
            border: 1px solid #831313;
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

        /* change the styles for the cancel button and the change-password button on extra small screens */
        @media screen and (max-width: 300px) {
            .cancel-btn, .change-password-submit {
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
        .modal-change-password {
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
            background-color: #9c1e1e;
            padding-top: 60px;
        }

        #button-icon-change-password {
            color: #831313;
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

        .new-password-title {
            text-align: center;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 18px;
        }

        .change-password-submit {
            background-color: #831313;
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

        .password-profile {
            padding-left: 10px;
            padding-right: 10px;
        }

    </style>

    <body>

        <br><br>

        <!-- earth rotation picture -->
        <div style = "text-align: center;">
            <img src = "./images/change-password.gif" class = "main-img">
        </div>

        <br><br>

        <div class = "main-inteats" style = "text-align: center;">
            <span style = "--i:1">C</span>
            <span style = "--i:2">h</span>
            <span style = "--i:3">a</span>
            <span style = "--i:4">n</span>
            <span style = "--i:5">g</span>
            <span style = "--i:6">e</span>
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

        <!-- to change a password by email, use the hashed password to generate a unique URL -->

        <!-- the change-password modal -->
        <div id = "id01" class = "modal-change-password">
            <div class = "change-password-container-form">
                <div class = "modal-content-change-password">
                    <?php

                        $errors = array();

                        // check if the user isn't logged in and direct them to the login page
                        if (!isset($_SESSION["email"])) {
                            header("Location: login.php");
                            exit();
                        }

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // retrieve the form data
                            $email = $_SESSION["email"];
                            $current_password = $_POST["pass"];
                            $new_password = $_POST["new-pass"];
                            $repeat_new_password = $_POST["re-new-pass"];

                            // fetch the user's data from the database
                            $sql = "SELECT password_hash FROM traveler WHERE email = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s", $email);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();

                            // if there is a row
                            if ($row) {
                                // verify if the current password matches the stored hashed password
                                if (password_verify($current_password, $row["password_hash"])) {
                                    // hash the new password
                                    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                                    if (empty($current_password)) {
                                        array_push($errors, "Current password field cannot be left empty.");
                                    }
        
                                    if (empty($new_password)) {
                                        array_push($errors, "New Password field cannot be left empty.");
                                    }
        
                                    if (empty($repeat_new_password)) {
                                        array_push($errors, "Confirm new password field cannot be left empty");
                                    }

                                    // check that the password contains at least one letter
                                    if (!preg_match("/[a-z]/i", $new_password)) {
                                        array_push($errors, "Password must contain at least one letter.");
                                    }

                                    // now check if the password has at least one number
                                    if (!preg_match("/[0-9]/", $new_password)) {
                                        array_push($errors, "Password must contain at least one number.");
                                    }

                                    // validate the password confirmation field - simply check that the password = repeat_password
                                    if ($new_password !== $repeat_new_password) {
                                        array_push($errors, "Passwords don't match");
                                    }

                                    // if there are errors in the array 
                                    if (count($errors) > 0) {

                                        foreach ($errors as $error) {
                                            echo "<div class = 'text-danger'>
                                                <span class = 'close-btn' onclick = 'alertBox()'>&times;</span>
                                                $error
                                            </div>";
                                        }
                                    } else {
                                        // update the password in the database
                                        $sql_update = "UPDATE traveler SET password_hash = ? WHERE email = ?";
                                        $stmt_update = $conn->prepare($sql_update);
                                        $stmt_update->bind_param("ss", $new_hashed_password, $email);
                                        $stmt_update->execute();

                                        echo "<div class = 'text-success'>
                                            You have successfully changed your password!";
                                        echo '<a href = "iEats_admin_profile.php?email=' . htmlspecialchars($email) . '"> Click here to return to the previous page.</a>';
                                        echo "</div>";
                                    }
                                }

                            } else {
                                // message that the user was not found
                                echo "<div class = 'text-danger'>
                                    User Not Found.
                                </div>";
                            }
                        }
                    ?>
                    <!-- php end -->
                    <form class = "change-password-modal-content" action = "change_password.php" method = "post">
                        <br>
                        <!-- image container -->
                        <div class = "carousel-img" style = "text-align: center;">
                            <div class = "carousel-img-slider">
                                <div class = "carousel-img-slide-track">
                                    <div class = "img">
                                        <img src = "./images/desti1.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/desti2.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/desti3.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/desti4.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/desti5.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/desti6.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/desti7.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/desti8.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/desti9.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/desti10.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/desti11.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/desti12.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/desti13.gif" class = "carousel-image">
                                    </div>
                                    <div class = "img">
                                        <img src = "./images/desti14.gif" class = "carousel-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- image slideshow container ends -->
                        <br>

                        <div class = "new-password-title">
                            <h1>Change Password</h1>
                        </div>
                        <br>
                        <p style = "text-align: center;">Please fill in this form to <b>Change Your Password.</b></p>
                        <hr>

                        <div class = "password-profile">
                            <div class = "change-password-field">
                                <i id = "button-icon-change-password" class = "bi bi-lock-fill"></i>
                                <label for = "pass"><b>Previous Password</b></label>
                                <input type = "password" class = "change-password-input" placeholder = "Enter Previous Password" name = "pass"> <!-- required -->
                            </div>

                            <div class = "change-password-field">
                                <i id = "button-icon-change-password" class = "bi bi-unlock-fill"></i>
                                <label for = "new-pass"><b>New Password</b></label>
                                <input type = "password" class = "change-password-input" placeholder = "Enter New Password" name = "new-pass"> <!-- required -->
                            </div>

                            <div class = "change-password-field">
                                <i id = "button-icon-change-password" class = "bi bi-unlock-fill"></i>
                                <label for = "re-new-pass"><b>Confirm New Password</b></label>
                                <input type = "password" class = "change-password-input" placeholder = "Retype New Password" name = "re-new-pass"> <!-- required -->
                            </div>

                            <div class = "change-password-field">
                                <!-- change-password button -->
                                <hr>
                                <button type = "submit" name = "change-password-submit" class = "change-password-submit">Change Password</button>
                                <br>

                                <div style = "text-align: center;">
                                    <span class = "forgot-password"><a href = "iEats_admin_profile.php">Return to Administration</a></span>
                                </div>
                            </div>

                            <br><br>
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