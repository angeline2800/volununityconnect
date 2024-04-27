<!DOCTYPE html>
<html>
    <head>
        <title>Registration - VolunUnity Connect</title>
        <meta charset="UTF-8">
        <link rel="icon" href="Pictures/iconsmall.png">
        <link rel="shortcut icon" href="Pictures/iconsmall.png">
        <link rel="stylesheet" href="CSS/register.css">
        <link rel="stylesheet" href="CSS/footer.css">
    </head>

    <body>

    <?php 
            include 'connection.php';
            //Validation
            $fname = $lname = ""; 
            $fnameE = $lnameE = "";

            //Other declaration
            $email = $mobile = $pw = $cpw = $gender = $type = $terms = "";
            $emailE = $mobileE = $cpwE = $genderE = $typeE = $termsE ="";
            $add = $city = $resume = $oName = $oDes = "";
            $addE = $cityE = $oNameE = $oDesE ="";
            $cpw_match = $pw_strong = "";
            $pwE="";
            $pwHint= "*Password must be At least six digits, containing at least one number, one uppercase and one lowercase letter, one special character.";
           
            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                //Validate fname
                if(empty($_POST["fname"]))
                {
                    $fnameE = "*First Name is required!";
                }
                else
                {
                    $fname = test($_POST["fname"]);
                }

                //Validate lname
                if(empty($_POST["lname"]))
                {
                    $lnameE = "*Last Name is required!";
                }
                else
                {
                    $lname = test($_POST["lname"]);
                }
                
                //Validate email
                if(empty($_POST["email"]))
                {
                    $emailE = "*Email is required!";
                }
                else 
                {
                    $email = test($_POST["email"]);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
                    {
                        $emailE = "*Invalid email format!";
                    }
                    
                }

                //Validate mobile
                if(empty($_POST["mobile"]))
                {
                    $mobileE = "*Phone number is required!";
                }
                else
                {
                    $mobile = test($_POST["mobile"]);
                    //Check is it number
                    if(!is_numeric($mobile))
                    {
                        $mobileE = "*Invalid! Please use only numbers 0-9!";
                    }
                    else if(strlen($mobile) > 11 || strlen($mobile) <10) //Check length
                    {
                        $mobileE = "*Invalid phone number length!";
                    }
                }

                //Validate password
                if(empty($_POST["pw"]))
                {
                    $pwE = "*Password is required!";
                    $pwHint = "";
                }
                else
                {
                    $pw = test($_POST["pw"]);
                    $pwHint = "";
                    if(strlen($pw) <6 )
                    {
                        $pwE = "*Please use password with at least 6 digits!";
                    }
                    else if(!preg_match("#[0-9]+#",$pw))
                    {
                        $pwE = "*Must contain at least 1 number!";
                    }
                    else if (!preg_match("#[A-Z]+#",$pw))
                    {
                        $pwE = "*Must contain at least 1 uppercase letter!";
                    }
                    else if (!preg_match("#[a-z]+#",$pw))
                    {
                        $pwE = "*Must contain at least 1 lowercase letter!";
                    }
                    else if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/',$pw))
                    {
                        $pwE = "*Must contain at least 1 special character!";
                    }
                    else if (preg_match('/\s/',$pw)) //find whitespace
                    {
                        $pwE = "*Must not contain any whitespace!";
                    }
                    else
                    {
                        $pw_strong = "Strong Password!";
                    }
                }

                //Validate confirm password
                if(empty($_POST["cpw"]) && !empty($_POST["pw"]))
                {
                    $cpwE = "*Please confirm your password!";
                }
                else 
                {
                    $cpw = test($_POST["cpw"]);
                    if($cpw !== $_POST["pw"])
                    {
                        $cpwE = "*The password confirmation does not match!";
                    }
                    else if($cpw === $_POST["pw"] && !empty($_POST["pw"]))
                    {
                        $cpw_match = "Password Match!";
                    }
                }

                //Validate gender
                if(empty($_POST["gender"]))
                {
                    $genderE = "*Gender is required!";
                }
                else
                {
                    $gender = test($_POST["gender"]);
                }

                //Validate type
                if(empty($_POST["type"]))
                {
                    $typeE = "*Type is required!";
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

                //Validate address
                if(empty($_POST["Address"]))
                {
                    $addE = "*Address is required!";
                }
                else
                {
                    $add = test($_POST["Address"]);
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

                                //Validate city
                if(empty($_POST["oName"]))
                {
                    $oNameE = "*City is required!";
                }
                else
                {
                    $oName = test($_POST["oName"]);
                }

                                //Validate city
                if(empty($_POST["oDes"]))
                {
                    $oDesE = "*City is required!";
                }
                else
                {
                    $oDes = test($_POST["oDes"]);
                }

                $state = test($_POST["state"]);
                $resume = test($_POST["resume"]);

                
            } //End Validation
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

            //Actual Registration Logic
            if($emailE == "" && $mobileE == "" && $pwE == "" && $cpwE == "" && $genderE == "" && $termsE =="" && $typeE == "" && $fnameE == "" && $lnameE == "" && $addE == "" && $cityE == "" 
            &&  $fname != "" && $lname != "" && $email != "" && $mobile != "" && $pw != "" && $cpw != "" && $gender != "" && $terms != "" && $type != "" && $add != "" && $city != "" ) 
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

                //Insert registered user's data into the table
                $sql = "INSERT INTO user (firstname, lastname, email, phone, pwd, gender, userType, _state, _address, city, resume_file, oName, oDes, _login)
                VALUES ('$fname', '$lname', '$email','$mobile', '$pw','$gender', '$type', '$state', '$add', '$city', '$resume_name', '$oName', '$oDes', 0)";
                if ($conn->query($sql) === TRUE) 
                {
                    echo "<script>alert('Registration Successful');</script>";
                    echo "<script>window.location.href = 'login.php';</script>";
                } 
                else 
                {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            //Close Connection
            mysqli_close($conn);
        ?>

        
        <header>
            <a href="index.html"><img class="logo" src="Pictures/icon.png" alt="VolunUnity Connect" ></a>
            <div class="login_register">
                <ul>
                  <li><u><a href="login.php">Already registered? Login here!</a></u></li>
                </ul>
            </div>
        </header><br><br>
        
        <div class="column"> 
            <h3 class="signup">Connecting Hearts, Empowering Change</br></br>
                Welcome to <b>VolunUnity Connect</b> - Your Gateway to Purposeful Volunteering!</h3>
                <hr id="line"/><br> 

                <div class="headerRegister">
                     <h2>Register an account to start the journey!</h2>
                 </div>

                 <form name="reg" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="row">
                        <div class="col1">
                            <label for="fname">First Name</label>
                        </div>
                        <div class="col2">
                            <input type="text" id="fname" name="fname" placeholder="Your first name.." value="<?php echo $fname;?>">
                            <span class="error"> <br> <?php echo $fnameE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <label for="lname">Last Name</label>
                        </div>
                        <div class="col2">
                            <input type="text" id="lname" name="lname" placeholder="Your last name.." value="<?php echo $lname;?>">
                            <span class="error"> <br> <?php echo $lnameE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <label for="Email">Email</label>
                        </div>
                        <div class="col2">
                            <input type="email" id="email" name="email" placeholder="Email.." value="<?php echo $email;?>" >
                            <span class="error"> <br> <?php echo $emailE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <label for="mobile">Mobile</label>
                        </div>
                        <div class="col2">
                            <input type="text" id="mobile" name="mobile" placeholder="Phone number.." value="<?php echo $mobile;?>" >
                            <span class="error"> <br> <?php echo $mobileE; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <label for="pw">Password</label>
                        </div>
                        <div class="col2">
                            <input type="password" id="pw" name="pw" placeholder="Password.." value="<?php echo $pw;?>" >
                            <span class="error"> <br> <?php echo $pwE; ?> </span>
                            <span class="correct"> <?php echo $pw_strong; ?> </span>
                            <span class="hint"> <br> <?php echo $pwHint; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <label for="cpw">Confirm Password</label>
                        </div>
                        <div class="col2">
                            <input type="password" id="cpw" name="cpw" placeholder="Confirm password.." value="<?php echo $cpw;?>" >
                            <span class="error"> <br> <?php echo $cpwE; ?> </span>
                            <span class="correct"> <?php echo $cpw_match; ?> </span>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <label for="gender">Gender</label>
                        </div>
                        <div class="col2">
                            <div class="gender">
                                <input type="radio" id="male" name="gender" value="Male"
                                <?php if (isset($gender) && $gender=="Male") echo "checked";?> >
                                <label for="male">Male</label>
                                <input type="radio" id="female" name="gender" value="Female"
                                <?php if (isset($gender) && $gender=="Female") echo "checked";?> >
                                <label for="female">Female</label>
                                <span class="errorGender"><?php echo $genderE; ?> </span>
                            </div>
                        </div>
                    </div>
                    <br><br>

                    <div class="row">
                        <div class="col1">
                            <label for="address">Address</label>
                        </div>
                        <div class="col2">
                            <input type="text" id="address" name="Address" placeholder="Address.." value="<?php echo $add;?>" >
                            <span class="error"> <br> <?php echo $addE; ?> </span>
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
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col1">
                            <label for="type">Type</label>
                        </div>
                        <div class="col2">
                            <div class="type" >
                                <input type="radio" id="volunteer" name="type" value="volunteer"
                                <?php if (isset($type) && $type=="volunteer") echo "checked";?> >
                                <label for="volunteer">Volunteer</label>
                                <input type="radio" id="organizer" name="type" value="organizer"
                                <?php if (isset($type) && $type=="organizer") echo "checked";?> >
                                <label for="organizer">Organizer</label>
                                <span class="errorGender"><?php echo $typeE; ?> </span>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row" id="resumeRow" style="display: none;">
                        <div class="col1">
                            <label for="resume">Resume</label>
                        </div>
                        <div class="col2" style="margin-left:40%; margin-top:-3%;">
                            <input type="file" id="resume" name="resume" accept=".pdf">
                        </div>
                    </div>

                    <div class="row" id="nameRow" style="display: none;">
                        <div class="col1">
                            <label for="oName">Organization Name</label>
                        </div>
                        <div class="col2" style="margin-left:40%; margin-top:-4%;">
                            <input type ="text" id="oName" name="oName" placeholder="Organization Name..." value="<?php echo $oName;?>" style=" width: 350px; height:30px; font-family: Arial;"></text>
                        </div>
                    </div>

                    <div class="row" id="descriptionRow" style="display: none;">
                        <div class="col1">
                            <label for="oDes">Description</label>
                        </div>
                        <div class="col3"style="margin-left:40%; margin-top:-1%;" >
                            <textarea id="oDes" name="oDes" placeholder="Description of the Organizer..." value="<?php echo $oDes;?>" style=" width: 350px; height:150px; font-family: Arial;"></textarea>
                        </div>
                    </div>
                    <br><br>

                    <div class="Terms_Con">
                        <input type="checkbox" id="terms" name="terms" value="Accepted"
                        <?php if (isset($terms) && $terms == "Accepted") echo "checked";?> >
                        <label for="terms">I accept the above Terms and Conditions</label>
                        <div class="errorTerms"> <br> <?php echo $termsE; ?> </div>
                    </div> 

                    <div class="btn">
                        <input type="submit" name = "submit" value="Register" >
                    </div>
                </form>
            </div>

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
    document.getElementById('volunteer').addEventListener('change', function() 
    {
        var type = this.value;
        var resumeRow = document.getElementById('resumeRow');
        var nameRow = document.getElementById('nameRow');
        var descriptionRow = document.getElementById('descriptionRow');
        
        if (type === 'volunteer') 
        {
            resumeRow.style.display = 'block';
            nameRow.style.display = 'none';
            descriptionRow.style.display = 'none';
        } 
        else 
        {
            resumeRow.style.display = 'none';
            nameRow.style.display = 'none';
            descriptionRow.style.display = 'none';
        }
    });

    document.getElementById('organizer').addEventListener('change', function() 
    {
        var type = this.value;
        var resumeRow = document.getElementById('resumeRow');
        var nameRow = document.getElementById('nameRow');
        var descriptionRow = document.getElementById('descriptionRow');
    
        if (type === 'organizer') 
        {
            resumeRow.style.display = 'none';
            nameRow.style.display = 'block';
            descriptionRow.style.display = 'block';
        } 
        else
        {
            resumeRow.style.display = 'none';
            descriptionRow.style.display = 'none';
            nameRow.style.display = 'none';
        }
    });
</script>

</body>

</html>