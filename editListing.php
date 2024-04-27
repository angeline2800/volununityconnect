<?php

include "connection.php";

// Check if 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Sanitize the 'id' parameter to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Construct the SQL query
    $sql = "SELECT * FROM voluntaryWork WHERE id='$id'";

    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if (!$result) {
        // Print error message and exit if query fails
        die("Error: " . mysqli_error($conn));
    }

    // Fetch the data from the result set
    if ($row = mysqli_fetch_assoc($result)) {
        // Assign retrieved data to variables
        $workTitle = $row["workTitle"];
        $workDes = $row["workDes"];
        $workRecur = $row["workRecur"];
        $workDate = $row["workDate"];
        $workStartTime = $row["workStartTime"];
        $workEndTime = $row["workEndTime"];
        $workCity = $row["workCity"];
        $workState = $row["workState"];
        $workType = $row["workType"];
        $workPic = $row["workPic"];
    } else {
        // No data found for the given ID
        echo "No record found for ID";
        }
    }

  // Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $workTitle = mysqli_real_escape_string($conn, $_POST['workTitle']);
    $workDes = mysqli_real_escape_string($conn, $_POST['workDes']);
    $workDate = mysqli_real_escape_string($conn, $_POST['workDate']);
    $workRecur = mysqli_real_escape_string($conn, $_POST['workRecur']);
    $workStartTime = mysqli_real_escape_string($conn, $_POST['workStartTime']);
    $workEndTime = mysqli_real_escape_string($conn, $_POST['workEndTime']);
    $workCity = mysqli_real_escape_string($conn, $_POST['workCity']);
    $workState = mysqli_real_escape_string($conn, $_POST['workState']);
    $workType = mysqli_real_escape_string($conn, $_POST['type']);
    
    // Check if a new picture file has been uploaded
    if ($_FILES['workPic']['error'] == UPLOAD_ERR_OK) {
        // Get the file name and sanitize it
        $filename = basename($_FILES['workPic']['name']);
        // Move the uploaded picture to the "Photos" folder
        $uploadPath = "Photos/" . $filename;
        if (move_uploaded_file($_FILES['workPic']['tmp_name'], $uploadPath)) {

            // Check if workType is being changed to "Recurring" or from "Recurring" to "One Time"
            if ($workType == "Recurring") {
                $workDate = NULL; // Set workDate to NULL if workType is "Recurring"
            } elseif ($workType == "One Time") {
                $workRecur = NULL; // Set workRecur to NULL if workType is "One Time"
            }

            // Update the record in the database with the new picture filename
            $updateSql = "UPDATE voluntaryWork SET workTitle='$workTitle', workDes='$workDes', 
            workDate='$workDate', workRecur = '$workRecur', workStartTime='$workStartTime', workEndTime='$workEndTime', 
            workCity='$workCity', workState='$workState', workType='$workType', workPic='$filename' , workStatus = '1' WHERE id='$id'";

            if (mysqli_query($conn, $updateSql)) {
                //echo "Record updated successfully";
                header("Location: listings.php");
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        } else {
            echo "Error moving uploaded picture";
        }
    } else {
        // No new picture uploaded, update the record without changing the picture

        // Check if workType is being changed to "Recurring" or from "Recurring" to "One Time"
        if ($workType == "Recurring") {
            $workDate = NULL; // Set workDate to NULL if workType is "Recurring"
        } elseif ($workType == "One Time") {
            $workRecur = NULL; // Set workRecur to NULL if workType is "One Time"
        }

        $updateSql = "UPDATE voluntaryWork SET workTitle='$workTitle', workDes='$workDes', 
        workDate='$workDate', workRecur = '$workRecur', workStartTime='$workStartTime', workEndTime='$workEndTime', 
        workCity='$workCity', workState='$workState', workType='$workType' ,  workStatus = '1' WHERE id='$id'";

        if (mysqli_query($conn, $updateSql)) {
            //echo "Record updated successfully";
             header("Location: listings.php");
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}

?>


<?php session_start();  ob_start();?> 

<!DOCTYPE html>

<html lang="en">

    <head>
        <title>VolunUnity Connect</title>
        <link rel="icon" href="Pictures/iconsmall.png">
        <link rel="shortcut icon" href="Pictures/iconsmall.png">
        <link rel="stylesheet" href="CSS/create_listing.css">
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
        <div class = "user_info">
            <center><h2> Listing Information</h2></center>

            <form name="edit" enctype="multipart/form-data" method="post" action="">
            <div class="row">
                <div class="col1">
                    <label for="title">Voluntary Work Title</label>
                </div>
                <div class="col2" style="margin-top:-2%;">
                    <p><input type = "text" name="workTitle" id="workTitle" value="<?php echo $workTitle; ?>"></p>
                    <span class="error"> <br> <?php echo $titleE; ?> </span>
                </div>
            </div>

            <div class="row">
                <div class="col1">
                    <label for="workDes">Description</label>
                </div>
                <div class="col3">
                    <textarea id="workDes" name="workDes" style="width: 350px; height:150px; font-family: Arial;"><?php echo $workDes; ?></textarea>
                    <span class="error"> <br> <?php echo $descriptionE; ?> </span>
                </div>
            </div>
            <br>

                    
            <div class="row">
                <div class="col1">
                    <label for="workType">Work Type</label>
                </div>
                <div class="col2">
                    <div class="type">
                        <input type="radio" id="onetime" name="type" value="One Time" <?php if ($workType == "One Time") echo "checked"; ?>>
                        <label for="onetime">One Time</label>
                        <input type="radio" id="recurring" name="type" value="Recurring" <?php if ($workType == "Recurring") echo "checked"; ?>>
                        <label for="recurring">Recurring</label>
                    </div>
                    <span class="error"> <br> <?php echo $workTypeE; ?> </span>
                </div>
            </div>
            <br>

            <div class="row" id ="dateRow" <?php if ($workRecur != "One Time") echo 'style="display: none;"'; ?>>
                <div class="col1">
                    <label for="workDate">Date</label>
                </div>
                <div class="col2" style="margin-left:40%;margin-top:-3%;">
                    <input type="date" id="workDate" name="workDate" value="<?php echo $workDate;?>" min="<?php echo date('Y-m-d'); ?>" >
                    <span class="error"> <br> <?php echo $workDateE; ?> </span>
                </div>
            </div>


            <div class="row" id="weeklyRow" <?php if ($workRecur != "Recurring") echo 'style="display: none;"'; ?>>
                <div class="col1">
                    <label for="workRecur">Weekly Recurrence</label>
                </div>
                <div class="col2" style="margin-left:40%;margin-top:-3%;">
                    <select id="workRecur" name="workRecur">
                        <option value="" disabled selected>Select Day:</option>
                        <option value="Sunday" <?php if ($workRecur == "Sunday") echo "selected"; ?>>Sunday</option>
                        <option value="Monday" <?php if ($workRecur == "Monday") echo "selected"; ?>>Monday</option>
                        <option value="Tuesday"<?php if ($workRecur == "Tuesday") echo "selected"; ?>>Tuesday</option>
                        <option value="Wednesday"<?php if ($workRecur == "Wednesday") echo "selected"; ?>> Wednesday</option>
                        <option value="Thursday"<?php if ($workRecur == "Thursday") echo "selected"; ?>>Thursday</option>
                        <option value="Friday"<?php if ($workRecur == "Friday") echo "selected"; ?>>Friday</option>
                        <option value="Saturday"<?php if ($workRecur == "Saturday") echo "selected"; ?>> Saturday</option>
                    </select>
                    <span class="error"> <br> <?php echo $weeklyE; ?> </span>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col1">
                    <label for="workTime">Time</label>
                </div>
                <div class="col4">
                    <input type="time" id="workStartTime" name="workStartTime" value="<?php echo $workStartTime; ?>">
                    <span class="error"> <br> <?php echo $starttimeE; ?> </span>
                </div>

                <div class="text-between">
                    <p>to  </p>
                </div>

                <div class="col4">
                    <input type="time" id="workEndTime" name="workEndTime" value="<?php echo $workEndTime; ?>" >
                    <span class="error"> <br> <?php echo $endtimeE; ?> </span>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col1">
                    <label for="workCity">City</label>
                </div>
                <div class="col2">
                    <input type="text" id="workCity" name="workCity" value="<?php echo $workCity; ?>" >
                    <span class="error"> <br> <?php echo $cityE; ?> </span>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col1">
                    <label for="workState">State</label>
                </div>
                <div class="col2">
                    <select id="workState" name="workState">
                        <option value="" disabled selected>Select State</option>
                        <option value="Johor" <?php if ($workState == "Johor") echo "selected"; ?>>Johor</option>
                        <option value="Kedah" <?php if ($workState == "Kedah") echo "selected"; ?>>Kedah</option>
                        <option value="Kelantan" <?php if ($workState == "Kelantan") echo "selected"; ?>>Kelantan</option>
                        <option value="Melaka" <?php if ($workState == "Melaka") echo "selected"; ?>>Melaka</option>
                        <option value="Negeri Sembilan" <?php if ($workState == "Negeri Sembilan") echo "selected"; ?>>Negeri Sembilan</option>
                        <option value="Pahang" <?php if ($workState == "Pahang") echo "selected"; ?>>Pahang</option>
                        <option value="Penang" <?php if ($workState == "Penang") echo "selected"; ?>>Penang</option>
                        <option value="Perak" <?php if ($workState == "Perak") echo "selected"; ?>>Perak</option>
                        <option value="Perlis" <?php if ($workState == "Perlis") echo "selected"; ?>>Perlis</option>
                        <option value="Sabah" <?php if ($workState == "Sabah") echo "selected"; ?>>Sabah</option>
                        <option value="Sarawak" <?php if ($workState == "Sarawak") echo "selected"; ?>>Sarawak</option>
                        <option value="Selangor" <?php if ($workState == "Selangor") echo "selected"; ?>>Selangor</option>
                        <option value="Terengganu" <?php if ($workState == "Terengganu") echo "selected"; ?>>Terengganu</option>
                    </select>
                    <span class="error"> <br> <?php echo $stateE; ?> </span>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col1">
                    <label for="workPic">Picture</label>
                </div>
                <div class="col2">
                    <?php if (!empty($workPic)) : ?>
                        <img src="Photos/<?php echo $workPic; ?>" alt="Current Picture" style="width:300px; height:260px;">
                    <?php endif; ?>
                
                    <input type="file" id="workPic" name="workPic" accept="image/*">
                    <span class="error"> <br> <?php echo $imageE; ?> </span>
                </div>
            </div>


            <input type="submit" class="update" name="edit" 
                style="background:#3EFF3E;
                    color: white;  width: 20%;
                    padding: 15px 30px;
                    margin-top:-10%;
                    margin-bottom:2%;
                    margin-left:25%;
                    margin-right:-30%;
                    border: none;
                    text-align: center;
                    border-radius: 8px;
                    font: 17px 'Montserrat', san-serif;"
                value="Update" />
            
            <a class = "back" href='listings.php'><button>Back to Listings Page</button></a>
		    </form>
        </div> 
        <!-- End user info -->
    </div>
    <!-- End container -->


    <script>
        document.addEventListener('DOMContentLoaded', function()
        {
            var oneTimeRadio = document.getElementById('onetime');
            var recurringRadio = document.getElementById('recurring');
            var dateRow = document.getElementById('dateRow');
            var weeklyRow = document.getElementById('weeklyRow');
    
            // Initially hide/show rows based on the selected radio button
            if (oneTimeRadio.checked) 
            {
                dateRow.style.display = 'block';
                weeklyRow.style.display = 'none';
            } 
            else if (recurringRadio.checked) 
            {
                dateRow.style.display = 'none';
                weeklyRow.style.display = 'block';
            }

            // Add event listeners to the radio buttons to toggle rows
            oneTimeRadio.addEventListener('change', function()
            {
                if (this.checked) 
                {
                    dateRow.style.display = 'block';
                    weeklyRow.style.display = 'none';
                }
            });

            recurringRadio.addEventListener('change', function() 
            {
                if (this.checked) 
                {
                    dateRow.style.display = 'none';
                    weeklyRow.style.display = 'block';
                }
            });
        });
    </script>
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

