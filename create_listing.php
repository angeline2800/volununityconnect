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

        // Declarations
        $signup = $login = $logout = $myprofile = "";
        $email = ""; // Initialize email variable

        // Check if session login and email are defined
        if (isset($_SESSION['login']) && isset($_SESSION['email'])) 
        {
            // If it is defined, then we check if the user is logged in
            if($_SESSION['login'] === "Logged In")
            {
                // Show logout and profile button  
                $logout = "Logout"; 
                $myprofile = "My Profile";

                // Assign email variable
                $email = $_SESSION['email'];
            }
        }
        else // session login or email not set yet
        {
            // Show sign up and login button  
            $signup = "Sign Up"; 
            $login = "Login";
        } 
        // END SESSION DECLARATION 

        //Validation
        $welcome = "";
        $title = $description = ""; 
        $titleE = $descriptionE = "";
        
        //Other declaration
        $date = $starttime = $endtime = $type = $terms = "";
        $dateE = $starttimeE = $endtimeE = $typeE = $termsE ="";
        $city = $state = $image = $weekly =  "";
        $cityE =$stateE = $imageE = $weeklyE = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            //Validate title
            if(empty($_POST["title"]))
            {
                $titleE = "*Title is required!";
            }
            else
            {
                $title = test($_POST["title"]);
            }
        
            //Validate description
            if(empty($_POST["description"]))
            {
                $descriptionE = "*Description is required!";
            }
            else
            {
                $description = test($_POST["description"]);
            }
            
            //Validate date
            if(empty($_POST["date"]))
            {
                $dateE = "*Date is required!";
            }
            else 
            {
                $date = test($_POST["date"]);
            }
        
            //Validate start time
            if(empty($_POST["starttime"]))
            {
                $starttimeE = "*Starting Time is required!";
            }
            else
            {
                $starttime = test($_POST["starttime"]);
            }

            //Validate end time
            if(empty($_POST["endtime"]))
            {
                $endtimeE = "*Ending Time is required!";
            }
            else
            {
                $endtime = test($_POST["endtime"]);
            }

            //Validate type
            if(empty($_POST["type"]))
            {
                $typeE = "*Event Type is required!";
            }
            else
            {
                $type = test($_POST["type"]);
            }
        
            //Validate terms
            if(empty($_POST["terms"]))
            {
                $termsE = "*Please accept the terms and conditions!";
            }
            else
            {
                $terms = test($_POST["terms"]);
            }
        
            //Validate city
            if(empty($_POST["city"]))
            {
                $cityE = "*City is required!";
            }
            else
            {
                $city = test($_POST["city"]);
            }
        
            //Validate state
            if(empty($_POST["state"]))
            {
                $stateE = "*State is required!";
            }
            else
            {
                $state = test($_POST["state"]);
            }

            //Validate weekly recurrence
            if(empty($_POST["weekly"]))
            {
                $weeklyE = "*Recurring Day is required!";
            }
            else
            {
                $weekly = test($_POST["weekly"]);
            }

            //Validate image
            if(empty($_FILES["image"]["name"])) 
            {
                $imageE = "*Picture is required!";
            }
            else
            {
                $image_name = $_FILES["image"]["name"];
                $image_tmp_name = $_FILES["image"]["tmp_name"];
                $image_destination = "Photos/" . $image_name;

                // Move the uploaded image to the destination directory
                if(move_uploaded_file($image_tmp_name, $image_destination))
                {
                    // File moved successfully
                    $image = $image_name; // Update the $image variable with the filename
                } 
                else 
                {
                    // Failed to move the file
                    echo "Sorry, there was an error uploading your photo.";
                }
            }

        } //End Validation
        
        function test($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        //Actual Registration Logic
        if( $starttimeE == "" && $endtimeE == "" && $typeE == "" && $termsE =="" && $titleE == "" && $descriptionE == "" && $cityE == "" && $stateE == ""  && $imageE == ""
            &&  $title != "" && $description != ""  && $starttime != "" && $endtime != "" && $type != "" && $terms != "" && $city != "" && $state != ""  && $image != "")
        {
            // Retrieve user ID from user table based on email
            $usersql = "SELECT id FROM user WHERE email='$email'";
            $usersql_result = mysqli_query($conn, $usersql);

            if ($usersql_result && mysqli_num_rows($usersql_result) > 0)
            {
                $row = mysqli_fetch_assoc($usersql_result);
                $userid = $row['id'];

                // Insert listing details along with user ID into voluntaryWork table
                $sql = "INSERT INTO voluntarywork (workTitle, workDes, workDate, workRecur, workStartTime, workEndTime, workType, workCity, workState, workPic, createdAt, userid, workStatus)
                        VALUES ('$title', '$description', '$date', '$weekly', '$starttime', '$endtime' , '$type', '$city', '$state', '$image', NOW(), '$userid', '1')";
                        
                if ($conn->query($sql) === TRUE)
                {

                    // If the listing is One Time, redirect to one time work listing.
                    // If the listing is Recurring, redirect to recurring work listing.
                    if ($type == "One Time")
                    {
                        echo '<script type="text/javascript">
                            alert("Listing created successfully! Looking for volunteers!");
                            window.location = \'listings.php\';
                            </script>';

                    } else if ($type == "Recurring")
                    {
                        echo '<script type="text/javascript">
                            alert("Listing created successfully! Looking for volunteers!");
                            window.location = \'listings_recurring.php\';
                            </script>';
                    }

                } 
                else 
                {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                        
            } 
            else 
            {
                echo "Error: User not found";
            }
        }
    ?>
    
        <header class="HeaderHeader" id="Push_header">
            <div class="login_register">
                <ul id = abc>
                  <li id= "topnav"><a href="review_application.php">Received Application</a></li>
                  <li id= "topnav"><a href="">|</li>
                  <li id= "topnav"><a href="listings.php">My Listing</a></li> 
                  <li id= "topnav"><a href="">|</li>
                  <li id= "active"><a href="create_listing.php">Create Listing</a></li>
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
                <div class="row">
                    <h3 id = "voluntaryWork"><center> Create A Listing</center> </h3>
                </div>

                <!-- Listing creation form -->
                <form name="reg" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col1">
                            <label for="title">Voluntary Work Title</label>
                        </div>
                        <div class="col2">
                            <input type="text" id="title" name="title" placeholder="Title of Voluntary Work..." value="<?php echo $title;?>">
                            <span class="error"> <br> <?php echo $titleE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <label for="description">Description</label>
                        </div>
                        <div class="col3">
                            <textarea id="description" name="description" placeholder="Description of the Voluntary Work..." style="width: 350px; height:150px; font-family: Arial;"><?php echo $description;?></textarea>
                            <span class="error"> <br> <?php echo $descriptionE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <label for="type">Work Type</label>
                        </div>
                        <div class="col2">
                            <div class="type">
                                <input type="radio" id="onetime" name="type" value="One Time"
                                <?php if (isset($type) && $type=="One Time") echo "checked";?> >
                                <label for="onetime">One Time</label>
                                <input type="radio" id="recurring" name="type" value="Recurring"
                                <?php if (isset($type) && $type=="Recurring") echo "checked";?> >
                                <label for="recurring">Recurring</label>
                                <span class="errorType"><?php echo $typeE; ?> </span>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row" id ="dateRow" style="display: none;">
                        <div class="col1">
                            <label for="date">Date</label>
                        </div>
                        <div class="col2"style="margin-left:40%;margin-top:-3%;">
                            <input type="date" id="date" name="date" value="<?php echo $date;?>" min="<?php echo date('Y-m-d'); ?>">
                            <span class="error"> <br> <?php echo $dateE; ?> </span>
                        </div>
                    </div>

                    <div class="row" id ="weeklyRow" style="display: none;">
                        <div class="col1">
                            <label for="weekly">Weekly Recurrence</label>
                        </div>
                        <div class="col2"style="margin-left:40%;margin-top:-3%;">
                            <select id="weekly" name="weekly">
                                <option value="" disabled selected>Select Day:</option>
                                <option value="Sunday">Sunday</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                            </select>
                            <span class="error"> <br> <?php echo $weeklyE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <label for="time">Time</label>
                        </div>
                        <div class="col4">
                            <input type="time" id="starttime" name="starttime" value="<?php echo $starttime;?>">
                            <span class="error"> <br> <?php echo $starttimeE; ?> </span>
                        </div>

                        <div class="text-between">
                        <p>to  </p>
                        </div>

                        <div class="col4">
                            <input type="time" id="endtime" name="endtime" value="<?php echo $endtime;?>" >
                            <span class="error"> <br> <?php echo $endtimeE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <label for="city">City</label>
                        </div>
                        <div class="col2">
                            <input type="text" id="city" name="city" placeholder="City.." value="<?php echo $city;?>" >
                            <span class="error"> <br> <?php echo $cityE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <label for="state">State</label>
                        </div>
                        <div class="col2">
                            <select id="state" name="state">
                                <option value="" disabled selected>Select State</option>
                                <option value="Johor">Johor</option>
                                <option value="Kedah">Kedah</option>
                                <option value="Kelantan">Kelantan</option>
                                <option value="Melaka">Melaka</option>
                                <option value="Negeri Sembilan">Negeri Sembilan</option>
                                <option value="Pahang">Pahang</option>
                                <option value="Penang">Penang</option>
                                <option value="Perak">Perak</option>
                                <option value="Perlis">Perlis</option>
                                <option value="Sabah">Sabah</option>
                                <option value="Sarawak">Sarawak</option>
                                <option value="Selangor">Selangor</option>
                                <option value="Terengganu">Terengganu</option>
                            </select>
                            <span class="error"> <br> <?php echo $stateE; ?> </span>
                        </div>
                    </div>
                    <br>
                    
                    <div class="row">
                        <div class="col1">
                            <label for="image">Picture</label>
                        </div>
                        <div class="col2">
                            <input type="file" id="image" name="image"  accept="image/*" value="<?php echo $image;?>" >
                            <span class="error"> <br> <?php echo $imageE; ?> </span>
                        </div>
                    </div>
                    <br><br><br>

                    <div class="Terms_Con">
                        <input type="checkbox" id="terms" name="terms" value="Accepted"
                        <?php if (isset($terms) && $terms == "Accepted") echo "checked";?> >
                        <label for="terms"><b>I accept the above Terms and Conditions</b></label>
                        <div class="errorTerms"> <br> <?php echo $termsE; ?> </div>
                    </div> 

                    <div class="input-group">
                         <input type="submit" class="btn" name="submit" value="Create">
                    </div>

                </form>
              </div>
            </section>
        </main><br><br><br><br><br><br>

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


    <script>
        document.getElementById('onetime').addEventListener('change', function(){
            var type = this.value;
            var dateRow = document.getElementById('dateRow');
            var weeklyRow = document.getElementById('weeklyRow');
    
            if (type === 'One Time') {
                dateRow.style.display = 'block';
                weeklyRow.style.display = 'none';
            } else {
                dateRow.style.display = 'none';
                weeklyRow.style.display = 'none';
            }
        });

        document.getElementById('recurring').addEventListener('change', function() {
            var type = this.value;
            var dateRow = document.getElementById('dateRow');
            var weeklyRow = document.getElementById('weeklyRow');
    
            if (type === 'Recurring') {
                dateRow.style.display = 'none';
                weeklyRow.style.display = 'block';
            } else {
                dateRow.style.display = 'none';
                weeklyRow.style.display = 'none';
            }
        });
    </script>
</body>
</html>

<?php ob_end_flush();?>