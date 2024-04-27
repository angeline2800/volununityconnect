<?php
// Include database connection
include 'connection.php';

// Check if the POST parameters are set
if (isset($_POST['work_id']) && isset($_POST['new_status'])) 
{
    // Sanitize input data
    $workId = mysqli_real_escape_string($conn, $_POST['work_id']);
    $newStatus = mysqli_real_escape_string($conn, $_POST['new_status']);

    // Update the workStatus in the database
    $updateQuery = "UPDATE voluntaryWork SET workStatus = '$newStatus' WHERE id = '$workId'";
    if (mysqli_query($conn, $updateQuery)) {
        // If the update was successful, return success message
        echo 'success';
    } else {
        // If there was an error, return error message
        echo 'error';
    }
} 
else
{
    // If the POST parameters are not set, return error message
    echo 'error';
}


// Check if the form parameters are set
if (isset($_POST['user_id']) && isset($_POST['status']) && isset($_POST['application_id'])) {
    // Sanitize input data
    $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $applicationId = mysqli_real_escape_string($conn, $_POST['application_id']);

    // Update the application status in the database
    $updateQuery = "UPDATE application SET status = '$status' WHERE id = '$applicationId' AND userid = '$userId'";

    if (mysqli_query($conn, $updateQuery)) {
        // If the update was successful, redirect back to the user information page
        header("Location: review_application.php");
        exit();
        // echo "Query: " . $updateQuery; // Debugging: Echo the SQL query
    } else {
        // If there was an error, display error message
        echo "Error updating status: " . mysqli_error($conn);
    }
} 
else 
{
    // If the form parameters are not set, display error message
    echo "Form parameters not set.";
}

?>
