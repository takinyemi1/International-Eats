<?php
    
    session_start();
    include "database.php";

    // alert messages
    $errors = array();
    $success = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["insert-findyourfood-submit"])) {

        // variables
        $id = $_POST["food-id"];
        $country_img = "country-img";
        $food_img = "food-img";
        $restaurant_one_image = "res1-img";
        $restaurant_two_image = "res2-img";
        $restaurant_three_image = "res3-img";

        // check if all of the fields are empty
        if (empty($_POST["food_name"]) && empty($_POST["description"]) && empty($_POST["category"]) && empty($_POST["country"]) && empty($_POST["res1"]) && empty($_POST["res2"]) && empty($_POST["res3"]) && empty($_FILES[$country_img]["name"]) && empty($_FILES[$food_img]["name"]) && empty($_FILES[$restaurant_one_image]["name"]) && empty($_FILES[$restaurant_two_image]["name"]) && empty($_FILES[$restaurant_three_image]["name"])) {
            array_push($errors, "All fields are required.");
        } else {
            // perform other field validations
            if (empty($_POST["food_name"])) {
                array_push($errors,"Food field cannot be left empty");
            } else {
                $food_name = mysqli_real_escape_string($conn, $_POST["food_name"]);

                if (!preg_match('/^[a-zA-Z\s]+$/', $food_name)) {
                    array_push($errors, "Food field can only contain letters");
                }
            }

            if (empty($_POST["description"])) {
                array_push($errors,"Description field cannot be left empty.");
            } else {
                $description = mysqli_real_escape_string($conn, $_POST["description"]);

                if (!preg_match('/^[a-zA-Z\s]+$/', $description)) {
                    array_push($errors, "Description field can only contain letters");
                }
            }

            if (empty($_POST["category"])) {
                array_push($errors,"Category field cannot be left empty.");
            } else {
                $category = mysqli_real_escape_string($conn, $_POST["category"]);

                if (!preg_match('/^[a-zA-Z\s]+$/', $category)) {
                    array_push($errors, "Category field can only contain letters");
                }
            }

            if (empty($_POST["country"])) {
                array_push($errors,"Category field cannot be left empty.");
            } else {
                $category = mysqli_real_escape_string($conn, $_POST["category"]);

                if (!preg_match('/^[a-zA-Z\s]+$/', $category)) {
                    array_push($errors, "Category field can only contain letters");
                }
            }

            if (empty($_POST["res1"])) {
                array_push($errors,"Restaurant 1 field cannot be left empty.");
            } else {
                $restaurant_one = mysqli_real_escape_string($conn, $_POST["res1"]);

                if (!preg_match('/^[a-zA-Z\s]+$/', $restaurant_one)) {
                    array_push($errors, "Restaurant 1 field can only contain letters");
                }
            }

            if (empty($_POST["res2"])) {
                array_push($errors,"Restaurant 2 field cannot be left empty.");
            } else {
                $restaurant_two = mysqli_real_escape_string($conn, $_POST["res2"]);

                if (!preg_match('/^[a-zA-Z\s]+$/', $restaurant_two)) {
                    array_push($errors, "Restaurant 2 field can only contain letters");
                }
            }

            if (empty($_POST["res3"])) {
                array_push($errors,"Restaurant 3 field cannot be left empty.");
            } else {
                $restaurant_three = mysqli_real_escape_string($conn, $_POST["res3"]);

                if (!preg_match('/^[a-zA-Z\s]+$/', $restaurant_three)) {
                    array_push($errors, "Restaurant 3 field can only contain letters");
                }
            }

            include "image_file_validation.php";

            if (!empty($_FILES[$country_img]["name"])) {
                insertValidateImage($country_img, $errors);
            } else {
                array_push($errors,"No image for country found.");
            }

            if (!empty($_FILES[$food_img]["name"])) {
                insertValidateImage($food_img, $errors);
            } else {
                array_push($errors,"No image for food found.");
            }

            if (!empty($_FILES[$restaurant_one_image]["name"])) {
                insertValidateImage($restaurant_one_image, $errors);
            } else {
                array_push($errors,"No image for restaurant one found.");
            }

            if (!empty($_FILES[$restaurant_two_image]["name"])) {
                insertValidateImage($restaurant_two_image, $errors);
            } else {
                array_push($errors,"No image for restaurant two found.");
            }

            if (!empty($_FILES[$restaurant_three_image]["name"])) {
                insertValidateImage($restaurant_three_image, $errors);
            } else {
                array_push($errors,"No image for restaurant three found.");
            }
        }

        // check to make sure the combination of entries doesn't already exist
        $sql_check_duplicate = "SELECT * FROM food WHERE food_name = ? AND description = ? AND category = ? AND country_of_origin = ? AND restaurant_one = ? AND restaurant_two = ? AND
                                restaurant_three = ? AND country_image = ? AND food_image = ? AND restaurant_one_image = ? AND restaurant_two_image = ? AND restaurant_three_image = ?";
        $stmt_check_duplicate = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt_check_duplicate, $sql_check_duplicate)) {
            mysqli_stmt_bind_param($stmt_check_duplicate,"ssssssssssss", $food_name, $description, $category, $country_name, $restaurant_one, $restaurant_two, $restaurant_three,
            $country_img, $food_img, $restaurant_one_image, $restaurant_two_image, $restaurant_three_image);
            mysqli_stmt_execute($stmt_check_duplicate);
            mysqli_stmt_store_result($stmt_check_duplicate);

            if (mysqli_stmt_num_rows($stmt_check_duplicate) > 0) {
                array_push($errors,"This combination of entries already exists.");
            }

            if (count($errors) == 0) {

                // insert the values into the database
                $sql_insert = "INSERT INTO food(food_name, description, category, country_of_origin, restaurant_one, restaurant_two, restaurant_three, restaurant_one_image, country_image, food_image, restaurant_two_image, restaurant_three_image)
                                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert = mysqli_stmt_init($conn);

                $prepare_stmt = mysqli_stmt_prepare($stmt_insert, $sql_insert);
                
                // prepare, bind, and execute
                if ($prepare_stmt) {
                    // bind
                    mysqli_stmt_bind_param($stmt_insert,"ssssssssssss", $food_name, $description, $category, $country_name, $restaurant_one, $restaurant_two, $restaurant_three, $country_img, $food_img, $restaurant_one_image, $restaurant_two_image, $restaurant_three_image);
                    // execute
                    $execute_stmt = mysqli_stmt_execute($stmt_insert);

                    if ($execute_stmt) {
                        // success message
                        array_push($success, "You have successfully inserted an entry into Find Your Food! <span class = 'findyourfood-insert-btn'><u><b><a href = 'iEats_admin_profile.php'>Click here to return to the previous page</a></b></u></span>.");
                    } else {
                        
                        // check for a specific error
                        if (mysqli_errno($conn) == 1062) {
                            array_push($errors,"Duplicate entry found. Please provide unique entries.");
                        } else {
                            array_push($errors,"Failed to insert entry into Find Your Food: " . mysqli_stmt_error($stmt_insert)) . ".";
                        }
                    }
                } else {
                    array_push($errors,"Error in preparing the insert statement: " . mysqli_error($conn) . ".");
                }
            }
        }

    }

