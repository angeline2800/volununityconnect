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
    <!---END APPOINTMENT Details-->
    
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
              <div class="col-div-10">
                <div class="box-10">
                        <div class="content-box">
                        <center><h2 id = "voluntaryWork"> All Application Details </h2></center>
                        <select style="padding:5px;margin-bottom: 25px;border: 2px solid #ff531a;float:right;" name="sortstatus" id="sortstatus" onchange="sort(this)";>
                            <option value="" disabled="" selected="">Select Filter</option>
                            <option value="Accepted">Accepted Application</option>
                            <option value="Rejected">Rejected Application</option>
                            <option value="Pending">Pending Application</option>
                            <option value="All">All Application</option>
                        </select>
                    
                    <script type="text/javascript">
                    function sort(answer)
                    {
                        if(answer.value == "All")
                            window.location="review_application.php";
                        else
                            window.location="review_application.php?request="+answer.value; 
                    }

                    </script>
                    
                    <br/>

                    <?php
                    if(isset($_GET['request']))
                    { 
                        $value = $_GET['request'];
                        $query = "SELECT application.id, application.userid, user.firstname AS applicant_firstname, user.lastname AS applicant_lastname,voluntaryWork.workTitle, 
                        voluntaryWork.workType, application.status, voluntaryWork.workDate, voluntaryWork.workStartTime, voluntaryWork.workEndTime
                        FROM (application
                        INNER JOIN voluntaryWork ON application.workid = voluntaryWork.id
                        INNER JOIN user ON application.userid = user.id)
                        WHERE voluntaryWork.userid = $userid AND status ='$value'
                        ORDER BY application.id DESC;";

                    }
                    else

                        $query = "SELECT application.id, application.userid, user.firstname AS applicant_firstname, user.lastname AS applicant_lastname,voluntaryWork.workTitle, 
                        voluntaryWork.workType, application.status, voluntaryWork.workDate, voluntaryWork.workStartTime, voluntaryWork.workEndTime
                        FROM (application
                        INNER JOIN voluntaryWork ON application.workid = voluntaryWork.id
                        INNER JOIN user ON application.userid = user.id)
                        WHERE voluntaryWork.userid = $userid
                        ORDER BY application.id DESC;";

                        $result2 = mysqli_query($conn,$query);
                        if ($result2 === false) 
                        { ?>
                            <h2 style="margin-left:21%;"><center>Please login to view!</center></h2>

                    <?php
                      } 
                      else 
                        if(mysqli_num_rows($result2)>0)
                        {
                    ?>

                    <table class= "application" style="width:100%">
                        <thead>
                        <tr>
                        <th><h3><center>Work Title</center></h3></th>
                        <th><h3><center>Date</center></h3></th>
                        <th><h3><center>Time</center></h3></th>
                        <th><h3><center>Name of Applied Volunteers </center></h3></th>
                        <th><h3><center>Action </center></h3></th>
                        <th><h3><center>Application Status</center></h3></th>
                        <th><h3><center></center></h3></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            while($row = mysqli_fetch_assoc($result2))
                            {
                        ?>
                        <tr>
                            <td><?php echo $row['workTitle']; ?></td>
                            <td><?php echo $row['workDate']; ?></td>
                            <td><?php echo "".$row['workStartTime']." - " .$row['workEndTime'];?></a></td>
                          <!-- Make the applicant name clickable and redirect to user_info.php with user's ID as parameter -->
                          <td><?php echo "".$row['applicant_firstname']." " .$row['applicant_lastname'];?></a></td>

                          <td><a href='user_info.php?user_id=<?php echo $row['userid']; ?>&application_id=<?php echo $row['id']; ?>'><button>Review Application</button></a></td>

                            <td><?php echo $row['status']; ?></td>

                            <td>
                             
                                <?php include "connection.php"; if($row['status']=="Accepted") 
                                        echo '<img id="buttons" src = "Pictures/tick-icon.png" style="width: 30px; height: auto;">';
                                    else if($row['status']=="Rejected")
                                        echo '<img id="buttons" src = "Pictures/cross-icon.png" style="width: 30px; height: auto;">';
                                    else
                                        echo '<img id="buttons" src = "Pictures/pending-icon.png" style="width: 30px; height: auto;">';
                                ?> 
                            </td>
                        </tr>
                        
                        <?php }
                        }else //mysqli_num_rows($isFound) = 0
                        {
                            echo '<p class="no_trans">'."No Application Record Found!".'</p>';
                        }?>
                        </tbody>
                    </table>
                    </div>
                </div>
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