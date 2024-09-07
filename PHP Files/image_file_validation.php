<?php

    // function that validates image files
    function insertValidateImage($img_file_name, $error_array) {
        if (!empty($_FILES[$img_file_name]["name"])) {
            // if the file was successfully uploaded without errors
            if ($_FILES[$img_file_name]["error"] === UPLOAD_ERR_OK) {
                $target_directory = "images/"; // target directory
                $img_name = $target_directory . basename($_FILES[$img_file_name]["name"]); // sanitize image name
                $tmp_name = $_FILES[$img_file_name]["tmp_name"]; // temporary file name

                // move the uploaded file to the target directory
                if (move_uploaded_file($tmp_name, $img_name)) {

                    $img_size = $_FILES[$img_file_name]["size"]; // file size

                    // check for the extension
                    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
                    $img_extension = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));

                    // if that specific file is allowed
                    if (!in_array($img_extension, $allowed_extensions)) {
                        // push the message into the errors array
                        array_push($error_array, "Only JPG, JPEG, PNG, and GIF files are allowed");

                    } elseif ($img_size > 1000000) { 
                        array_push($error_array, "Image size is too large.");
                    }
                } else { // file wasn't able to move into the target directory
                    array_push($error_array, "Failed to move the uploaded file to the target directory.");
                }
            } else { // error in uploading the file
                array_push($error_array, "Error uploading file: " . $_FILES[$img_file_name]["error"]);
            }

        } else { // let the user know that there was no image found
            array_push($error_array, "No image for food 1 found.");
        }
    }

    // function insertValidateImage($img_file_name, $error_array) {
    //     if (!empty($_FILES[$img_file_name]["name"])) {
    //         // if the file was successfully uploaded without errors
    //         if ($_FILES[$img_file_name]["error"] === UPLOAD_ERR_OK) {
    //             $target_directory = "images/"; // target directory
    //             $tmp_name = $_FILES[$img_file_name]["tmp_name"]; // temporary file name

    //             // get the MIME type of the uploaded file
    //             $img_extension = mime_content_type($tmp_name);
    //             // check for the extension using MIME types
    //             $allowed_extensions = array("image/jpg","image/jpeg", "image/png", "image/gif");

    //             $img_name = $target_directory . basename($_FILES[$img_file_name]["name"]); // sanitize image name

    //             // if that specific file is allowed
    //             if (!in_array($img_extension, $allowed_extensions)) {
    //                 // push the message into the errors array
    //                 array_push($error_array, "Only JPG, JPEG, PNG, and GIF files are allowed");

    //             } else {
    //                 // move the uploaded file to the target directory
    //                 if (move_uploaded_file($tmp_name, $img_name)) {
    //                     $img_size = $_FILES[$img_file_name]["size"]; // file size

    //                     // check if the image is too large to upload
    //                     if ($img_size > 1000000) { 
    //                         array_push($error_array, "Image size is too large.");
    //                     }

    //                 } else { // file wasn't able to move into the target directory
    //                     array_push($error_array, "Failed to move the uploaded file to the target directory.");
    //                 }
    //             }
                
    //         } else { // error in uploading the file
    //             array_push($error_array, "Error uploading file: " . $_FILES[$img_file_name]["error"]);
    //         }

    //     } else { // let the user know that there was no image found
    //         array_push($error_array, "No image for food 1 found.");
    //     }
    // }

?>