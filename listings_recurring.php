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
                  <li id= "active"><a href="listings.php">My Listing</a></li> 
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
                        <center><h2 id = "voluntaryWork"> All Listings </h2></center>

                        <div class="viewOpt">
                            <a href="listings.php"><button>One Time Voluntary Work</button></a>
                            <button style="border: 3px solid #011A3D;"><a href="listings_recurring.php">Recurring Voluntary Work</button></a>
                        </div>
                        
                        <br><br>

                        <select style="padding:5px;margin-bottom: 25px;border: 2px solid #ff531a;float:right;" name="sortstatus" id="sortstatus" onchange="sort(this)";>
                            <option value="" disabled="" selected="">Select Filter</option>
                            <option value="Active">Active Listings</option>
                            <option value="Inactive">Inactive Listings</option>
                            <option value="All">All Listings</option>
                        </select>
                   
                    <script type="text/javascript">
                    function sort(answer)
                    {
                        if(answer.value == "All")
                            window.location="listings_recurring.php";
                        else
                            window.location="listings_recurring.php?request="+answer.value; 
                    }
                    </script>
                    
                    <br>
                        
                    <?php
                        if (isset($_GET['request'])) 
                            $statusFilter = $_GET['request'];
                            
                            if ($statusFilter == 'Active') 
                            {
                                $query = "SELECT * FROM voluntaryWork WHERE userid = $userid AND workStatus = 1 AND workType = 'Recurring' ORDER BY workDate DESC";
                            } 
                            else if ($statusFilter == 'Inactive') 
                            {
                                $query = "SELECT * FROM voluntaryWork WHERE userid = $userid AND workStatus = 0 AND workType = 'Recurring' ORDER BY workDate DESC";
                            } 
                            else 
                            {
                                $query = "SELECT * FROM voluntaryWork WHERE userid = $userid AND workType = 'Recurring' ORDER BY workDate DESC";
                            }

                            $result2 = mysqli_query($conn,$query);

                            if ($result2 === false) 
                            { 
                    ?>
                                <h2 style="margin-left:21%;"><center>Please login to view!</center></h2>
    
                    <?php
                            } 
                            else if(mysqli_num_rows($result2)>0)
                            {
                    ?>

                        <table class= "application" style="width:100%">
                        <thead>
                        <tr>
                        <th><h3><center>Voluntary Work Type</center></h3></th>
                        <th><h3><center>Weekly Recurrence</center></h3></th>
                        <th><h3><center>Time </center></h3></th>
                        <th><h3><center>Work Title</center></h3></th>
                        <th><h3><center>Location</center></h3></th>
                        <th><h3><center>Availability</center></h3></th>
                        <th><h3><center>Action</center></h3></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                            while($row = mysqli_fetch_assoc($result2))
                            {
                        ?>
                            <tr>
                            <td><?php echo $row['workType']; ?></td>
                            <td><?php echo $row['workRecur']; ?></td>
                            <td><?php echo $row['workStartTime']. " - " .$row['workEndTime']; ?></td>
                            <td><a href="listing_info.php?work_id=<?php echo $row['id']; ?>"><?php echo $row['workTitle']; ?></a></td>
                            <td><?php echo $row["workCity"] . " , ".$row['workState'] ?></td>
                            <td>
                                <label class="switch">
                                <input type="checkbox" <?php echo $row['workStatus'] == 1 ? 'checked' : ''; ?> onchange="toggleStatus(<?php echo $row['id']; ?>, this.checked ? 1 : 0)">
                                <span class="slider"></span>
                                </label>
                            </td>
                            <td><a class = "update" href='editListing.php?id=<?php echo $row['id']; ?>'><button>Update</button></a>
								<a class = "delete "href='deleteListing.php?id=<?php echo $row['id']; ?>'onclick="return confirm('Are you sure you want to delete this listing?')"><button>Delete</button></a>
                            </td>
                            </tr>
                        
                        <?php 
                            }
                        }
                        else //mysqli_num_rows($isFound) = 0
                        {
                            echo '<p class="no_trans">'."No Application Record Found!".'</p>';
                        }
                        ?>
                        </tbody>
                        </table>

                    <script>
                    function toggleStatus(workId, newStatus) 
                    {
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "update_status.php", true);
                        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() 
                        {
                            if (xhr.readyState == 4 && xhr.status == 200) 
                            {
                                if (xhr.responseText === 'success') 
                                {
                                // Update UI if the status is updated successfully
                                // alert('Status updated successfully!');
                                } 
                                else 
                                {
                                //alert('Failed to update status');
                                }
                            }
                        };

                        xhr.send("work_id=" + workId + "&new_status=" + newStatus);
                    }
                    </script>
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