?>

<!-- html -->
<!DOCTYPE html>
<html>
    <head>
        <title>International Eats | Insert Into Find Your Food</title>
        <!-- <link href = "./iEats_findyourfood_style.css" rel = "stylesheet"> -->

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
        .insert-findyourfood-input {
            border: none;
            border-bottom: 2px solid #7ce9da;
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

        .insert-findyourfood-input:focus, .insert-findyourfood-input:active, .insert-findyourfood-input:hover {
            background-color: white;
            outline: none;
            color: black;
            border-bottom-color: #379fa3;
        }

        .insert-findyourfood-modal-content hr {
            border: 1px solid #256c6e;
            margin-bottom: 25px;
        }

        /* style for buttons */
        .insert-findyourfood-submit {
            background-color: #7ce9da;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 25%;
            opacity: 0.9;
        }

        .insert-findyourfood-submit:hover {
            opacity: 3;
        }

        .insert-findyourfood-submit {
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
            color: #4baec7;
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
        .insert-findyourfood-container-form {
            padding: 16px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        /* modal content box */
        .modal-content-insert-findyourfood {
            z-index: 1;
            background-color: #7ce9da;
            /* 15% from the top and centered */
            margin: 5px auto;
            border: 1px solid #256c6e;
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

        /* change the styles for the cancel button and the insert-findyourfood button on extra small screens */
        @media screen and (max-width: 300px) {
            .cancel-btn, .insert-findyourfood-submit {
                width: 100%;
            }
        }

        /* for the findyourfood-insert */
        @media screen and (max-width: 300px) {
            .cancel-btn, .findyourfood-insert-submit {
                width: 100%;
            }
        }

        /* background of the modal */
        .modal-insert-findyourfood {
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
            background-color: #4fcfbe;
            padding-top: 60px;
        }

        #button-icon-insert-findyourfood {
            color: #276d96;
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

        .new-findyourfood-title {
            text-align: center;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 18px;
        }

        .insert-findyourfood-submit {
            background-color: #276d96;
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

        .findyourfood-profile {
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
            <span style = "--i:3">s</span>
            <span style = "--i:4">e</span>
            <span style = "--i:5">r</span>
            <span style = "--i:6">t</span>
            <span style = "--i:6"> </span>
            <span style = "--i:7">I</span>
            <span style = "--i:8">n</span>
            <span style = "--i:9">t</span>
            <span style = "--i:10">o</span>
            <span style = "--i:11"> </span>
            <span style = "--i:12">F</span>
            <span style = "--i:13">i</span>
            <span style = "--i:14">n</span>
            <span style = "--i:15">d</span>
            <span style = "--i:16"> </span>
            <span style = "--i:17">Y</span>
            <span style = "--i:18">o</span>
            <span style = "--i:19">u</span>
            <span style = "--i:20">r</span>
            <span style = "--i:21"> </span>
            <span style = "--i:22">F</span>
            <span style = "--i:23">o</span>
            <span style = "--i:24">o</span>
            <span style = "--i:25">d</span>
            <span style = "--i:26">.</span>
        </div>

        <br><br>

        <!-- the insert-findyourfood modal -->
        <div id = "id01" class = "modal-insert-findyourfood">
            <div class = "insert-findyourfood-container-form">
                <div class = "modal-content-insert-findyourfood">
                    <!-- content in the modal -->
                    <!-- <form class = "insert-findyourfood-modal-content" action = "findyourfood.php" method = "post"> -->
                    <?php
                        // if there are any errors 
                        if (count($errors) > 0) {
                    
                            foreach ($errors as $error) {
                                echo "<div class = 'text-danger'>
                                    <span class = 'close-btn' onclick = 'alertBox()'>&times;</span>
                                    $error
                                </div>";
                            }
                        }

                        if (count($success) > 0) {
                    
                            foreach ($success as $success_msg) {
                                echo "<div class = 'text-success'>
                                    <span class = 'close-btn' onclick = 'alertBox()'>&times;</span>
                                    $success_msg
                                </div>";
                            }
                        }
                        
                    ?>
                    <!-- php end -->
                    <form class = "insert-findyourfood-modal-content" action = "insert_findyourfood.php" method = "post" enctype = "multipart/form-data">
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

                        <div class = "new-findyourfood-title">
                            <h1>Find Your Food</h1>
                        </div>
                        <br>
                        <p style = "text-align: center;">Please fill in this form to insert an entry into <b>Find Your Food.</b></p>
                        <hr>

                        <div class = "findyourfood-profile">
                            <div class = "insert-findyourfood-field">
                                <i id = "button-icon-insert-findyourfood" class = "bi bi-egg-fill"></i>
                                <label for = "food_name"><b>Food</b></label>
                                <input type = "text" class = "insert-findyourfood-input" placeholder = "Ex: Peanut Butter and Jelly Sandwich" name = "food_name"> <!-- required -->
                            </div>

                            <div class = "insert-findyourfood-field">
                                <i id = "button-icon-insert-findyourfood" class = "bi bi-file-text"></i>
                                <label for = "description"><b>Description</b></label>
                                <input type = "text" class = "insert-findyourfood-input" placeholder = "Ex: This food is composed of peanut butter and jelly lathered onto bread." name = "description"> <!-- required -->
                            </div>

                            <div class = "insert-findyourfood-field">
                                <i id = "button-icon-insert-findyourfood" class = "bi bi-bookmark-check-fill"></i>
                                <label for = "category"><b>Category</b></label>
                                <input type = "text" class = "insert-findyourfood-input" placeholder = "Ex: Carb" name = "category">
                            </div>

                            <div class = "insert-findyourfood-field">
                                <i id = "button-icon-insert-findyourfood" class = "bi bi-airplane-engines-fill"></i>
                                <label for = "country"><b>Country Of Origin</b></label>
                                <input type = "text" class = "insert-findyourfood-input" placeholder = "Ex: France" name = "country">
                            </div>

                            <div class = "insert-findyourfood-field">
                                <i id = "button-icon-insert-findyourfood" class = "bi bi-1-square-fill"></i>
                                <label for = "res1"><b>Restaurant 1</b></label>
                                <input type = "text" class = "insert-findyourfood-input" placeholder = "Ex: Walmart" name = "res1">
                            </div>

                            <div class = "insert-findyourfood-field">
                                <i id = "button-icon-insert-findyourfood" class = "bi bi-2-square-fill"></i>
                                <label for = "res2"><b>Restaurant 2</b></label>
                                <input type = "text" class = "insert-findyourfood-input" placeholder = "Ex: Target" name = "res2">
                            </div>

                            <div class = "insert-findyourfood-field">
                                <i id = "button-icon-insert-findyourfood" class = "bi bi-3-square-fill"></i>
                                <label for = "res3"><b>Restaurant 3</b></label>
                                <input type = "text" class = "insert-findyourfood-input" placeholder = "Ex: Food Lion" name = "res3">
                            </div>

                            <div class = "insert-findyourfood-field">
                                <i id = "button-icon-insert-findyourfood" class = "bi bi-airplane-fill"></i>
                                <label for = "country-img"><b>Country Image</b></label>
                                <input type = "file" class = "insert-findyourfood-input" name = "country-img" accept = ".jpg, .jpeg, .png, .gif">
                                <br><br>
                                <?php if (!empty($row["country_image_two"])) : ?>
                                    <img src = "<?php echo isset($target_file) ? $target_file : $row["country_image_two"]; ?>" class = "previous-food-image2" width = "100" height = "100">
                                <?php endif; ?>
                            </div>

                            <div class = "insert-findyourfood-field">
                                <i id = "button-icon-insert-findyourfood" class = "bi bi-egg-fried"></i>
                                <label for = "food-img"><b>Food Image</b></label>
                                <input type = "file" class = "insert-findyourfood-input" name = "food-img" accept = ".jpg, .jpeg, .png, .gif">
                                <br><br>
                                <?php if (!empty($row["country_image_two"])) : ?>
                                    <img src = "<?php echo isset($target_file) ? $target_file : $row["country_image_two"]; ?>" class = "previous-food-image2" width = "100" height = "100">
                                <?php endif; ?>
                            </div>

                            <div class = "insert-findyourfood-field">
                                <i id = "button-icon-insert-findyourfood" class = "bi bi-1-circle-fill"></i>
                                <label for = "res1-img"><b>Restaurant 1 Image</b></label>
                                <br><br>
                                <input type = "file" class = "insert-findyourfood-input" name = "res1-img" accept = ".jpg, .jpeg, .png, .gif">
                                <!-- image url that holds the previous img -->
                                <?php if (!empty($row["food_image"])) : ?>
                                    <img src = "<?php echo isset($target_file) ? $target_file : $row["food_image"]; ?>" class = "previous-food-image" width = "100" height = "100">
                                <?php endif; ?>
                            </div>

                            <div class = "insert-findyourfood-field">
                                <i id = "button-icon-insert-findyourfood" class = "bi bi-2-circle-fill"></i>
                                <label for = "res2-img"><b>Restaurant 2 Image</b></label>
                                <input type = "file" class = "insert-findyourfood-input" name = "res2-img" accept = ".jpg, .jpeg, .png, .gif">
                                <br><br>
                                <?php if (!empty($row["food_image_two"])) : ?>
                                    <img src = "<?php echo isset($target_file) ? $target_file : $row["food_image_two"]; ?>" class = "previous-food-image2" width = "100" height = "100">
                                <?php endif; ?>
                            </div>

                            <div class = "insert-findyourfood-field">
                                <i id = "button-icon-insert-findyourfood" class = "bi bi-3-circle-fill"></i>
                                <label for = "res3-img"><b>Restaurant 3 Image</b></label>
                                <input type = "file" class = "insert-findyourfood-input" name = "res3-img" accept = ".jpg, .jpeg, .png, .gif">
                                <br><br>
                                <?php if (!empty($row["country_image"])) : ?>
                                    <img src = "<?php echo isset($target_file) ? $target_file : $row["country_image"]; ?>" class = "previous-country-image1" width = "100" height = "100">
                                <?php endif; ?>
                            </div>

                            <!-- <div class = "insert-findyourfood-field">
                                <input type = "text" hidden = "hidden" class = "insert-findyourfood-input" name = "food-id" required>
                            </div> -->

                            <div class = "insert-findyourfood-field">
                                <!-- insert-findyourfood button -->
                                <hr>
                                <button type = "submit" name = "insert-findyourfood-submit" class = "insert-findyourfood-submit">Insert Into Find Your Food</button>
                                <br>

                                <div style = "text-align: center;">
                                    <span class = "forgot-password"><a href = "iEats_admin_profile.php">Return to Administration</a></span>
                                </div>
                                <br><br>
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
            <a href = "iEats_homepage_intro.php"><img src = "./images/iEats_logo.png" width = "35" height = "35"></a><span style = "font-size: medium;">International Eats | &copy; <?php echo date("Y") ?> Copyright</span>
        </footer>
        <!-- footer ends -->

        <script>
            function alertBox() {
                this.parentElement.style.display = "none";
            }
        </script>
    </body>
</html>