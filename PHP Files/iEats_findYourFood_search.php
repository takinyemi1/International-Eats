<?php

    session_start();
    include "database.php";

?>

<!DOCTYPE html>
<html>
    <head>
        <title>International Eats: Find Your Food</title>
        <link rel = "stylesheet" href = "iEats_findYourFood_style.css">

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
            <ul>
                <li><a href = "iEats_homepage_intro.php">Home</a></li>
                <li><a href = "iEats_about_intro.php">About</a></li>
                <li><a href = "iEats_destination_search.php">Destination</a></li>
                <li><a href = "iEats_findYourFood_search.php" class = "active">Find Your Food</a></li>
                <div class = "nav-right">
                    <li><a href = "iEats_admin_profile.php">Admin</a></li>
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

        <!-- form for the search bar -->
        <form action = "iEats_findYourFood_search.php" class = "search-food-form" method = "post">

            <h1><code>::find your food</code></h1>

            <br>

            <blockquote>
                <p>Now, if you do know where you would like to travel, but not about what to eat there, you're in the right place.</p>
                <p>Search here for those foods that you would like to eat to generate results about the countries that they originate from, as well as
                    the different restaurants over the world where they are also served.
                </p>
                <p>From there, you will be able to find at least ONE city where those foods are most popular, thereby finding your newest travel <span style = "text-transform: uppercase;">destination</span>.</p>
            </blockquote>

            <div class = "search-container">
                <!-- search bar -->
                <input type = "text" name = "searchCountry" placeholder = "Search For a Country..." class = "search-bar-country">
                <!-- <input type = "submit" name = "search" class = "search-bar"> -->
                <input type = "image" src = "./images/search.png" name = "search" class = "search-bar">
            </div>
        </form>

        <br><br> 

        <!-- table that holds the search results -->
        <div class = "container-table">
            <!-- table -->
            <ul class = "food-table">
                <?php

                    include "database.php";

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        // country variable textbox
                        $country = $_POST["searchCountry"];
                        $search_country = mysqli_real_escape_string($conn, $country);

                        // if the search box isn't empty
                        if (!empty($search_country)) {

                            // country_of_origin
                            $sql = "SELECT * FROM food WHERE country_of_origin LIKE '%$search_country%'";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {

                                echo '<h2 style = "text-align: center; font-weight: 600;">Click on the country to learn more about it.</h2>';
                                echo '
                                    <li class = "food-th">
                                        <div class = "col col-1">Country</div>
                                        <div class = "col col-2">Food</div>
                                        <div class = "col col-3">Description</div>
                                    </li>
                                ';

                                // country
                                while ($row = $result->fetch_assoc()) {

                                    // <div class = "col col-1" data-label = "Country"><a class = "dis" href = "food_display.php?id='.$row["id"].'</a>'. htmlspecialchars($row["country_of_origin"]) . '</div>

                                    echo '
                                        <li class = "food-tr">
                                            <div class = "col col-1" data-label = "Country"><a class = "dis" href = "food_display.php?country_of_origin=' . htmlspecialchars($row["country_of_origin"]) . '">' . htmlspecialchars($row["country_of_origin"]) .'</a></div>
                                            <div class = "col col-2" data-label = "Food">' . htmlspecialchars($row["food_name"]) . '</div>
                                            <div class = "col col-3" data-label = "Description">' . htmlspecialchars($row["description"]) . '</div>
                                        </li>
                                    ';
                                }

                            } else {
                                echo '<h2 style = "text-align: center; font-weight: 600;">Data Not Found.</h2>';
                                echo '<h2 style = "text-align: center; font-weight: 600;">In the future, the entry for <span style = "color: #c290df;">' . htmlspecialchars($search_country) . '</span> will be updated.</h2>';
                            }

                        } else {
                            echo '<h2 style = "text-align: center; font-weight: 600;">Please enter a search item.</h2>';
                            echo '<img class = "empty" src = "./images/search-empty.gif">';
                        }
                    }
                ?>
            </ul>
        </div>

        <br><br>

        <!-- footer  begins -->
        <hr>
        <footer style = "text-align: center;" class = "footer">
            <a href = "iEats_homepage_intro.php"><img src = "./images/iEats_logo.png" width = "35" height = "35"></a><span style = "font-size: medium;">International Eats | &copy; 2024 Copyright</span>
        </footer>
        <!-- footer ends -->
    </body>
</html>