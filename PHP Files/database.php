<?php

    $servername = "localhost";
    $username = "akinyemi_international_eats";
    $password = "562606_";
    $db_name = "international_eats";

    // create the connection
    $conn = new mysqli($servername, $username, $password, $db_name);

    // check the connection
    if ($conn->connect_error) {
        // handle the connection error
        die("<h6 style = 'text-align: center;'>Failed to connect to the database: " . $conn->connect_error . "</h6>");
    }

?>