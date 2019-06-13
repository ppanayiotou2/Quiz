<?php

    require_once('dblogin.php');

    $q_id = $_POST['q_id'];
    $sql = "SELECT * FROM questions WHERE id ='$q_id'";
    $conn = get_connection();

    $result = mysqli_query($conn, $sql);  
    $row = mysqli_fetch_array($result);  
    echo json_encode($row);
