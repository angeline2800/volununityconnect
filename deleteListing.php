<?php

    include "connection.php";

    // Sanitize the 'id' parameter to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Construct the SQL DELETE query
    $sql = "DELETE FROM voluntaryWork WHERE id = $id";

    // Execute the DELETE query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result)
    {
        // Redirect back to the listings page with a success message
        header("Location: listings.php?msg=Record deleted successfully");
        exit(); // Make sure to exit after redirection
    } 
    else 
    {
        // If the query fails, display an error message
        echo "Failed: " . mysqli_error($conn);
    }
?>
