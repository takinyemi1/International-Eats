<!DOCTYPE html>
<html>
    <head>
        <title>International Eats: About Us</title>
        <link rel = "stylesheet" href = "iEats_about_style.css">

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
                <li><a href = "iEats_about_intro.php" class = "active">About</a></li>
                <li><a href = "iEats_destination_search.php">Destination</a></li>
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

        <br><br><br>

        <div class = "main-words"></div>

        <!-- image container for image modal -->
        <div class = "carousel-img" style = "text-align: center;">
            <div class = "carousel-img-slider">
                <div class = "carousel-img-slide-track">
                    <div class = "img">
                        <img src = "images/iEats_logo.png" class = "carousel-image">
                    </div>
                    <div class = "img">
                        <img src = "images/eat1.jpg" class = "carousel-image">
                    </div>
                    <div class = "img">
                        <img src = "images/eat2.jpg" class = "carousel-image">
                    </div>
                    <div class = "img">
                        <img src = "images/eat3.jfif" class = "carousel-image">
                    </div>
                    <div class = "img">
                        <img src = "images/eat4.jfif" class = "carousel-image">
                    </div>
                    <div class = "img">
                        <img src = "images/eat5.jpg" class = "carousel-image">
                    </div>
                    <div class = "img">
                        <img src = "images/where1.jpg" class = "carousel-image">
                    </div>
                    <div class = "img">
                        <img src = "images/where2.jfif" class = "carousel-image">
                    </div>
                    <div class = "img">
                        <img src = "images/where3.jpg" class = "carousel-image">
                    </div>
                    <div class = "img">
                        <img src = "images/where4.jfif" class = "carousel-image">
                    </div>
                    <div class = "img">
                        <img src = "images/where5.jfif" class = "carousel-image">
                    </div>
                </div>
            </div>
        </div>
        <!-- carousel ends -->

        <br><br><br>

        <!-- footer  begins -->
        <hr>
        <footer style = "text-align: center;" class = "footer">
            <a href = "iEats_homepage_intro.php"><img src = "./images/iEats_logo.png" width = "35" height = "35"></a><span style = "font-size: medium;">International Eats | &copy; 2024 Copyright</span>
        </footer>
        <!-- footer ends -->

        <script src = "iEats_about_function.js"></script>
    </body>
</html>