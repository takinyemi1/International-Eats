<?php
    
    session_start();
    // get the needed files
    include "database.php";

    // initialize the errors array
    $errors = array();
    $success = array();

    // if the user isn't logged in
    if (!isset($_SESSION["loggedin"]) || isset($_SESSION["loggedin"]) !== true) {
        // direct the user to the login page
        header("Location: login.php");
        exit;
    }
    
    $email = $_SESSION["email"];
    // $user = $_GET["username"];

    // get the old values from the database using the given variables email and user
    $sql_select = "SELECT * FROM traveler WHERE email = ?";
    $stmt_check = mysqli_stmt_init($conn);

    // bind, prepare, and execute statement
    $stmt_check->prepare($sql_select);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();

    // get the result
    $result = $stmt_check->get_result();
    // fetch the data 
    $user_data = $result->fetch_assoc();
    $stmt_check->close();

    // check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit-submit"])) {
        // check if the user exists
        if ($user_data) {
            // validate the fields
            if (empty($_POST["uname"]) && empty($_POST["fname"]) && empty($_POST["lname"]) && empty($_POST["favfood"]) && empty($_POST["edit-file"])) {
                array_push($errors,"All fields are required.");

            } else {
                // check for each field individually
                if (empty($_POST["uname"])) {
                    array_push($errors, "Username field cannot be left empty.");

                } else {
                    $new_user = mysqli_real_escape_string($conn, $_POST["uname"]); // old username
                    // validate the username
                    if (!preg_match('/^[a-zA-Z0-9_]+$/', $new_user)) {
                        array_push($errors, "Username can only contain letters, numbers, and underscores.");
                    }
                }

                if (empty($_POST["fname"])) {
                    array_push($errors, "First name field cannot be left empty.");

                } else {
                    $new_first_name = mysqli_real_escape_string($conn, $_POST["fname"]); // old first name

                    if (!preg_match("/^[a-zA-Z\s']+$/", $new_first_name)) {
                        array_push($errors, "First name can only contain letters.");
                    }
                }

                if (empty($_POST["lname"])) {
                    array_push($errors, "Last name field cannot be left empty.");

                } else {
                    $new_last_name = mysqli_real_escape_string($conn, $_POST["lname"]); // old last name

                    if (!preg_match("/^[a-zA-Z\s']+$/", $new_last_name)) {
                        array_push($errors, "Last name can only contain letters.");
                    }
                }

                if (empty($_POST["favfood"])) {
                    array_push($errors, "Favorite Food field cannot be left empty.");

                } else {
                    $new_favorite_food = mysqli_real_escape_string($conn, $_POST["favfood"]); // old favorite food

                    if (!preg_match("/^[a-zA-Z\s']+$/", $new_favorite_food)) {
                        array_push($errors, "Favorite food can only contain letters.");
                    }
                }

                // if the field is not empty, check if it only has numbers and hyphens
                if (!empty($_POST["pnum"]) && !preg_match('/^[0-9_-]+$/', ($_POST["pnum"]))) {
                    $new_phone_number = mysqli_real_escape_string($conn, $_POST["pnum"]); // old phone number

                    if (!preg_match('/^[0-9_-]+$/', $new_phone_number)) {
                        array_push($errors, "Phone number can only contain numbers.");
                    }
                }

                if (!empty($_FILES["edit-file"]["name"])) {
                    $target_directory = "images/"; // target directory
                    $img_name = $target_directory . basename($_FILES["edit-file"]["name"]); // image name
                    $tmp_name = $_FILES["edit-file"]["tmp_name"]; // temporary file name
                    $img_size = $_FILES["edit-file"]["size"]; // file size

                    // check for the extension
                    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
                    $img_extension = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

                    // if that specific file is allowed
                    if (!in_array($img_extension, $allowed_extensions)) {
                        // push the message into the errors array
                        array_push($errors, "Only JPG, JPEG, PNG, and GIF files are allowed");

                    } elseif ($img_size > 500000) { // check if the image is over 5MB
                        array_push($errors,"Image size is too large.");
                        
                    } else {
                        // move the uploaded file to the target directory
                        if (move_uploaded_file($tmp_name, $img_name)) {
                            $new_img_name = $new_user . "-" . date("Y") . "-" . date("s") . "." . $img_extension;
                            // where is the image to be located
                            $img_destination = $target_directory . $new_img_name;
                        } else {
                            array_push($errors, "Failed to move the uploaded file to the target directory.");
                        }
                    }

                } else { // if no file is uploaded, use the existing profile image
                    $new_img_name = $user_data["profile_image"];
                }
            }

            // check if there are no errors and proceed with updating the dataset
            if (count($errors) == 0) {
                // select query checking if the new username equals any username in the table currently
                $sql_user_check = "SELECT username FROM traveler WHERE username = ? AND email != ?";
                $stmt_user_check = mysqli_stmt_init($conn);

                // prepare statement
                $prepare_stmt = mysqli_stmt_prepare($stmt_user_check, $sql_user_check);

                // bind, prepare, and execute the parameters
                if ($prepare_stmt) {
                    
                    mysqli_stmt_bind_param($stmt_user_check,"ss", $new_user, $email); // bind
                    mysqli_stmt_execute($stmt_user_check); // execute
                    $stmt_user_check->store_result(); // store the result

                    // check if the username already exists for a different user
                    if (mysqli_stmt_num_rows($stmt_user_check) > 0) {
                        // error message
                        array_push($errors,"Username already exists. Please enter a unique username.");
                    }

                    // proceed with updating the database
                    $sql_update = "UPDATE traveler SET username = ?, first_name = ?, last_name = ?, phone_number = ?, favorite_food = ?, profile_image = ?
                                    WHERE email = ?";
                    $stmt_update = mysqli_stmt_init($conn);

                    // bind, execute and prepare the statement
                    mysqli_stmt_prepare($stmt_update, $sql_update);
                    mysqli_stmt_bind_param($stmt_update, "sssssss", $new_user, $new_first_name, $new_last_name, $new_phone_number, $new_favorite_food, $new_img_name, $email);
                    mysqli_stmt_execute($stmt_update);
                    mysqli_stmt_close($stmt_update);

                    // success message
                    array_push($success, "You have successfully updated your profile. Return to your <a href = 'iEats_admin_profile.php'>profile</a>.");

                    // after the data is updated, fetch the updated user data from the database
                    $sql_select_updated = "SELECT * FROM traveler WHERE email = ?";
                    $stmt_select_updated = mysqli_stmt_init($conn);
                    // prepare, bind, and execute
                    $stmt_select_updated->prepare($sql_select_updated);
                    $stmt_select_updated->bind_param("s", $email);
                    $stmt_select_updated->execute();

                    // get the result
                    $result_updated = $stmt_select_updated->get_result();
                    // fetch the information
                    $user_data_updated = $result_updated->fetch_assoc();
                    $stmt_select_updated->close();

                    // populate the old user data with the new user data
                    $user_data = $user_data_updated;

                } else {
                    array_push($errors,"Error in updating your profile: " . mysqli_connect_error() . ".");
                }
            }

        } else {
            array_push($errors,"User not found.");
        }
    }

