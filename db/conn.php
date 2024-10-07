<?php
    $host = "localhost";
    $uname = "root";
    $pass = "root";
    $db = "azhar";

    $conn = mysqli_connect($host, $uname, $pass, $db);
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    // echo "Connected successfully";

