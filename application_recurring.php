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

        <!-- Start Header -->
        <header class="HeaderHeader" id="Push_header">
            <div class="login_register">
                <ul id = abc>
                  <li id= "active"><a href="application.php">My Application</a></li>
                  <li id= "topnav"><a href="#">|</li>
                  <li id= "topnav"><a href="index.html">Home</a></li>
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
        <!-- End Header -->

        <!-- Content Start -->
        <main id="Push_main">
        <div class="slidebanner-container">
            <section class="Showcase">
              <div class="col-div-10">
                <div class="box-10">
                    <div class="content-box">
                        <!-- Title of the Page -->
                        <center><h2 id = "voluntaryWork"> My Application </h2></center>

                        <!-- One Time & Recurring Selection -->
                        <div class="viewOpt">
                        <a href="application.php"><button>One Time Voluntary Work</button></a>
                        <button style="border: 3px solid #011A3D;"><a href="application_recurring.php">Recurring Voluntary Work</button></a>
                        </div><br><br>
                        <!-- End One Time & Recurring Selection -->

                        <!-- Filter Application Status Option -->
                        <select style="padding:5px;margin-bottom: 25px;border: 2px solid #ff531a;float:right;" name="sortstatus" id="sortstatus" onchange="sort(this)";>
                            <option value="" disabled="" selected="">Select Filter</option>
                            <option value="Accepted">Accepted Application</option>
                            <option value="Rejected">Rejected Application</option>
                            <option value="Pending">Pending Application</option>
                            <option value="All">All Application</option>
                        </select>
                    
                        <script type="text/javascript">
                            function sort(answer){
                            if(answer.value == "All")
                                window.location="application_recurring.php";
                            else
                                window.location="application_recurring.php?request="+answer.value; 
                            }
                        </script>
                        <br/>
                        <!-- End Filter Application Status Option -->

                            
                    <?php
                        if(isset($_GET['request']))
                        { 
                            $value = $_GET['request'];
                            $query = "SELECT application.id,application.workid, voluntaryWork.id,application.status,voluntaryWork.workTitle, voluntaryWork.workRecur, voluntaryWork.workStartTime, voluntaryWork.workEndTime, voluntaryWork.workType,
                            voluntaryWork.workState, voluntaryWork.workCity, voluntaryWork.createdAt FROM (application INNER JOIN voluntaryWork ON application.workid = voluntaryWork.id)WHERE application.userid = $userid AND status ='$value' AND voluntaryWork.workType = 'Recurring' ORDER BY voluntaryWork.createdAt DESC;";
                        }
                        else
                            $query = "SELECT application.id,application.workid, voluntaryWork.id,application.status,voluntaryWork.workTitle, voluntaryWork.workRecur, voluntaryWork.workStartTime, voluntaryWork.workEndTime, voluntaryWork.workType,
                            voluntaryWork.workState, voluntaryWork.workCity,voluntaryWork.createdAt FROM (application INNER JOIN voluntaryWork ON application.workid = voluntaryWork.id)WHERE application.userid = $userid AND voluntaryWork.workType = 'Recurring' ORDER BY voluntaryWork.createdAt DESC;";
                            $result2 = mysqli_query($conn,$query);

                            if ($result2 === false) { 
                    ?>

                            <!-- If the user is not login, prompt user to login -->
                            <h2 style="margin-left:21%;"><center>Please login to view!</center></h2>
                        
                    <?php
                            } else 
                            if(mysqli_num_rows($result2)>0){
                    ?>

                    <!-- Application table -->
                    <!-- If the query is correct, show all data of each row -->
                    <table class= "application" style="width:100%">
                      
                        <!-- Title of the table -->
                        <thead>
                        <tr>
                            <th><h3><center>Voluntary Work Type</center></h3></th>
                            <th><h3><center>Weekly Recurrence</center></h3></th>
                            <th><h3><center>Time </center></h3></th>
                            <th><h3><center>Work Title</center></h3></th>
                            <th><h3><center>Location</center></h3></th>
                            <th><h3><center>Application Status</center></h3></th>
                            <th><h3><center></center></h3></th>
                        </tr>
                        </thead>
                        <!-- End Title of the table -->

                        <!-- Display data of each row  -->
                        <tbody>
                        <?php
                            while($row = mysqli_fetch_assoc($result2))
                            {
                        ?>
                        <tr>
                            <td><?php echo $row['workType']; ?></td>
                            <td><?php echo $row['workRecur']; ?></td>
                            <td><?php echo $row['workStartTime']. " - " .$row['workEndTime']; ?></td>
                            <td><?php echo $row['workTitle']; ?></td>
                            <td><?php echo $row["workCity"] . " , ".$row['workState'] ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <!-- Show the icon based on the application status -->
                                <?php include "connection.php"; 
                                    if($row['status']=="Accepted") 
                                        echo '<img id="buttons" src = "Pictures/tick-icon.png" style="width: 30px; height: auto;">';
                                    else if($row['status']=="Rejected")
                                        echo '<img id="buttons" src = "Pictures/cross-icon.png" style="width: 30px; height: auto;">';
                                    else
                                        echo '<img id="buttons" src = "Pictures/pending-icon.png" style="width: 30px; height: auto;">';
                                ?> 
                            </td>
                        </tr>
                        <!-- End Display data of each row -->
                        
                        <?php }
                            } else 
                            //if mysqli_num_rows($isFound) = 0
                            {
                                echo '<p class="no_trans">'."No Application Record Found!".'</p>';
                            }
                        ?>
                        </tbody>
                    </table>
                    <!-- End Application Table -->
                    </div>
                </div>
            </div>
        </div> 
        </main><br><br><br><br><br><br>

        <!-- Footer -->
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