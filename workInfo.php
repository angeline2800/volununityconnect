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

        <script>
        // Function to display a pop-up message
        function showMessage(message) {
            alert(message);
            window.location.href = "application.php"; // Redirect to index.html after OK is clicked
        }
    </script>
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
                  <li id= "topnav"><a href="application.php">My Application</a></li>
                  <li id= "topnav"><a href="#">|</li>
                  <li id= "active"><a href="index.html">Home</a></li>
                  <li><a href="index.html"><img class="logo" src="Pictures/icon.png" alt="VolunUnity Connect"></a></li>
                </ul>

                <ul>
                  <li><a href="logout.php"  ><?php echo $logout?></a></li>
                  <li><a href="register.php"><?php echo $signup?></a></li>
                  <li>&nbsp&nbsp|&nbsp</li>
                  <li><a href="login.php" ><?php echo $login?></a></li>
                  <li><a href="myProfile.php"  ><?php echo $myprofile?></a></li>
                  <li><img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon"></a>
                </ul>
                
            </div>
              
        </header>

        <main id="Push_main">
        <div class="slidebanner-container">
        <section class="Showcase">
        <div class="row">
        
        <form method="POST" action="filter_work.php">
        <label for="state">Select State:</label>
        <select name="state" id="state">

        <?php 

            include 'connection.php';

        // Retrieve selected state from form
        $selected_state = $_POST['state'];
        ?>

            <option value="All" <?php echo ($selected_state == "All") ? "selected" : ""; ?>>All States</option>
            <option value="Johor" <?php echo ($selected_state == "Johor") ? "selected" : ""; ?>>Johor</option>
            <option value="Kedah" <?php echo ($selected_state == "Kedah") ? "selected" : ""; ?>>Kedah</option>
            <option value="Kelantan" <?php echo ($selected_state == "Kelantan") ? "selected" : ""; ?>>Kelantan</option>
            <option value="Melaka" <?php echo ($selected_state == "Melaka") ? "selected" : ""; ?>>Melaka</option>
            <option value="Negeri Sembilan" <?php echo ($selected_state == "Negeri Sembilan") ? "selected" : ""; ?>>Negeri Sembilan</option>
            <option value="Pahang" <?php echo ($selected_state == "Pahang") ? "selected" : ""; ?>>Pahang</option>
            <option value="Penang" <?php echo ($selected_state == "Penang") ? "selected" : ""; ?>>Penang</option>
            <option value="Perak" <?php echo ($selected_state == "Perak") ? "selected" : ""; ?>>Perak</option>
            <option value="Perlis" <?php echo ($selected_state == "Perlis") ? "selected" : ""; ?>>Perlis</option>
            <option value="Sabah" <?php echo ($selected_state == "Sabah") ? "selected" : ""; ?>>Sabah</option>
            <option value="Sarawak" <?php echo ($selected_state == "Sarawak") ? "selected" : ""; ?>>Sarawak</option>
            <option value="Selangor" <?php echo ($selected_state == "Selangor") ? "selected" : ""; ?>>Selangor</option>
            <option value="Terengganu" <?php echo ($selected_state == "Terengganu") ? "selected" : ""; ?>>Terengganu</option>
        </select>

        <input type="submit" value="Search" class="search-button">
        </form>
        </div>

        <br><br><br><br>
        <div class="row">
            <h3 id = "voluntaryWork"> Voluntary Work </h3>
            <?php 
                include 'connection.php';

                // Check if the form is submitted and the work_id is set
                if(isset($_POST['work_id']))
                {
                     $work_id = $_POST['work_id'];

                 // Query to retrieve details of the selected voluntary work based on its id
                $sql = "SELECT * FROM voluntaryWork WHERE id='$work_id'";
                $result = $conn->query($sql);

                // Check if the query was successful and if a row was returned
                if ($result && $result->num_rows > 0) {
                // Fetch the details of the selected voluntary work
                $row = $result->fetch_assoc();
                // Display the details
                echo '<form name="workInfo" method="post" action="workInfo.php">';
                      echo '<div class="column"><div class = "card_info">';
                      
                      
                      if ($row["workType"] == "One Time") {
                        echo '' .'<img src = "Photos/' . $row['workPic'] . '"/>' . '';
                        echo '  <div class="grid-container_1"> <h2>' . $row["workTitle"]. '</h2></div>';
                        echo '  <div class="grid-container_5"> <p>' . $row["workDes"] .  '</p></div>';
                        echo '  <div class="grid-container_2"> <p>' . "Date : ". $row["workDate"] .  '</p></div>';
                        echo '  <div class="grid-container_2"> <p>' . "Time : " .$row["workStartTime"] .  " - " .$row["workEndTime"].'</p></div>';
                        echo '  <div class="grid-container_2"> <p>' . "Location : ". $row["workCity"] . " , ".$row['workState'] .'</p></div>';
                        echo '<br><br><br><br>';
                        echo '<input type="hidden" name="work_id" value="' .$row["id"]. '">';
                    } else if ($row["workType"] == "Recurring") {
                        echo '' .'<img src = "Photos/' . $row['workPic'] . '"/>' . '';
                        echo '  <div class="grid-container_1"> <h2>' . $row["workTitle"]. '</h2></div>';
                        echo '  <div class="grid-container_5"> <p>' . $row["workDes"] .  '</p></div>';
                        echo '  <div class="grid-container_2"> <p>' . "Event Recurrence : Every " . $row["workRecur"] .  '</p></div>';
                        echo '  <div class="grid-container_2"> <p>' . "Time : " .$row["workStartTime"] .  " - " .$row["workEndTime"].'</p></div>';
                        echo '  <div class="grid-container_2"> <p>' . "Location : ". $row["workCity"] . " , ".$row['workState'] .'</p></div>';
                        echo '<br><br><br><br>';
                        echo '<input type="hidden" name="work_id" value="' .$row["id"]. '">';
                    }

                      echo '</form>';
                      $userid = $_SESSION['user_id']; 
                      $check_query = "SELECT * FROM application WHERE userid = '$userid' AND workid = '$work_id'";
                      $check_result = $conn->query($check_query);
                      
                      if ($check_result->num_rows > 0) {
                          // User has already applied, disable the button and show message
                          echo '<form name="checkApplication" method="post" action="application.php">';
                          echo '<input class="button" type="submit" name="check_application" value="Application submitted. Please check My Application to track the status.">';
                      } else {
                          // User has not applied, show apply button
                          echo '<input class="button" type="submit" name="apply_button" value="Apply">';
                      }
                      echo '</form>';

                       // Handle form submission
                       if (isset($_POST['apply_button'])) {
                        // Insert new record into the application table
                        $userid = $_SESSION['user_id']; 
                        $status = "Pending"; // Assuming the initial status is "Pending"
                        $createdAt = date('Y-m-d H:i:s'); // Current timestamp
                        $insert_query = "INSERT INTO application (userid, workid, createdAt, status) VALUES ('$userid', '$work_id', '$createdAt', '$status')";
                        if ($conn->query($insert_query) === TRUE) {
                            echo '<script>showMessage("Application is submitted successfully!");</script>';
                        } else {
                            //echo "Error: " . $insert_query . "<br>" . $conn->error;
                            echo "<script>alert('Please Login to Apply Voluntary Work!');</script>";
                            echo "<script>window.location.href = 'login.php';</script>";
                        }
                        
                    }
                // You can display other details as needed
                echo '</div>';
                } else {
                // If no voluntary work found with the selected id
                echo '<p>No details found for the selected voluntary work.</p>';
                }
            }
            ?>

        </div>

        </section>
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

