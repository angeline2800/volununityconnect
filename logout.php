<?php 
    session_start();  ob_start();
    include 'connection.php';

    $id = $_SESSION['user_id'];
    $sql = "UPDATE user SET _login= 0 WHERE id='$id'";

    $result = mysqli_query ($conn,$sql);
    //See if updated
    if($result == true)
    {
        echo "UPDATED LOGIN";
    } 
    else
    {
        echo "Failed to update". $conn->error;
    }

    session_destroy();
    header("Location: login.php"); 

    exit();ob_end_flush();
?>
