<?php
    
    session_start();

    // if the user is loogged in, redirect them to the homepage
    if (isset($_SESSION["user_id"])) {

        header("Location: iEats_homepage_intro.php");
    }

    include "database.php";

?>

<!-- html -->
<!DOCTYPE html>
<html>
    <head>
        <title>International Eats | Traveler SignUp</title>
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
        .signup-input {
            border: none;
            border-bottom: 2px solid #93e089;
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

        .signup-input:focus, .signup-input:active, .signup-input:hover {
            background-color: white;
            outline: none;
            color: black;
            border-bottom-color: #3f7744;
        }

        .signup-modal-content hr {
            border: 1px solid #7fbfe4;
            margin-bottom: 25px;
        }

        /* style for buttons */
        .signup-submit {
            background-color: #97a09c;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 25%;
            opacity: 0.9;
        }

        .signup-submit:hover {
            opacity: 3;
        }

        .signup-submit {
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
        .signup-container-form {
            padding: 16px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        /* modal content box */
        .modal-content-signup {
            z-index: 1;
            background-color: #b1e1f0fa;
            /* 15% from the top and centered */
            margin: 5px auto;
            border: 1px solid #97dce6;
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

        /* change the styles for the cancel button and the signup button on extra small screens */
        @media screen and (max-width: 300px) {
            .cancel-btn, .signup-submit {
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
        .modal-signup {
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
            background-color: #7fbfe4;
            padding-top: 60px;
        }

        #button-icon-signup {
            color: #3f7744;
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

        .new-traveler-title {
            text-align: center;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 18px;
        }

        .signup-submit {
            background-color: #3f7744;
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

        .register-profile {
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
            <span style = "--i:1">R</span>
            <span style = "--i:2">e</span>
            <span style = "--i:3">g</span>
            <span style = "--i:4">i</span>
            <span style = "--i:5">s</span>
            <span style = "--i:6">t</span>
            <span style = "--i:6">r</span>
            <span style = "--i:7">a</span>
            <span style = "--i:8">t</span>
            <span style = "--i:9">i</span>
            <span style = "--i:10">o</span>
            <span style = "--i:11">n</span>
            <span style = "--i:12">.</span>
        </div>

        <br><br>

        <!-- the signup modal -->
        <div id = "id01" class = "modal-signup">
            <div class = "signup-container-form">
                <div class = "modal-content-signup">
                    <!-- content in the modal -->
                    <?php

                        // error messages should be placed in an array
                        $errors = array();

                        // if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // check if the form has been submitted
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup-submit"])) {

                            if (empty($_POST["email"]) && empty($_POST["uname"]) && empty($_POST["fname"]) && empty($_POST["lname"]) && empty($_POST["favfood"]) && empty($_POST["profile_img"])) {
                                array_push($errors,"All fields are required.");

                            } else {
                                // check for each field individually
                                if (empty($_POST["email"])) {
                                    array_push($errors, "Email field cannot be left empty.");
    
                                } else {
                                    $email = mysqli_real_escape_string($conn, $_POST["email"]);
                                    // validate the email
                                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        array_push($errors, "Please enter a valid email address.");
                                    }
                                }
    
                                if (empty($_POST["uname"])) {
                                    array_push($errors, "Username field cannot be left empty.");
    
                                } else {
                                    $user = mysqli_real_escape_string($conn, $_POST["uname"]);
                                    // validate the username
                                    if (!preg_match('/^[a-zA-Z0-9_]+$/', $user)) {
                                        array_push($errors, "Username can only contain letters, numbers, and underscores.");
                                    }
                                }
    
                                if (empty($_POST["fname"])) {
                                    array_push($errors, "First name field cannot be left empty.");
    
                                } else {
                                    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    
                                    if (!preg_match("/^[a-zA-Z\s']+$/", $fname)) {
                                        array_push($errors, "First name can only contain letters.");
                                    }
                                }
    
                                if (empty($_POST["lname"])) {
                                    array_push($errors, "Last name field cannot be left empty.");
    
                                } else {
                                    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    
                                    if (!preg_match("/^[a-zA-Z\s']+$/", $lname)) {
                                        array_push($errors, "Last name can only contain letters.");
                                    }
                                }
    
                                if (empty($_POST["pass"])) {
                                    array_push($errors, "Password field cannot be left empty.");
    
                                } else {
                                    $password = mysqli_real_escape_string($conn, $_POST["pass"]);
    
                                    // check the length of the password
                                    if (strlen($password) < 8) {
                                        array_push($errors, "Password must be at least 8 characters.");
                                    }
    
                                    // check that the password contains at least one letter
                                    if (!preg_match("/[a-z]/i", $password)) {
                                        array_push($errors, "Password must contain at least one letter.");
                                    }
    
                                    // now check if the password has at least one number
                                    if (!preg_match("/[0-9]/", $password)) {
                                        array_push($errors, "Password must contain at least one number.");
                                    }
                                }
    
                                if (empty($_POST["repass"])) {
                                    array_push($errors, "Confirm password field cannot be left empty.");
                                } else {
                                    $repeat_password = mysqli_real_escape_string($conn, $_POST["repass"]);
                                }
    
                                if (empty($_POST["favfood"])) {
                                    array_push($errors, "Favorite Food field cannot be left empty.");
    
                                } else {
                                    $favfood = mysqli_real_escape_string($conn, $_POST["favfood"]);
    
                                    if (!preg_match("/^[a-zA-Z\s']+$/", $favfood)) {
                                        array_push($errors, "Favorite food can only contain letters.");
                                    }
                                }
    
                                if (!empty($_POST["pnum"])) {
                                    $pnum = mysqli_real_escape_string($conn, $_POST["pnum"]);
    
                                    if (!preg_match('/^[0-9-_]+$/', $pnum)) {
                                        array_push($errors, "Phone number can only contain numbers.");
                                    }
                                }

                                // validate the password confirmation field - simply check that the password = repeat_password
                                if ($password !== $repeat_password) {
                                    array_push($errors, "Passwords don't match.");
                                }

                                // hash the password
                                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                                $profile_img = "profile_img";
                                include "image_file_validation.php";

                                // upload the profile image
                                if (!empty($_FILES[$profile_img]["name"])) {
                                    insertValidateImage($profile_img, $errors);
                                } else { // let the user know that there was no image found
                                    array_push($errors, "No profile image found.");
                                }
                            }

                            // make sure that the email or the username isn't repeated
                            // check if it already exists
                            $sql_check = "SELECT * FROM traveler WHERE email = ? OR username = ?";
                            $stmt_check = mysqli_stmt_init($conn);

                            if (mysqli_stmt_prepare($stmt_check, $sql_check)) {
                                mysqli_stmt_bind_param($stmt_check, "ss", $email, $user);
                                mysqli_stmt_execute($stmt_check);
                                mysqli_stmt_store_result($stmt_check);

                                if (mysqli_stmt_num_rows($stmt_check) > 0) {
                                    // if the email or username already exists, display the error message
                                    array_push($errors, "Email or username already exists");
                                }
                                // proceed if both are different and unique
                                // if the length of errors is greater than 0 (not empty), display the errors
                                if (count($errors) > 0) {

                                    foreach ($errors as $error) {
                                        echo "<div class = 'text-danger'>
                                            <span class = 'close-btn' onclick = 'alertBox()'>&times;</span>
                                            $error
                                        </div>";
                                    }

                                } else {

                                    $sql_insert = "INSERT INTO traveler(email, username, first_name, last_name, password_hash, phone_number, favorite_food, profile_image)
                                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                                    $stmt_insert = mysqli_stmt_init($conn);

                                    // if an error occurs, this will return false
                                    $prepare_stmt = mysqli_stmt_prepare($stmt_insert, $sql_insert);

                                    if ($prepare_stmt) {
                                        // bind the values
                                        mysqli_stmt_bind_param($stmt_insert, "ssssssss", $email, $user, $fname, $lname, $password_hash, $pnum, $favfood, $new_img_name);
                                        // execute
                                        mysqli_stmt_execute($stmt_insert);

                                        echo "<div class = 'text-success'>
                                            <span class = 'close-btn' onclick = 'alertBox()'>&times;</span>
                                            You have successfully created an account with International Eats! <span class = 'login-btn'><u><b><a href = 'login.php'>Login</a></b></u></span>.
                                        </div>"; 

                                    } else {
                                        // error in preparing the insert statement
                                        echo "<div class = 'text-danger'>
                                            <span class = 'close-btn' onclick = 'alertBox()'>&times;</span>
                                            Something went wrong.
                                        </div>";
                                    }
                                }
                                // }
                            } else {
                                // error in preparing the select statement
                                echo "<div class = 'text-danger'>
                                    <span class = 'close-btn' onclick = 'alertBox()'>&times;</span>
                                    Something went wrong.
                                </div>";
                            }
                        }
                        // }
                    ?>
                    <!-- php end -->
                    <form class = "signup-modal-content" action = "register_process.php" method = "post" enctype = "multipart/form-data">
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

                        <div class = "new-traveler-title">
                            <h1>New Traveler</h1>
                        </div>
                        <br>
                        <p style = "text-align: center;">Please fill in this form to create an account with <b>International Eats.</b></p>
                        <hr>

                        <div class = "register-profile">
                            <div class = "signup-field">
                                <i id = "button-icon-signup" class = "bi bi-envelope-at-fill"></i>
                                <label for = "email"><b>Email</b></label>
                                <input type = "email" class = "signup-input" placeholder = "someone@example.com" name = "email"> <!-- required -->
                            </div>

                            <div class = "signup-field">
                                <i id = "button-icon-signup" class = "bi bi-person-badge-fill"></i>
                                <label for = "username"><b>Username</b></label>
                                <input type = "text" class = "signup-input" placeholder = "jdoe11" name = "uname"> <!-- required -->
                            </div>

                            <div class = "signup-field">
                                <i id = "button-icon-signup" class = "bi bi-person-fill"></i>
                                <label for = "fname"><b>First Name</b></label>
                                <input type = "text" class = "signup-input" placeholder = "John" name = "fname">
                            </div>

                            <div class = "signup-field">
                                <i id = "button-icon-signup" class = "bi bi-person-fill"></i>
                                <label for = "lname"><b>Last Name</b></label>
                                <input type = "text" class = "signup-input" placeholder = "Doe" name = "lname">
                            </div>

                            <div class = "signup-field">
                                <i id = "button-icon-signup" class = "bi bi-lock-fill"></i>
                                <label for = "pass"><b>Password</b></label>
                                <input type = "password" minlength = "8" maxlength = "16" class = "signup-input" placeholder = "Enter Password" name = "pass">
                            </div>

                            <div class = "signup-field">
                                <i id = "button-icon-signup" class = "bi bi-lock-fill"></i>
                                <label for = "repass"><b>Confirm Password</b></label>
                                <input type = "password" minlength = "8" maxlength = "16" class = "signup-input" placeholder = "Confirm Password" name = "repass">
                            </div>

                            <div class = "signup-field">
                                <i id = "button-icon-signup" class = "bi bi-telephone-fill"></i>
                                <label for = "pnum"><b>Phone Number</b> ~ Optional</label>
                                <input type = "text" class = "signup-input" placeholder = "XXX-XXX-XXXX" name = "pnum">
                            </div>

                            <div class = "signup-field">
                                <i id = "button-icon-signup" class = "bi bi-star-fill"></i>
                                <label for = "favfood"><b>Favorite Food</b></label>
                                <input type = "text" class = "signup-input" placeholder = "Pasta" name = "favfood">
                            </div>

                            <div class = "signup-field">
                                <i id = "button-icon-signup" class = "bi bi-person-square"></i>
                                <label for = "profile_img"><b>Profile Picture</b></label>
                                <br>
                                <input type = "file" class = "signup-input" name = "profile_img" accept = ".jpg, .jpeg, .png, .gif">
                                <!-- display either the user uploaded image or the default image -->
                                <?php if (empty($_FILES[$profile_img]["name"])) : ?>
                                    <!-- if there's no new file chosen, display the current profile image -->
                                    <img src = "<?php echo $img_destination; ?>" class = "previous-profile-image" width = "100" height = "100">
                                <?php else : ?>
                                    <!-- if a new file is chosen, display the chosen file -->
                                    <img src = "<?php echo $img_destination ?>" class = "previous-profile-image" style = "display: none;" width = "100" height = "100">
                                    <!-- check if the image destination exists -->
                                    <?php if (isset($img_destination) && file_exists($img_destination)) : ?>
                                        <img src = "<?php echo $img_destination ?>" class = "previous-profile-image" width = "100" height = "100">
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                            </div>

                            <div class = "signup-field">
                                <label for = "agree-form">
                                    <input type = "checkbox" name = "agree-form" value = "yes" required> I agree with the <a href = "#" title = "terms of services">Terms of Services</a>.
                                </label>
            
                                <br>
            
                                <label for = "alerts-signup">
                                    <input type = "checkbox" name = "alerts-signup" value = "alerts-signup"> I agree to sign up for weekly updates about newly added 
                                    information to Destination and Find Your Food.
                                </label>
            
                                <br><br>
                                <!-- signup button -->
                                <hr>
            
                                <button type = "submit" name = "signup-submit" class = "signup-submit">Sign Up</button>

                                <br><br><br>
                                
                                <div style = "text-align: center;">
                                    <br>
                                    <span>Already an Experienced Traveler? <b>Login <a href = "login.php"><i style = "color: #4678c4;" class = "bi bi-arrow-right"></i></a></b></span>
                                    <br><br>
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