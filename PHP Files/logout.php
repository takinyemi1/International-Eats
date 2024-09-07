<?php

    session_start();
    // destroy the session
    session_destroy();
    // redirect them to the login.php
    header("Location: login.php");

?>