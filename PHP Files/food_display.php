<?php 

    session_start();

    include "database.php";

?>

<!-- html -->
<!DOCTYPE html>
<html>
    <head>
        <title>International Eats: Food Display</title>
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
            
            if (isset($_GET["country_of_origin"])) {

                // avoid SQL injection vulnerabilities
                $country_id = mysqli_real_escape_string($conn, $_GET["country_of_origin"]);

                // sql query
                $sql = "SELECT * FROM food WHERE country_of_origin = '$country_id'";
                $result = mysqli_query($conn, $sql);

                // if the number of rows are more than 0
                if (mysqli_num_rows($result) > 0) {

                    $row = mysqli_fetch_assoc($result);

                    // the image path
                    $country_image_path = "./images/" . $row["country_image"];
                    $food_image_path = "./images/" . $row["food_image"];
                    $restaurant_one_image_path = "./images/" . $row["restaurant_one_image"];
                    $restaurant_two_image_path = "./images/" . $row["restaurant_two_image"];
                    $restaurant_three_image_path = "./images/" . $row["restaurant_three_image"];

                    echo '<img class = "country-main" src = "'.$country_image_path.'">';
                    echo '<h2>' .htmlspecialchars($row["country_of_origin"]). '</h2>';
                    echo '<hr class = "hr">';
                    echo '<br>';
                    echo '<img class = "food-main" src = "' . $food_image_path . '">';
                    echo '<h2>' . htmlspecialchars($row["food_name"]) . '<br>' . '</h2>';
                    // echo '<hr>';
                    echo '<h2>Category <br></h2>';
                    echo '<span class = "name">' . htmlspecialchars($row["category"]) . '';
                    echo '<br>';
                    echo '<h2>Description <br></h2>';
                    echo '<span class = "name">' . htmlspecialchars($row["description"]) . '</span>';
                    echo '<hr class = "hr">';
                    echo '<h2>Where is it served?</h2> <br>';
                    echo '<span class = "name">' . htmlspecialchars($row["restaurant_one"]) . '</span>';
                    echo '<br><br>';
                    echo '<img class = "food-main" src = "' . $restaurant_one_image_path . '">';
                    echo '<br><br>';
                    echo '<span class = "name">' . htmlspecialchars($row["restaurant_two"]) . '</span>';
                    echo '<br>';
                    echo '<img class = "food-main" src = "' . $restaurant_two_image_path . '">';
                    echo '<br><br>';
                    echo '<span class = "name">' . htmlspecialchars($row["restaurant_three"]) . '</span>';
                    echo '<br>';
                    echo '<img class = "food-main" src = "' . $restaurant_three_image_path . '">';
                    echo '<hr class = "hr">';
                    echo '<br><br>';
                    echo '<button type = "button" class = "btn_"><a href = "iEats_findYourFood_search.php">Back</a></button>';
                    echo '<br><br><br>';

                } else { // if there's no food found
                    echo '<h2>Food Not Found.</h2>';
                    echo '<img class = "empty" src = "./images/not-found.gif">';
                } 

            } else {
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