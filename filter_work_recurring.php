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
            <div class="viewOpt">
                <a href="index.html"><button>One Time Voluntary Work</button></a>
                <button style="border: 3px solid #011A3D;"><a href="indexRecurring.php">Recurring Voluntary Work</button></a>
            </div>

            <br><br>

            <div class="row">
                <form method="POST" action="filter_work_recurring.php">
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

                <?php include 'connection.php';
                    // Query to retrieve jobs based on selected state
                    if ($selected_state == "All") 
                    {
                        $sql = "SELECT * FROM voluntaryWork WHERE workStatus=1 AND workType = 'Recurring'";
                    } 
                    else 
                    {
                        $sql = "SELECT * FROM voluntaryWork WHERE workState='$selected_state' AND workStatus=1 AND workType = 'Recurring'";
                    }
            
                    $result = $conn->query($sql);
    
                    if ($result->num_rows > 0) 
                    {
                        // output data of each row
                        while($row = $result->fetch_assoc()) 
                        {
                            echo '<form name="workInfo" method="post" action="workInfo.php">';
                            echo '<div class="column"> <div class = "card">';
                            echo '' .'<img src = "Photos/' . $row['workPic'] . '"/>' . '';
                            echo '  <div class="grid-container_1"> <h2>' . $row["workTitle"]. '</h2></div>';
                            echo '  <div class="grid-container_5"> <p>' . $row["workDes"] .  '</p></div>';
                            echo '  <div class="grid-container_5"> <h4>' . "Location : ". $row["workState"] . '</h4></div>';
                            echo '<br><br><br><br>';
                            echo '<input type="hidden" name="work_id" value="' .$row["id"]. '">';
                            echo '<input class="button" type="submit" value="More details">   ';
                            echo '</div></div>';
                            echo '</form>';
                        }
                    } 
                    else 
                    {
                        echo '<p align=center style="font-size:18px;font-family: Arial, Helvetica, sans-serif;">'."No voluntary work found for the selected state.";
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