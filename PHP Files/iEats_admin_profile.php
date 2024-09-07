<?php

    session_start();
    include "database.php";

    // if the user isn't logged in, redirect them to login.php
    if (!isset($_SESSION["email"])) {
        header("Location: login.php");
        exit();
    }

    // fetch the needed user information from the database
    $user_id = $_SESSION["email"];
    // check for both the email id from traveler and the country id from country and the food id from food
    $sql_traveler = "SELECT * FROM traveler WHERE email = ?";
    // $sql_country = "SELECT * FROM country WHERE id = ?";
    // $sql_food = "SELECT * FROM food WHERE id = ?";

    // for the user id
    $stmt = $conn->prepare($sql_traveler);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();

    // for country id
    // $stmt_country = $conn->prepare($sql_country);
    // $stmt_country->bind_param("i", $country_id);
    // $stmt_country->execute();

    // for food id
    // $stmt_food = $conn->prepare($sql_food);
    // $stmt_food->bind_param("i", $food_id);
    // $stmt_food->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // check if the user array is empty before accessing its keys
    if (!empty($user)) {
        // display the users information
        $first_name = $user["first_name"];
        $last_name = $user["last_name"];
        $email_address = $user["email"];
        $user_name = $user["username"];
        $user_password = $user["password_hash"];
        $phone_number = $user["phone_number"];
        $favorite_food = $user["favorite_food"];
        $profile_picture = '/images/' . $user["profile_image"]; // user profile picture
        $member_since = $user["registration_date"]; // member since

    } // handle the case if the user isn't found
    else {
        echo "<div class = 'text-danger'>
            <span class = 'close-btn' onclick = 'this.parentElement.style.display = 'none';'>&times;</span>
            User Infomation Not Found
        </div>";
    }
?>

<!-- html -->
<!DOCTYPE html>
<html>
    <head>
        <title>International Eats: Administration</title>
        <link rel = "stylesheet" href = "iEats_admin_style.css">

        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

        <!-- icon fonts stylesheet -->
        <link rel="stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

        <!-- hamburger menu icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- jquery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body>
        <!-- navigation bar starts -->
        <nav>
            <!-- logo -->
            <ul>
                <li><a href = "iEats_homepage_intro.php">Home</a></li>
                <li><a href = "iEats_about_intro.php">About</a></li>
                <li><a href = "iEats_destination_search.php">Destination</a></li>
                <li><a href = "iEats_findYourFood_search.php">Find Your Food</a></li>
                <div class = "nav-right">
                    <li><a href = "iEats_admin_profile.php" class = "active">Admin</a></li>
                </div>
            </ul>
            <!-- navigation bar ends -->
        </nav>

        <br><br><br>

        <!-- main picture -->
        <div style = "text-align: center;" class = "logo-container">
            <a href = "iEats_homepage_intro.php"><img src = "./images/iEats_logo.png" width = "100" height = "100"></a>
            <h1 class = "text" style = "color: #1dad65">International Eats</h1>
        </div>

        <br>

        <div class = "admin-banner">
            <form action = "iEats_admin_profile.php" method = "post">

                <!-- profile information -->
                <div class = "profile-information">
                    <!-- function that display the alert in an alert box -->
                    <blockquote>
                        <br><br>
                        <img class = "admin-banner-image" src = "<?php echo $profile_picture; ?>">
                        <br><br>

                        <h5 class = "profile-information-title">User Information</h5>
                        <br>

                        <!-- labels -->
                        <span class = "label">First Name: </span><?php echo $first_name ?>
                        <br>
                        <span class = "label">Last Name: </span><?php echo $last_name ?>
                        <br>
                        <span class = "label">Username: </span><?php echo $user_name ?>
                        <br>
                        <span class = "label">Email: </span><?php echo $email_address ?>
                        <br>
                        <span class = "label">Favorite Food: </span><?php echo $favorite_food ?>
                        <br>
                        <span class = "label">Member Since: </span><?php echo $member_since ?>

                        <br><br><br>
                        <button type = "submit" class = "logout-button">
                            <?php echo '<a href = "logout.php?email=' . htmlspecialchars($email_address) . '">Logout</a>' ?>
                        </button>
                        <br><br>
                    </blockquote>
                </div>

                <br><br><br>
                <div class = "admin-words"></div>
            </form>
        </div>

        <br><br><br>

        <!-- form -->
        <div class = "admin-content">
            <form>
                <div class = "button-organization">
                    <!-- button to edit profile -->
                    <button type = "button" class = "edit-profile-button">
                        <?php echo '<a href = "edit_profile.php?email=' . htmlspecialchars($email_address) . '&username=' . htmlspecialchars($user_name) . '">Edit Profile</a>'; ?>
                    </button>

                    <button type = "button" class = "changePass-button">
                        <?php echo '<a href = "change_password.php?email=' . htmlspecialchars($email_address) . '">Change Password</a>'; ?>
                    </button>
                </div>

                <br><br><br><br>

                <div class = "insert-words"></div>

                <br><br>

                <div class = "button-organization">
                    <!-- button to open a form to insert destination -->
                    <button type = "button" class = "destination-button">
                        <!-- <?php echo '<a href = "insert_destination.php?id=' . htmlspecialchars($id) . '&country_name=' . htmlspecialchars($country_name) . '">Destination</a>'; ?> -->
                        <a href = "insert_destination.php">Destination</a>
                    </button>

                    <!-- button to open a form to insert find your food -->
                    <button type = "button" class = "findYourFood-button">
                        <a href = "insert_findYourFood.php">Find Your Food</a>
                    </button>
                </div>

                <br><br><br><br>

                <div class = "update-words"></div>

                <br><br>

                <div class = "button-organization">
                    <!-- button to open a form to update destination -->
                    <button type = "button" class = "destination-button">
                        Destination
                    </button>

                    <!-- button to open a form to update find your food -->
                    <button type = "button" class = "findYourFood-button">
                        Find Your Food
                    </button>
                </div>

                <br><br><br><br>

                <div class = "delete-words"></div>

                <br><br>

                <div class = "button-organization">
                    <!-- button to delete account -->
                    <!-- once clicked, it'll show a message: Are you sure you want to delete your account? Yes/Cancel -->
                    <button type = "button" class = "traveler-button">
                        Traveler
                    </button>
                    <!-- button to open a form to update destination -->
                    <button type = "button" class = "destination-button">
                        Destination
                    </button>

                    <!-- button to open a form to update find your food -->
                    <button type = "button" class = "findYourFood-button">
                        Find Your Food
                    </button>
                </div>
            </form>
        </div>
        
        <br><br><br>

        <!-- footer  begins -->
        <hr>
        <footer class = "footer">
            <a href = "iEats_homepage_intro.php"><img src = "./images/iEats_logo.png" width = "35" height = "35"></a><span style = "font-size: medium;">International Eats | &copy; 2024 Copyright</span>
        </footer>
        <!-- footer ends -->

        <script src = "iEats_admin_function.js"></script>
    </body>
</html>