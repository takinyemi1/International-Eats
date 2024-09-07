<?php
    
    session_start();
    include "database.php";

    // error messages should be placed in an array
    $errors = array();
    $success = array();
 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["insert-destination-submit"])) {

        $country_name = mysqli_real_escape_string($conn, $_POST["country_name"]);
        $pop_city1 = mysqli_real_escape_string($conn, $_POST["pop_city1"]);
        $pop_city2 = mysqli_real_escape_string($conn, $_POST["pop_city2"]);
        $continent = mysqli_real_escape_string($conn, $_POST["continent"]);
        $pop_food1 = mysqli_real_escape_string($conn, $_POST["pop_food1"]);
        $pop_food2 = mysqli_real_escape_string($conn, $_POST["pop_food2"]);
        $food_img1 = "food_img1";
        $food_img2 = "food_img2";
        $country_img1 = "country_img1";
        $country_img2 = "country_img2";

        // this expression: '/^[a-zA-Z]+$/' doesn't allow for spaces between words, so it's only best to use with 
        // validating an email or password

        // check if all of the fields are empty
        if (empty($country_name) && empty($pop_city1) && empty($pop_city2) && empty($continent) && empty($pop_food1) && empty($pop_food2)) {
            array_push($errors,"All fields are required.");

        } else {
            // perform other validation
            if (empty($country_name)) {
                array_push($errors, "Country field cannot be left empty");
            } else {
                if (!preg_match('/^[a-zA-Z\s]+$/', $pop_city2)) {
                    array_push($errors, "Country field can only contain letters");
                }
            }

            if (empty($pop_city1)) {
                array_push($errors, "City 1 field cannot be left empty");
            } else {
                if (!preg_match('/^[a-zA-Z\s]+$/', $pop_city2)) {
                    array_push($errors, "City 1 field can only contain letters");
                }
            }

            if (empty($pop_city2)) {
                array_push($errors, "City 2 field cannot be left empty");
            } else {
                if (!preg_match('/^[a-zA-Z\s]+$/', $pop_city2)) {
                    array_push($errors, "City 2 field can only contain letters");
                }
            }

            if (empty($continent)) {
                array_push($errors, "Continent field cannot be left empty");
            } else {
                if (!preg_match('/^[a-zA-Z\s]+$/', $pop_city2)) {
                    array_push($errors, "Continent field can only contain letters");
                }
            }

            if (empty($pop_food1)) {
                array_push($errors, "Food 1 field cannot be left empty");
            } else {
                if (!preg_match('/^[a-zA-Z\s]+$/', $pop_city1)) {
                    array_push($errors, "Food 1 field can only contain letters");
                }
            }

            if (empty($pop_food2)) {
                array_push($errors, "Food 2 field cannot be left empty");
            } else {
                if (!preg_match('/^[a-zA-Z\s]+$/', $pop_city2)) {
                    array_push($errors, "Food 2 field can only contain letters");
                }
            }

            // validate the image files using a function
            include "image_file_validation.php";

            // validate food image 1
            if (!empty($_FILES[$food_img1]["name"])) {
                // validate the image
                insertValidateImage($food_img1, $errors);

            } else { // let the user know that there was no image found
                array_push($errors, "No image for food 1 found.");
            }

            // validate food image 2
            if (!empty($_FILES[$food_img2]["name"])) {
                insertValidateImage($food_img2, $errors);
            } else {
                array_push($errors, "No image for food 2 found.");
            }

            // validate city image 1
            if (!empty($_FILES[$country_img1]["name"])) {
                insertValidateImage($country_img1, $errors);
            } else {
                array_push($errors, "No image for city 1 found.");
            }

            // validate city image 2
            if (!empty($_FILES[$country_img2]["name"])) {
                insertValidateImage($country_img2, $errors);
            } else {
                array_push($errors, "No image for city 2 found.");
            }
        }

        // make sure that the id isn't repeated
        // check if it already exists
        $sql_check_duplicate = "SELECT * FROM country WHERE country_name = ? AND popular_city1 = ? AND popular_city2 = ? AND popular_food1 = ? AND popular_food2 = ?";
        $stmt_check_duplicate = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt_check_duplicate, $sql_check_duplicate)) {
            mysqli_stmt_bind_param($stmt_check_duplicate, "sssss", $country_name, $pop_city1, $pop_city2, $pop_food1, $pop_food2);
            mysqli_stmt_execute($stmt_check_duplicate);
            mysqli_stmt_store_result($stmt_check_duplicate);

            if (mysqli_stmt_num_rows($stmt_check_duplicate) > 0) {
                // if a matching row is found, display the error message
                array_push($errors, "This combination of entries already exists.");
            }

            if (count($errors) == 0) {

                // insert values into the database
                $sql_insert = "INSERT INTO country(country_name, popular_city1, popular_city2, continent, popular_food1, popular_food2, food_image, food_image_two, country_image, country_image_two)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
                $stmt_insert = mysqli_stmt_init($conn);
    
                $prepare_stmt = mysqli_stmt_prepare($stmt_insert, $sql_insert);
    
                // prepare, bind and execute the entries to their corresponding values
                if ($prepare_stmt) {
                    // bind the values
                    mysqli_stmt_bind_param($stmt_insert, "ssssssssss", $country_name, $pop_city1, $pop_city2, $continent, $pop_food1, $pop_food2, $food_img1, $food_img2, $country_img1, $country_img2);
                    // execute
                    $execute_stmt = mysqli_stmt_execute($stmt_insert);
    
                    // handles the possibility of a duplicate entry in the insert statement
                    if ($execute_stmt) {
                        // echo a success message
                        array_push($success,"You have successfully inserted an entry into Destination! <span class = 'destination-insert-btn'><u><b><a href = 'iEats_admin_profile.php'>Click here to return to the previous page</a></b></u></span>.");
    
                    } else {
    
                        // check for a specific error in a duplicate statement
                        if (mysqli_errno($conn) == 1062) {
                            // error message indicating that a duplicate entry was found
                            // error code: 1062 implies that there is a duplicate entry error
                            array_push($errors,"Duplicate entry found. Please provide unique entries.");

                        } else {
                            // display a generic failure message
                            array_push($errors,"Failed to insert entry into Destination: " . mysqli_stmt_error($stmt_insert) . ".");
                        }
                    }
    
                } else {
                    // error in preparing the insert statement
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
        <title>International Eats | Insert Into Destination</title>
        <link href = "insert_destination_style.css" rel = "stylesheet">

        <meta charset = "UTF-8">

        <!-- icon fonts stylesheet -->
        <link rel="stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    </head>

    <body>

        <br><br>

        <!-- earth rotation picture -->
        <div style = "text-align: center;">
            <img src = "./images/insertion.gif" class = "main-img">
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
            <span style = "--i:12">D</span>
            <span style = "--i:13">e</span>
            <span style = "--i:14">s</span>
            <span style = "--i:15">t</span>
            <span style = "--i:16">i</span>
            <span style = "--i:17">n</span>
            <span style = "--i:18">a</span>
            <span style = "--i:19">t</span>
            <span style = "--i:20">i</span>
            <span style = "--i:21">o</span>
            <span style = "--i:22">n</span>
            <span style = "--i:23">.</span>
        </div>

        <br><br>

        <!-- the insert-destination modal -->
        <div id = "id01" class = "modal-insert-destination">
            <div class = "insert-destination-container-form">
                <div class = "modal-content-insert-destination">
                    <!-- content in the modal -->
                    <!-- if there are any errors -->
                    <?php 

                        // if there are errors, display them
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
                    <form class = "insert-destination-modal-content" action = "insert_destination.php" method = "post" enctype = "multipart/form-data">
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

                        <div class = "new-destination-title">
                            <h1>Destination</h1>
                        </div>
                        <br>
                        <p style = "text-align: center;">Please fill in this form to insert an entry into <b>Destination.</b></p>
                        <hr>

                        <div class = "destination-profile">
                            <div class = "insert-destination-field">
                                <i id = "button-icon-insert-destination" class = "bi bi-airplane-fill"></i>
                                <label for = "country_name"><b>Country</b></label>
                                <input type = "text" class = "insert-destination-input" placeholder = "Enter Country Name" name = "country_name"> <!-- required -->
                            </div>

                            <div class = "insert-destination-field">
                                <i id = "button-icon-insert-destination" class = "bi bi-pop_food1port-fill"></i>
                                <label for = "pop_city1"><b>City 1</b></label>
                                <input type = "text" class = "insert-destination-input" placeholder = "Enter Popular City 1" name = "pop_city1"> <!-- required -->
                            </div>

                            <div class = "insert-destination-field">
                                <i id = "button-icon-insert-destination" class = "bi bi-pop_food1port-fill"></i>
                                <label for = "pop_city2"><b>City 2</b></label>
                                <input type = "text" class = "insert-destination-input" placeholder = "Enter Popular City 2" name = "pop_city2">
                            </div>

                            <div class = "insert-destination-field">
                                <i id = "button-icon-insert-destination" class = "bi bi-luggage-fill"></i>
                                <label for = "continent"><b>Continent</b></label>
                                <input type = "text" class = "insert-destination-input" placeholder = "Enter Continent" name = "continent">
                            </div>

                            <div class = "insert-destination-field">
                                <i id = "button-icon-insert-destination" class = "bi bi-egg-fill"></i>
                                <label for = "pop_food1"><b>Food 1</b></label>
                                <input type = "text" class = "insert-destination-input" placeholder = "Enter Popular Food 1" name = "pop_food1">
                            </div>

                            <div class = "insert-destination-field">
                                <i id = "button-icon-insert-destination" class = "bi bi-egg-fill"></i>
                                <label for = "pop_food2"><b>Food 2</b></label>
                                <input type = "text" class = "insert-destination-input" placeholder = "Enter Popular Food 2" name = "pop_food2">
                            </div>

                            <div class = "insert-destination-field">
                                <i id = "button-icon-insert-destination" class = "bi bi-egg-fried"></i>
                                <label for = "food_img1"><b>Food Image 1</b></label>
                                <br><br>
                                <input type = "file" class = "insert-destination-input" name = "food_img1" accept = ".jpg, .jpeg, .png">
                                <!-- image url that holds the previous img -->
                                <?php if (!empty($row["food_image"])) : ?>
                                    <img src = "<?php echo isset($target_file) ? $target_file : $row["food_image"]; ?>" class = "previous-food-image" width = "100" height = "100">
                                <?php endif; ?>
                            </div>

                            <div class = "insert-destination-field">
                                <i id = "button-icon-insert-destination" class = "bi bi-egg-fried"></i>
                                <label for = "food_img2"><b>Food Image 2</b></label>
                                <input type = "file" class = "insert-destination-input" name = "food_img2" accept = ".jpg, .jpeg, .png">
                                <br><br>
                                <?php if (!empty($row["food_image_two"])) : ?>
                                    <img src = "<?php echo isset($target_file) ? $target_file : $row["food_image_two"]; ?>" class = "previous-food-image2" width = "100" height = "100">
                                <?php endif; ?>
                            </div>

                            <div class = "insert-destination-field">
                                <i id = "button-icon-insert-destination" class = "bi bi-suitcase-lg-fill"></i>
                                <label for = "country_img1"><b>Country Image 1</b></label>
                                <input type = "file" class = "insert-destination-input" name = "country_img1" accept = ".jpg, .jpeg, .png">
                                <br><br>
                                <?php if (!empty($row["country_image"])) : ?>
                                    <img src = "<?php echo isset($target_file) ? $target_file : $row["country_image"]; ?>" class = "previous-country-image1" width = "100" height = "100">
                                <?php endif; ?>
                            </div>

                            <div class = "insert-destination-field">
                                <i id = "button-icon-insert-destination" class = "bi bi-suitcase-lg-fill"></i>
                                <label for = "country_img2"><b>Country Image 2</b></label>
                                <input type = "file" class = "insert-destination-input" name = "country_img2" accept = ".jpg, .jpeg, .png">
                                <br><br>
                                <?php if (!empty($row["country_image_two"])) : ?>
                                    <img src = "<?php echo isset($target_file) ? $target_file : $row["country_image_two"]; ?>" class = "previous-food-image2" width = "100" height = "100">
                                <?php endif; ?>
                            </div>

                            <div class = "insert-destination-field">
                                <!-- insert-destination button -->
                                <hr>
                                <button type = "submit" name = "insert-destination-submit" class = "insert-destination-submit">Insert Into Destination</button>
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