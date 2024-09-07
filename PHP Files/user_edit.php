<?php

    // function that obtains the row aligning with the email
    function getUserByEmailUser($email, $username, $database) {
        // select query
        $sql_select = "SELECT * FROM traveler WHERE email = ? AND username = ?";
        // prepare
        $stmt_select = $database->prepare($sql_select);
        // bind
        mysqli_stmt_bind_param($stmt_select,"ss", $email, $username);
        // execute
        $stmt_select->execute();
        // get the result
        $result_select = $stmt_select->get_result();

        $user_data = $result_select->fetch_assoc();
        $stmt_select->close();

        // fetch the row aligning with the email in question
        // if (mysqli_num_rows($result_select) > 0) {
        //     $user_data = $result_select->fetch_assoc();
        //     // return user_data
        //     return $user_data;

        // }
        return $user_data;
    }

?>