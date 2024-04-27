<?php session_start(); ob_start();?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login - VolunUnity Connect</title>
        <meta charset="UTF-8">
        <link rel="icon" href="Pictures/iconsmall.png">
        <link rel="shortcut icon" href="Pictures/iconsmall.png">
        <link rel="stylesheet" href="CSS/login.css">
        <link rel="stylesheet" href="CSS/footer.css">
    </head>

    <body>
        <?php 
            //Declarations
            $email = $pw = "";
            $emailE = $pwE ="";
            $error= "";

            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                //Validate Email
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

                //Validate Password
                if(empty($_POST["pw"]))
                {
                    $pwE = "*Password is required!";
                }
                else
                {
                    $pw = test($_POST["pw"]);
                }

            }

            function test($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            //Connection
            include 'connection.php';
            //No error in input
            if (!empty($_POST["email"])&& !empty($_POST["pw"])) //Check whether the user exists 
            {
                $sql = "SELECT id FROM user WHERE email='$email' AND pwd='$pw'"; //Select the user id
                $isFound = mysqli_query($conn,$sql); //Check is it exists
                
                //Found the user
                if(mysqli_num_rows($isFound) == 1) 
                {
                    //fetch the id
                    $result = mysqli_fetch_assoc($isFound);
                    $id = $result["id"];

                    //Update the login status in table
                    $sql = "UPDATE user SET _login=1 WHERE id='$id'";
                    $result = mysqli_query ($conn,$sql);
                    //See if updated
                    if($result == true)
                    {
                        //echo "UPDATED LOGIN";
                    } 
                    else
                    {
                        echo "Failed to update". $conn->error;
                    }
                    
                    //Set session variables
                    $_SESSION['email'] = $email;
                    $_SESSION['login'] = "Logged In";
                    $_SESSION['user_id'] = $id;

                   //Check user type
                   $result2=mysqli_query($conn,"SELECT*FROM user WHERE id='$id' AND pwd='$pw'");
                   $row=mysqli_fetch_assoc($result2);
                   $count=mysqli_num_rows($result2);
                    
                    if($count==1){
                        $_SESSION['user']=array(
                          'id'=>$row['id'],
                          'pwd'=>$row['pwd'],
                          'userType'=>$row['userType']
                        );
                        if ($_SESSION['user']['id'] && $_SESSION['user']['userType'] == 'volunteer') {
                          
                          header("Location: index.html");
                        
                        }
                        else if ($_SESSION['user']['id'] && $_SESSION['user']['userType'] == 'organizer') {
                            header("Location: create_listing.php");
                        }

                      }
                    //Close Connection
                    mysqli_close($conn);
                    
                    // Redirecting user
                    // header("Location: index.html");
                    ob_end_flush();
                }   
                else
                {
                    $error = "Login Failed! Wrong Password or Email, Please try again!";
                }
            }
        ?>

        <header>
            <a href="index.html"> <img class="logo" src="Pictures/icon.png" alt="VolunUnity Connect"> </a>
            <div class="login_register">
                <ul>
                  <li><u><a href="register.php">No account? Register now!</a></u></li>
                </ul>
            </div>

        </header>
        
        <br><br>
        
        <div class="column">
            <h3 class="login"> Connecting Hearts, Empowering Change

            </br></br>
                
            Welcome to <b>VolunUnity Connect</b> - Your Gateway to Purposeful Volunteering!</h3>
            
            <hr id="line"/><br> 
                
            <div class = "login_error">
                <span class = "login_fail"><?php echo $error; ?></span>
            </div>
                    
            <div class="headerLogin">
                 <h2>Login here!</h2>
            </div>

            <form name="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="input-group">
                    <label>Email:</label>
                    <input type="email" id="email" name="email" placeholder="Email.." value="<?php echo $email;?>" ><br>
                    <span class="error"> <?php echo $emailE; ?> </span>
                </div>

                <div class="input-group">
                    <label>Password:</label>
                    <input type="password" id="pw" name="pw" placeholder="Password.." value="<?php echo $pw;?>" ><br>
                    <span class="error"> <?php echo $pwE; ?> </span>
                </div>
      
                <div class="input-group">
                    <button type="submit" class="btn" name="Login">Login</button>
                </div>
            </form>
        </div>

        <br><br><br><br><br><br><br><br><br>

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