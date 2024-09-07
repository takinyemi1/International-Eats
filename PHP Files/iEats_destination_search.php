<?php 

    session_start();

    include "database.php";

?>

<!-- html -->
<!DOCTYPE html>
<html>
    <head>
        <title>International Eats: Destination</title>
        <link rel = "stylesheet" href = "iEats_destination_style.css">

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
            <!-- <img src = "images/iEats_logo.png" class = "nav-logo"> -->
            <ul>
                <li><a href = "iEats_homepage_intro.php">Home</a></li>
                <li><a href = "iEats_about_intro.php">About</a></li>
                <li><a href = "iEats_destination_search.php" class = "active">Destination</a></li>
                <li><a href = "iEats_findYourFood_search.php">Find Your Food</a></li>
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
        <!-- <form action = "iEats_destination_search.php" class = "search-destination-form" method = "post"> -->
        <form action = "iEats_destination_search.php" method = "post" class = "search-destination-form">

            <h1><code>::destination</code></h1>

            <br>

            <blockquote>
                <p>If you don't know where you would like to travel, but do know about what foods that you would like to eat during your travels, you're in the right place.</p>
                <p>Search here for those foods that you would like to eat to generate results about the countries that they originate from, as well as
                    the different restaurants over the world where they are also served.
                </p>
                <p>From there, you will be able to find at least ONE city where those foods are most popular, thereby finding your newest travel <span style = "text-transform: uppercase;">destination</span>.</p>
            </blockquote>

            <div class = "search-container">
                <!-- search bar -->
                <input type = "text" name = "searchFood" placeholder = "Search For a Food..." class = "search-bar-food">
                <input type = "image" src = "./images/search.png" name = "search" class = "search-bar">
                <!-- <button type = "submit" name = "search" class = "search-bar-button">Search</button> -->
            </div>
        </form>

        <br><br>

        <!-- table to hold the search results -->
        <div class = "container-table">
            <!-- actual table -->
            <ul class = "destination-table">
                <?php
                
                    include "database.php";

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        // food variable textbox
                        $food = $_POST["searchFood"];
                        $search_food = mysqli_real_escape_string($conn, $food);

                        // if the search box isn't empty
                        if (!empty($search_food)) {

                            // popular food 1
                            $sql1 = "SELECT * FROM country WHERE popular_food1 LIKE '%$search_food%'";
                            $result1 = mysqli_query($conn, $sql1);

                            // popular food 2
                            $sql2 = "SELECT * FROM country WHERE popular_food2 LIKE '%$search_food%'";
                            $result2 = mysqli_query($conn, $sql2);

                            if ((mysqli_num_rows($result1) > 0) || (mysqli_num_rows($result2) > 0)) {

                                echo '<h2 style = "text-align: center; font-weight: 600;">Click on the food to learn more about it.</h2>';

                                // echo the headers up here so that they don't repeat
                                echo '<li class = "destination-th">
                                        <div class = "col col-1">Food</div>
                                        <div class = "col col-2">City</div>
                                        <div class = "col col-3">Country</div>
                                    </li>
                                ';

                                // popular food 1
                                while ($row = $result1->fetch_assoc()) {

                                    echo 
                                    // table rows
                                    // <div class = "col col-1" data-label = "Food">'.$row["popular_food1"].'</div>
                                    '<li class = "destination-tr">
                                        <div class = "col col-1" data-label = "Food"><a class = "dis" href = "destination_display.php?id='. $row["id"] .'&food=1">' . htmlspecialchars($row["popular_food1"]) . '</a></div>
                                        <div class = "col col-2" data-label = "City">'.$row["popular_city1"].'</div>
                                        <div class = "col col-3" data-label = "Country">'.$row["country_name"].'</div>
                                    </li>
                                    ';
                                }

                                // popular food 2
                                while ($row = $result2->fetch_assoc()) {

                                    echo 
                                    // table headers
                                    '<li class = "destination-tr">
                                        <div class = "col col-1" data-label = "Food"><a class = "dis" href = "destination_display.php?id=' . $row["id"] . '&food=2">'.htmlspecialchars($row["popular_food2"]).'</a></div>
                                        <div class = "col col-2" data-label = "City">'.$row["popular_city2"].'</div>
                                        <div class = "col col-3" data-label = "Country">'.$row["country_name"].'</div>
                                    </li>
                                    ';
                                }

                            } else { // if the number of rows is < 0
                                echo '<h2 style = "text-align: center; font-weight: 600;">Data Not Found.</h2>';
                                echo '<h2 style = "text-align: center; font-weight: 600;">In the future, the entry for <span style = "color: #7584ad;">'.$search_food.'</span> will be updated.</h2>';
                            }

                        } else { // if the box is empty
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