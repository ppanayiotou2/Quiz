<?php

    require_once('dblogin.php');


    $q_id = $_POST['q_id'];
    $sql = "DELETE FROM questions WHERE id ='$q_id'";
    $conn = get_connection();

    if (mysqli_query($conn, $sql)) {
        echo "true";
    }
    else {
        echo "false";
    }
