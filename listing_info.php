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
                  <li id= "topnav"><a href="review_application.php">Received Application</a></li>
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
            <center><h2> Listing Information</h2></center>

            <?php
                // Include database connection
                include 'connection.php';

                if (isset($_GET['work_id'])) 
                {
                    // Sanitize the work ID
                    $workId = mysqli_real_escape_string($conn, $_GET['work_id']);

                    // Query to retrieve voluntary work information based on the work ID
                    $query = "SELECT * FROM voluntaryWork WHERE id = $workId";

                    $result = mysqli_query($conn, $query);

                    // Check if the query was successful and if a row was returned
                    if ($result && mysqli_num_rows($result) > 0) 
                    {
                        // Fetch the user information including the application ID
                        $workInfo = mysqli_fetch_assoc($result);
                        // Display the listing information
                        echo '<div class = "columnUser">';
                        echo '<div class="column1">';
                        echo "<p>Voluntary Work Title</p>";
                        echo "<p>Voluntary Work Description</p>";

                        if ($workInfo['workType'] == 'One Time') 
                        {
                            echo "<p>Date</p>";
                        } 
                        elseif ($workInfo['workType'] == 'Recurring') 
                        {
                            echo "<p>Weekly Recurrence</p>";
                        }

                        echo "<p>Time</p>";
                        echo "<p>City</p>";
                        echo "<p>State</p>";
                        echo "<p>Type</p>";
                        echo "<p>Pictures</p>";
                        echo "</div>"; //End Column 1

                        echo '<div class="column2">';
                        echo "<p> : " . $workInfo['workTitle'] . "</p>";
                        echo "<p> : " . $workInfo['workDes'] . "</p>";

                        if ($workInfo['workType'] == 'One Time') 
                        {
                            echo "<p> : " . $workInfo['workDate'] . "</p>";
                        } 
                        elseif ($workInfo['workType'] == 'Recurring') 
                        {
                            // Display recurring details
                            echo "<p> : Every " . $workInfo['workRecur'] . "</p>";
                        }

                        echo "<p> : " . $workInfo['workStartTime'] . " - " .$workInfo['workEndTime']."</p>";
                        echo "<p> : " . $workInfo['workCity'] . "</p>";
                        echo "<p> : " .$workInfo['workState']. "</p>";
                        echo "<p> : " .$workInfo['workType']. "</p>";
                        echo "<p> : " .'<img src = "Photos/' . $workInfo['workPic'] . '"/>' . "</p>";
                        echo "</div>";
                        echo "</div>";?>

                        <a class = "back" href='listings.php'><button style="margin-left:15%; margin-top:11%;">Back to Listings Page</button></a>
            <?php
                    }
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