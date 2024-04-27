<?php session_start();  ob_start();?> 

<!DOCTYPE html>

<html lang="en">

    <head>
        <title>VolunUnity Connect</title>
        <link rel="icon" href="Pictures/iconsmall.png">
        <link rel="shortcut icon" href="Pictures/iconsmall.png">
        <link rel="stylesheet" href="CSS/stylesheet.css">
        <link rel="stylesheet" href="CSS/footer.css">
        <script src="slides.js"></script>
    </head>
    <body>

    <?php

        // Create database & connection
        include 'connection.php';

        //Declarations
        $signup = $login = $logout = $myprofile = "";

        //Check if session login is defined
        if (isset($_SESSION['login'])) 
        {
            //If it is defined, then we check is it Logged in 
            if($_SESSION['login'] === "Logged In")
            {
                //Show logout and profile button  
                $logout = "Logout"; 
                $myprofile = "My Profile";
            }
        }
        else //session login not set yet
        {
            //Show sign up and login button  
            $signup = "Sign Up"; 
            $login = "Login";
        } 


        if(isset($_SESSION['user_id']))
            $userid = $_SESSION['user_id'];
        //END SESSION DECLARATION 
        
    ?>
    
        <header class="HeaderHeader" id="Push_header">
            <div class="login_register">
                <ul id = abc>
                  <li id= "active"><a href="review_application.php">Received Application</a></li>
                  <li id= "topnav"><a href="#">|</li>
                  <li id= "topnav"><a href="listings.php">My Listing</a></li> 
                  <li id= "topnav"><a href="#">|</li>
                  <li id= "topnav"><a href="create_listing.php">Create Listing</a></li>
                  <li><a href="create_listing.php"><img class="logo" src="Pictures/icon.png" alt="VolunUnity Connect"></a></li>
                </ul>

                <ul>
                  <li><a href="logout.php"  ><?php echo $logout?></a></li>
                  <li><a href="register.php"><?php echo $signup?></a></li>
                  <li>&nbsp&nbsp|&nbsp</li>
                  <li><a href="login.php" ><?php echo $login?></a></li>
                  <li><a href="myProfile_organizer.php"  ><?php echo $myprofile?></a></li>
                  <li><img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon"></a>
                </ul>
            </div>
        </header>

        <main id="Push_main">
        <div class="slidebanner-container">
            <section class="Showcase">
            <div class = "user_info">
            <center><h2> User Information</h2></center>

            <?php
            // Include database connection
            include 'connection.php';

            // Check if the user ID and application ID are provided in the URL
            if (isset($_GET['user_id']) && isset($_GET['application_id'])) 
            {
                // Sanitize the user ID and application ID
                $userId = mysqli_real_escape_string($conn, $_GET['user_id']);
                $applicationId = mysqli_real_escape_string($conn, $_GET['application_id']);

                // Query to retrieve user information and application ID based on user ID and application ID
                $query = "SELECT user.id AS user_id, user.firstname, user.lastname, user.email, user.gender, user.phone, user._state, user.city, user.resume_file, 
                application.id AS application_id, voluntaryWork.id AS work_id, voluntaryWork.workTitle
                FROM user
                INNER JOIN application ON user.id = application.userid
                INNER JOIN voluntaryWork ON application.workid = voluntaryWork.id
                WHERE user.id = $userId AND application.id = $applicationId";

                $result = mysqli_query($conn, $query);

                // Check if the query was successful and if a row was returned
                if ($result && mysqli_num_rows($result) > 0) 
                {
                    // Fetch the user information including the application ID
                    $userInfo = mysqli_fetch_assoc($result);
                    // Display the user information
                    echo '<div class = "columnUser">';
                    echo '<div class="column1">';
                    echo "<p>Volunteer Name</p>";
                    echo "<p>Applied Voluntary Work</p>";
                    echo "<p>Gender</p>";
                    echo "<p>Living Place</p>";
                    echo "<p>Email</p>";
                    echo "<p>Phone no.</p>";
                    echo "<p>Resume</p>";
                    //echo "<p>Application ID: " . $userInfo['application_id'] . "</p>";
                    echo "</div>"; //End Column 1


                    echo '<div class="column2">';
                    echo "<p> : ". $userInfo['firstname'] . " ".$userInfo['lastname']."</p>";
                    echo "<p> : <a href='listing_info.php?work_id=" . $userInfo['work_id'] . "'>" . $userInfo['workTitle'] . "</a></p>";
                    echo "<p> : " . $userInfo['gender'] . "</p>";
                    echo "<p> : " . $userInfo['city'] . " , " .$userInfo['_state']. "</p>";
                    echo "<p> : " . $userInfo['email'] . "</p>";
                    echo "<p> : " . $userInfo['phone'] . "</p>";
                    echo "<p> : <a href='Resume/" . $userInfo['resume_file'] . "' target='_blank'>Resume of ".$userInfo['firstname']." ".$userInfo['lastname']."</a></p>";

                    echo "</div>";
                    echo "</div>";

                    echo '<div class="userInfo">';
                    echo "<form action='update_status.php' method='POST'>";
                    echo "<input type='hidden' name='user_id' value='" . $userInfo['user_id'] . "'>";
                    echo "<input type='hidden' name='application_id' value='" . $userInfo['application_id'] . "'>"; // Pass application ID
                    echo "<button class='acceptButton' type='submit' name='status' value='Accepted'>Accept</button>";
                    echo "<button class='rejectButton' type='submit' name='status' value='Rejected'>Reject</button>";
                    echo "</form>";?>

                    <a class = "back" href='review_application.php'><button>Back to Review Application</button></a>
                <?php
                    echo "</div>";

                } 
                else 
                {
                    echo "User not found or no application found for the user.";
                }
            } 
            else 
            {
                echo "User ID not provided.";
            }
        ?>
</div> 
</main>

<br><br><br><br><br><br>

<footer class="FooterFooter" id="Push_footer">
    <div class="FFooterUpperPortion">
        <div class="FFooterIcon">
            <img src="Pictures/icon.png" alt="VolunUnity Connect">
        </div>
    </div>

    <hr id="FooterLine"/><br>

    <div class="FFooterLowerPortion" >
        <sub class="Disclaimer">©2024 VolunUnity Connect - All Rights Reserved</sub>
    </div>
</footer>    
</body>
</html>

<?php ob_end_flush();?>