?>

<!-- html -->
<!DOCTYPE html>
<html> 
    <head>
        <title>International Eats | Edit Profile</title>
        <link href = "edit_profile_style.css" rel = "stylesheet">

        <meta charset = "UTF-8">

        <!-- icon fonts stylesheet -->
        <link rel="stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    </head>

    <body> 

        <br><br>

        <!-- earth rotation picture -->
        <div style = "text-align: center;">
            <img src = "./images/edit-gif.gif" class = "main-img">
        </div>

        <br><br>

        <div class = "main-inteats" style = "text-align: center;">
            <span style = "--i:1">E</span>
            <span style = "--i:2">d</span>
            <span style = "--i:3">i</span>
            <span style = "--i:4">t</span>
            <span style = "--i:5"> </span>
            <span style = "--i:6">P</span>
            <span style = "--i:7">r</span>
            <span style = "--i:8">o</span>
            <span style = "--i:9">f</span>
            <span style = "--i:10">i</span>
            <span style = "--i:11">l</span>
            <span style = "--i:12">e</span>
            <span style = "--i:13">.</span>
        </div>

        <br><br>

        <!-- the edit modal -->
        <div id = "id01" class = "modal-edit">
            <div class = "edit-container-form">
                <div class = "modal-content-edit">
                    <!-- display the error messages -->
                    <?php 
                    
                        if (count($errors) > 0) {
                            foreach ($errors as $error) {
                                echo "<div class = 'text-danger'>
                                    <span class = 'close-btn' onclick = 'this.parentElement.style.display = 'none'>&times;</span>
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
                    <form class = "edit-modal-content" action = "edit_profile.php" method = "post" enctype = "multipart/form-data">
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
                            <h1>Update Profile</h1>
                        </div>
                        <br>
                        <p style = "text-align: center;">Please fill in this form to <b>Update Your Account</b>.</p>
                        <hr>

                        <div class = "update-profile">
                            <div class = "edit-field" hidden = "hidden">
                                <i id = "button-icon-edit" class = "bi bi-envelope-at-fill"></i>
                                <label for = "email"><b>Email</b></label>
                                <input type = "email" class = "edit-input" value = "<?php echo $email; ?>" name = "email" autocomplete = "off" readonly> <!-- required -->
                            </div>
    
                            <div class = "edit-field">
                                <i id = "button-icon-edit" class = "bi bi-person-badge-fill"></i>
                                <label for = "username"><b>Username</b></label>
                                <input type = "text" class = "edit-input" value = "<?php echo $user_data["username"]; ?>" name = "uname" autocomplete = "off"> <!-- required -->
                            </div>
    
                            <div class = "edit-field">
                                <i id = "button-icon-edit" class = "bi bi-person-fill"></i>
                                <label for = "fname"><b>First Name</b></label>
                                <input type = "text" class = "edit-input" value = "<?php echo $user_data["first_name"]; ?>" name = "fname" autocomplete = "off">
                            </div>
    
                            <div class = "edit-field">
                                <i id = "button-icon-edit" class = "bi bi-person-fill"></i>
                                <label for = "lname"><b>Last Name</b></label>
                                <input type = "text" class = "edit-input" value = "<?php echo $user_data["last_name"]; ?>" name = "lname" autocomplete = "off">
                            </div>
    
                            <div class = "edit-field">
                                <i id = "button-icon-edit" class = "bi bi-telephone-fill"></i>
                                <label for = "pnum"><b>Phone Number</b></label>
                                <!-- conditional statements for if there's already an entry -->
                                <?php if (empty($_POST["pnum"])) : ?>
                                    <input type = "text" class = "edit-input" placeholder = "XXX-XXX-XXXX" name = "pnum" autocomplete = "off">
                                <?php else : ?>
                                    <input type = "text" class = "edit-input" value = "<?php echo $user_data["phone_number"]; ?>" name = "pnum" autocomplete = "off">
                                <?php endif; ?>
                            </div>
    
                            <div class = "edit-field">
                                <i id = "button-icon-edit" class = "bi bi-star-fill"></i>
                                <label for = "favfood"><b>Favorite Food</b></label>
                                <input type = "text" class = "edit-input" value = "<?php echo $user_data["favorite_food"]; ?>" name = "favfood" autocomplete = "off">
                            </div>
    
                            <!-- for updating the profile picture -->
                            <div class = "edit-field">
                                <i id = "button-icon-edit" class = "bi bi-file-image"></i>
                                <label for = "favfood"><b>Profile Image</b></label>
                                <br><br>
                                <input type = "file" class = "edit-file" name = "edit-file" accept = ".jpg, .jpeg, .png, .gif">
                                <!-- display either the user uploaded image or the default image -->
                                <?php if (empty($_FILES["edit-file"]["name"])) : ?>
                                    <!-- if there's no new file choseb, display the current profile image -->
                                    <img src = "./images/<?= $user_data["profile_image"]; ?>" class = "previous-profile-image" width = "100" height = "100">
                                <?php else : ?>
                                    <!-- if a new file is chosen, display the chosen file -->
                                    <img src = "./images/<?= $user_data["profile_image"]; ?>" class = "previous-profile-image" style = "display: none;" width = "100" height = "100">
                                    <!-- check if the image destination exists -->
                                    <?php if (isset($img_destination) && file_exists($img_destination)) : ?>
                                        <img src = "<?php echo $img_destination ?>" class = "previous-profile-image" width = "100" height = "100">
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <input type = "text" hidden = "hidden" name = "edit-file-old" value = "<?= $user_data["profile_image"] ?>">
                            </div>

                            <br>

                            <div class = "edit-field">
                                <!-- edit button -->
                                <hr>
                                <button type = "submit" name = "edit-submit" class = "edit-submit">Update Profile</button>
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