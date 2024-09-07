<?php 

    session_start();

    include "database.php";

?>

<!-- html -->
<!DOCTYPE html>
<html>
    <head>
        <title>International Eats: Destination</title>
        <link rel = "stylesheet" href = "display.css">

        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

        <!-- icon fonts stylesheet -->
        <link rel="stylesheet" href = "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

        <!-- hamburger menu icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- jquery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>

    <body>

        <br><br>

        <?php

            $food_id = $_GET["id"];
            $food_number = $_GET["food"];

            if ((isset($food_id)) && (isset($food_number))) {

                // use $food_number to determine which food is needed to be displayed
                $food_column = ($food_number == 1) ? "popular_food1" : "popular_food2";
                $city_column = ($food_number == 1) ? "popular_city1" : "popular_food2";
                $food_image_column = ($food_number == 1) ? "food_image" : "food_image_two";
                $country_image_column = ($food_number == 1) ? "country_image" : "country_image_two";
                
                $sql = "SELECT $food_column, $city_column, country_name, continent, $food_image_column, $country_image_column FROM country WHERE id = $food_id";
                $result = mysqli_query($conn, $sql);

                // if the number of rows are more than 0
                if (mysqli_num_rows($result) > 0) {

                    $row = mysqli_fetch_assoc($result);

                    // the image path
                    $food_image_path = "./images/" . $row[$food_image_column];
                    $country_image_path = "./images/" . $row[$country_image_column];

                    ?>

                    <img class = "food-main" src = "<?= htmlspecialchars($food_image_path) ?>">
                    <h2><?= htmlspecialchars($row[$food_column]) ?></h2>
                    <hr class = "hr">
                    <h2>Where is it located?</h2><br>
                    <p><?= htmlspecialchars($row[$city_column] . ', ' . $row["country_name"] . ', ' . $row["continent"]) ?></p>
                    <img class = "country-main" src = "<?= htmlspecialchars($country_image_path) ?>">
                    <hr class = "hr">
                    <br>
                    <button type = "button" class = "btn"><a href = "iEats_destination_search.php">Back</a></button>
                    <br><br><br>
                    <?php

                } else {
                    echo '<h2>Food Not Found.</h2>';
                    echo '<img class = "empty" src = "./images/not-found.gif">';
                }

            } // if there's no food found
            else {
                echo '<h2>Invalid Request.</h2>';
                echo '<img class = "empty" src = "./images/invalid.gif">';
            }
        ?>



        <!-- footer  begins -->
        <hr>
        <footer style = "text-align: center;" class = "footer">
            <a href = "iEats_homepage_intro.php"><img src = "./images/iEats_logo.png" width = "35" height = "35"></a><span style = "font-size: medium;">International Eats | &copy; 2024 Copyright</span>
        </footer>
        <!-- footer ends -->
    </body>
</html>