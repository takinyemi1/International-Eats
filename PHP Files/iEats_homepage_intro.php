<?php

    include "database.php";
    
    session_start();

    // if the user isn't logged in, redirect them to the login.php
    if (!isset($_SESSION["email"])) {
        header("Location: login.php");
        // stops the script from further executing
        exit();
    }

    // fetch the user's name from the database
    $user_id = $_SESSION["email"];
    $sql = "SELECT first_name, last_name FROM traveler WHERE email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // check if the user array is empty before accessing it's keys
    if (!empty($user)) {
        // display the user's name
        $user_name = $user["first_name"] . " " . $user["last_name"];

    } else {
        // handle the case where the user isn't found
        echo "<div class = 'text-danger'>
            <span class = 'close-btn' onclick = 'alertBox()'>&times;</span>
            User Not Found
        </div>";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>International Eats: Homepage</title>
        <link rel = "stylesheet" href = "iEats_homepage_style.css">

        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

        <!-- icon fonts stylesheet -->
        <link rel="stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

        <!-- hamburger menu icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <!-- navigation bar starts -->
        <nav>
            <ul>
                <li><a href = "iEats_homepage_intro.php" class = "active">Home</a></li>
                <li><a href = "iEats_about_intro.php">About</a></li>
                <li><a href = "iEats_destination_search.php">Destination</a></li>
                <li><a href = "iEats_findYourFood_search.php">Find Your Food</a></li>
                <div class = "nav-right">
                    <li><a href = "iEats_admin_profile.php">Admin</a></li>
                </div>
            </ul>
            <!-- navigation bar ends -->
        </nav>

        <br><br><br>

        <!-- text to welcome the user with their name -->
        <div class = "intro">
            <span class = "welcome">Welcome </span><span class = "name"><?php echo $user_name ?>!</span>
        </div>
        <h5 style = "text-align: center;">Direct yourself to the admin tab to view your traveler profile.</h5>

        <br><br><br>

        <!-- new traveler -->
        <div class = "container">
            <!-- card content -->
            <div class = "new-traveler-card">
                <!-- image -->
                <div class = "new-image">
                    <img src = "./images/new_traveler.png" class = "new-traveler-card-image">
                </div>
                <!-- content box -->
                <div class = "new-traveler-card-content-box">
                    <h2 class = "new-traveler-card-title">New Traveler?</h2>
                    
                    <!-- content words -->
                    <div class = "new-traveler-card-content">
                        <h4>OUR new travelers are new to the website, but some also happen to also be new to traveling as well.</h4>
                        <h4>Regardless of circumstance, everybody should aim to learn more about <span style = "color: #0c502e; text-transform: uppercase; font-weight: 700;">International Eats</span>.</h4>

                        <!-- button to lead to the about page -->
                        <div class = "new-traveler-card-button">
                            <button type = "button" class = "about-button" style = "margin: auto;">
                                <a href = "iEats_about_intro.php">Who Are We?</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- experienced traveler -->
            <!-- card content -->
            <div class = "experienced-traveler-card">
                <!-- image -->
                <div class = "experienced-image">
                    <img src = "./images/experienced_traveler.png" class = "experienced-traveler-card-image">
                </div>
                <!-- content box -->
                <div class = "experienced-traveler-card-content-box">
                    <h2 class = "experienced-traveler-card-title">Experienced Traveler?</h2>

                    <!-- content words -->
                    <div class = "experienced-traveler-card-content">
                        <h4>Experienced travelers aren't just NOT new to our website, but are also prone to traveling.</h4>
                        <h4>But even with that experience, you may still fall victim to common traveling issues.</h4>
                        <h4>Sometimes you may know what you want to eat, but not where you can find it.</h4>

                        <!-- button to lead to the destination page -->
                        <button type = "button" class = "destination-button" style = "margin: auto;">
                            <a href = "iEats_destination_search.php">Destination</a>
                        </button>

                        <h4>Other times you may know where you want to go, but not what you can eat there.</h4>

                        <!-- button to lead to the find your food page -->
                        <button type = "button" class = "find-food-button" style = "margin: auto;">
                            <a href = "iEats_findYourFood_search.php">Find Your Food</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer  begins -->
        <hr>
        <footer style = "text-align: center;" class = "footer">
            <a href = "iEats_homepage_intro.php"><img src = "./images/iEats_logo.png" width = "35" height = "35"></a><span style = "font-size: medium;">International Eats | &copy; 2024 Copyright</span>
        </footer>
        <!-- footer ends -->

        <!-- loading overlay -->
        <div class = "loading-overlay" id = "loadingOverlay">
            <div class = "loading-spinner"></div>
        </div>

        <script>
            function alertBox() {
                this.parentElement.style.display = "none";
            }
        </script>
    </body>
</html>