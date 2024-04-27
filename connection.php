<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";

    error_reporting(~E_WARNING);
    mysqli_report(MYSQLI_REPORT_STRICT);

    // Create connection
    $conn = mysqli_connect($servername, $username, $password);

    //Check connection
    if (!$conn) 
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    else
    {
   //     echo "Connection successful!";
    }

    $sql = "CREATE DATABASE VUC";
    $result = mysqli_query($conn, $sql);
    if ($result === TRUE) 
    {
        echo "Database created successfully";
    }
    else
    {
  //      echo "Database creation failed:" . mysqli_error($conn);
    }

    $dbname = "VUC";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    //Check connection
    if (!$conn) 
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    else
    {
   //     echo "Connection successful!";
    }
