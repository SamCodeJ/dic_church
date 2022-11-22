<?php
    $servername = "127.0.0.1:3308";
    $username = "root";
    $password = "";
    $database = "church_db";

    $conn = new mysqli($servername, $username, $password, $database);

    if($conn->connect_error){
        die("Connection failed");
    }
?>