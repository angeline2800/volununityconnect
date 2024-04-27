<?php session_start(); ob_start();?>


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

<!DOCTYPE html>
<html>
    <head>
        <title>My Profile - VolunUnity Connect</title>
        <meta charset="UTF-8">
        <link rel="icon" href="Pictures/iconsmall.png">
        <link rel="shortcut icon" href="Pictures/iconsmall.png">
        <script type="text/javascript" src="editprofile.js"></script>
        <link rel="stylesheet" href="CSS/myProfile.css">
        <link rel="stylesheet" href="CSS/footer.css">
    </head>

    <body>

        <header class="HeaderHeader" id="Push_header">

            <div class="login_register">
                <ul id = abc>
                  <li id= "topnav"><a href="application.php">My Application</a></li>  
                  <li id= "topnav"><a href="#">|</li>
                  <li id= "topnav"><a href="index.html">Home</a></li>
                  <li><a href="index.html"><img class="logo" src="Pictures/icon.png" alt="VolunUnity Connect"></a></li>
                </ul>

                <ul>
                  <li><a href="logout.php"  >Logout</a></li>
                  <li>&nbsp|&nbsp</li>
                  <li><a href="myProfile.php"  >My Profile</a></li>
                  <li><img class="image_login_register" src="Pictures/login_register_icon.png" alt="Login and register icon"></a>
                </ul>
                
            </div>
              
        </header>

        <main>
            <?php 
                include 'connection.php';
                $id = $_SESSION['user_id'];
                //Select everything where id of people who logged in now
                $sql = "SELECT * FROM user WHERE id = '$id'"; 
                $isFound = mysqli_query($conn,$sql); //Check is it exists
                $row = mysqli_fetch_assoc($isFound); //fetch the result row

                //Show the pw in * form
                $password = str_repeat("•", strlen($row["pwd"])); 

                //Validate Edit_prodile
                $fname = $lname = ""; 
                $email = $mobile = $pw = $cpw = "";
                $add = $city = $resume = "";

                $fnameE = $lnameE = "false"; 
                $emailE = $mobileE = $pwE = $cpwE = "false";
                $addE = $cityE = "false";

                if ($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    //Validate fname
                    if(empty($_POST["fname"]))
                    {
                        $fnameE = "true";
                    }
                    else
                    {
                        $fname = test($_POST["fname"]);
                    }

                    //Validate lname
                    if(empty($_POST["lname"]))
                    {
                        $lnameE = "true";
                    }
                    else
                    {
                        $lname = test($_POST["lname"]);
                    }

                    //Validate email
                    if(empty($_POST["email"]))
                    {
                        $emailE = "true";
                    }
                    else 
                    {
                        $email = test($_POST["email"]);
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
                        {
                            $emailE = "true";
                        }
                        
                    }

                    //Validate mobile
                    if(empty($_POST["mobile"]))
                    {
                        $mobileE = "true";
                    }
                    else
                    {
                        $mobile = test($_POST["mobile"]);
                        //Check is it number
                        if(!is_numeric($mobile) || strlen($mobile) > 11 || strlen($mobile) <10)
                        {
                            $mobileE = "true";
                        }
                    }

                    //Validate password
                    if(empty($_POST["pw"]))
                    {
                        $pwE = "true";
                    }
                    else
                    {
                        $pw = $_POST["pw"];
                        if(strlen($pw) <6 || !preg_match("#[0-9]+#",$pw) || !preg_match("#[A-Z]+#",$pw) || !preg_match("#[a-z]+#",$pw) || !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/',$pw) || preg_match('/\s/',$pw))
                        {
                            $pwE = "true";
                        }
                    }

                    //Validate confirm password
                    if(empty($_POST["cpw"]))
                    {
                        $cpwE = "true";
                    }
                    else 
                    {
                        $cpw = $_POST["cpw"];
                        if($cpw !== $_POST["pw"])
                        {
                            $cpwE = "true";
                        }
                    }

                    //Validate address
                    if(empty($_POST["Address"]))
                    {
                        $addE = "true";
                    }
                    else
                    {
                        $add = test($_POST["Address"]);
                    }

                    //Validate city
                    if(empty($_POST["city"]))
                    {
                        $cityE = "true";
                    }
                    else
                    {
                        $city = test($_POST["city"]);
                    }

                    $state = test($_POST["state"]);
                    $gender = test($_POST["gender"]);
                    $resume = test($_POST["resume"]);
                }

                function test($data)
                {
                    if ($data !== null) {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    } else {
                        return null;
                    }
                }
             
                //Update profile if Validation is successful
                if($fnameE === "false" && $lnameE === "false" && $emailE === "false" && $mobileE === "false" && $pwE === "false" && $cpwE === "false" && $addE === "false" && $cityE === "false" 
                &&  $fname != "" && $lname != "" && $email != "" && $mobile != "" && $pw != "" && $cpw != "" && $add != "" &&  $city != "")
                {

                    // Handle file upload
                    $resume_name = "";
                    if(isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) 
                    {
                        $resume_tmp_name = $_FILES['resume']['tmp_name'];
                        $resume_name = basename($_FILES['resume']['name']);
                        $resume_destination = "Resume/" . $resume_name;

                        if(move_uploaded_file($resume_tmp_name, $resume_destination)) 
                        {
                            // File moved successfully
                        } 
                        else 
                        {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    }

                    //Update the user info in the database table
                    $sql= "UPDATE user
                    SET firstname = '$fname', lastname= '$lname', email= '$email', phone= '$mobile', 
                    pwd= '$pw', gender= '$gender', _state= '$state', _address= '$add', city= '$city', 
                    resume_file = '$resume_name'
                    WHERE id = '$id'";

                    $result = mysqli_query($conn,$sql);
                    if ($result === TRUE) 
                    {
                        //echo "Profile updated!";
                    } 
                    else 
                    {
                        echo "Error: ". $conn->error;
                    }

                    //Refresh the page after profile is updated
                    header("Refresh:1");
                    ob_end_flush();
                }
            ?>

            <div class="display_title_editbutton"> 
                <span class= "title" >- My Profile -</span>
                <noscript>Please ENABLE JavaScript to Edit Profile!</noscript>
                <span class="editbutton">
                    <a onclick="display()" ><img src="Pictures/editprofile.png"></a>
                </span>
            </div>

            
            <div class="profilepic"> 
            <?php 
                $sql = "SELECT gender FROM user WHERE id = '$id'"; //Select the user id
                $isFound = mysqli_query($conn,$sql); //Check is it exists
                
                //Found the user
                if(mysqli_num_rows($isFound) == 1) 
                {
                    //fetch the id
                    $result = mysqli_fetch_assoc($isFound);
                    $gender = $result["gender"];

                    if( $gender === "Female")
                    {
                        echo '<img src="Pictures/default_pp_female.png">';
                        echo '<img id = "genderbg" src="Pictures/female_bg.png">';
                    }
                    else
                    {
                        echo '<img src="Pictures/default_pp_male.png">';
                        echo '<img id = "genderbg" src="Pictures/male_bg.png">';
                    }
                }
            ?>
            </div>
            
            <br><br>

            <hr id="designline">

            <br>

            <div class = "column">
                <div class="column1">
                    <ul>
                        <li>Email</li>
                        <li>Password</li>
                        <li id="edit_confirm_pw">Confirm Password</li>
                        <li>First Name</li>
                        <li>Last Name</li>
                        <li>Phone</li>
                        <li>Gender</li>
                        <li>Address</li>
                        <li>City</li>
                        <li>State</li>
                        <li>Resume</li>
                    </ul>
                </div> <!-- End Column1-->

                <div class="column2">
                    <form name="edit" method="post" enctype="multipart/form-data" onsubmit="return validateEditForm()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <ul>
                        <!--Display the li before editting-->
                        <li id="display0"><?php echo  ": " .$row["email"].""; ?></li>
                        <!--Display the input when users try to edit-->
                        <li><input type="email" id="email" name="email"   value="<?php echo $row["email"]; ?>"></li>

                        <li id="display1"><?php    echo ": " .$password.""; ?></li>
                        <li><input type="password" id="pw" name="pw"   value="<?php echo $row["pwd"]; ?>"></li>

                        <li id="display2_cpw"><?php    echo ": " .$password.""; ?></li>
                        <li><input type="password" id="cpw" name="cpw"  value="<?php echo $row["pwd"]; ?>" ></li>

                        <li id="display3"><?php    echo ": " .$row["firstname"].""; ?></li>
                        <li><input type="text" id="fname" name="fname"  value="<?php echo $row["firstname"];?>"></li>

                        <li id="display4"><?php    echo ": " .$row["lastname"].""; ?></li>
                        <li><input type="text" id="lname" name="lname"   value="<?php echo $row["lastname"]; ?>"></li>

                        <li id="display5"><?php    echo ": ".$row["phone"].""; ?></li>
                        <li>
                            <input type="phone" id="mobile" name="mobile"   value="<?php echo $row["phone"]; ?>">
                        </li>

                        <li id="display6"><?php    echo ": " .$row["gender"].""; ?></li>
                        <li>
                        <span id="GENDER">
                            <input type="radio" id="male" name="gender" value="Male"
                            <?php if ($row["gender"]=="Male") echo "checked";?> >
                            <label id="display_male" for="male">Male</label>

                            <input type="radio" id="female" name="gender" value="Female"
                            <?php if ($row["gender"]=="Female") echo "checked";?> >
                            <label id="display_female" for="female">Female</label>
                        </span>
                        </li>

                        <li id="display7"><?php    echo ": " .$row["_address"].""; ?></li>
                        <li><input type="text" id="address" name="Address" value="<?php echo $row["_address"];?>" ></li>
                    

                        <li id="display9"><?php    echo ": " .$row["city"].""; ?></li>
                        <li><input type="text" id="city" name="city"  value="<?php echo $row["city"];?>" ></li>

                        <li id="display10"><?php    echo ": " .$row["_state"].""; ?> </li>
                        <li>
                            <select id="state" name="state">
                                <option value="Kelantan" <?php if ($row["_state"] == 'Kelantan') echo ' selected="selected"'; ?>>Kelantan</option>
                                <option value="Melaka" <?php if ($row["_state"] == 'Melaka') echo ' selected="selected"'; ?>>Melaka</option>
                                <option value="Negeri Sembilan" <?php if ($row["_state"] == 'Sembilan') echo ' selected="selected"'; ?>>Negeri Sembilan</option>
                                <option value="Pahang" <?php if ($row["_state"] == 'Pahang') echo ' selected="selected"'; ?>>Pahang</option>
                                <option value="Penang" <?php if ($row["_state"] == 'Penang') echo ' selected="selected"'; ?>>Penang</option>
                                <option value="Perak" <?php if ($row["_state"] == 'Perak') echo ' selected="selected"'; ?>>Perak</option>
                                <option value="Perlis" <?php if ($row["_state"] == 'Perlis') echo ' selected="selected"'; ?>>Perlis</option>
                                <option value="Sabah" <?php if ($row["_state"] == 'Sabah') echo ' selected="selected"'; ?>>Sabah</option>
                                <option value="Sarawak" <?php if ($row["_state"] == 'Sarawak') echo ' selected="selected"'; ?>>Sarawak</option>
                                <option value="Selangor" <?php if ($row["_state"] == 'Selangor') echo ' selected="selected"'; ?>>Selangor</option>
                                <option value="Terengganu" <?php if ($row["_state"] == 'Terengganu') echo ' selected="selected"'; ?>>Terengganu</option>
                                <option value="Kedah" <?php if ($row["_state"] == 'Kedah') echo ' selected="selected"'; ?>>Kedah</option>
                                <option value="Johor" <?php if ($row["_state"] == 'Johor') echo ' selected="selected"'; ?>>Johor</option>
                            </select>
                        </li>

                        <!-- Display the current resume -->
                        <li id="display8"><?php echo ": <a href='Resume/" . $row["resume_file"] . "' target='_blank'>Resume of ".$row['firstname']." ".$row['lastname']."</a>"; ?></li>
                        <!-- Display file input to upload a new resume -->
                        <li><input type="file" id="resume" name="resume" accept=".pdf" style="display:none;"></li>

                        <div id="button">
                            <input type="submit" name = "submit" value="Update" >
                            <input class="cancel" onclick="cancel_edit()" name = "cancel" value="Cancel" >
                        </div>
                    </form>
                </div> <!-- End Column2-->

            </div> <!-- End Column-->
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
    </body>
</html>

<?php ob_end_flush();?>