function validateEditForm()
{
    //declaration
    let fname = document.edit.fname.value;
    let lname = document.edit.lname.value;
    let email = document.edit.email.value;
    let phone = document.edit.mobile.value;
    let pw = document.edit.pw.value;
    let cpw = document.edit.cpw.value;
    let address = document.edit.Address.value;
    let city = document.edit.city.value;
    let resume = document.edit.resume.value;
    
    
    //validate first name
    if(fname == "" ||  fname == null)
    {
        alert("First name cannot not be Empty!");
        return false;
    }

    //validate last name
    if(lname == "" ||  lname == null)
    {
        alert("Last name cannot not be Empty!");
        return false;
    }


    //validate email
    if(email == "" ||  email == null)
    {
        alert("Email cannot not be Empty!");
        return false;
    }
    else if(email != null)
    {
        let bool = ValidateEmail(email);
        if( bool == false)
        {
            return false;
        }
    }

    //validate phone
    if(phone == "" ||  phone == null)
    {
        alert("Phone cannot not be Empty!");
        return false;
    }
    else if(phone != null)
    {
        let bool = ValidatePhone(phone);
        if( bool == false)
        {
            return false;
        }
    }

    //validate password
    if(pw == "" ||  pw == null)
    {
        alert("Password cannot not be Empty!");
        return false;
    }
    else if (pw != null)
    {
        let bool = ValidatePw(pw);
        if( bool == false)
        {
            return false;
        }
    }

    //validate confirm password
    if(cpw == "" ||  cpw == null)
    {
        alert("Confirm Password cannot not be Empty!");
        return false;
    }
    else if (cpw != null)
    {
        let bool = ValidateCpw(cpw, pw);
        if( bool == false)
        {
            return false;
        }
    }

    //validate whether the gender is checked
    if(!document.getElementById("male").checked && !document.getElementById("female").checked)
    {
        alert("Please select your gender!");
        return false;
    }

    //validate address
    if( address  == ""  )
    {
        alert("Address is Required!");
        return false;
    }
    
    
    //validate city
    if( city  == ""  )
    {
        alert("City is Required!");
        return false;
    }
    
}

function ValidateEmail(email) //Validate email
{
    var RegEmail =  /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9]+\.com$/;
    if(!email.match(RegEmail))
    {
        alert("Please use a valid Email following the format: something@domain.com");
        return false;
    }
}

function ValidatePhone(phone) //Validate phone number
{
    if(isNaN(phone)) //not numbers
    {
        alert("Please use a valid phone number with only numbers 0-9!");
        return false;
    }
    else if(phone.length> 11 || phone.length < 10) //Too short or too long
    {
         alert("Please use a valid phone number with correct length!");
         return false;
    }
}

function ValidatePw(pw) //Validate password
{
    var numbers = ('[0-9]');
    var Lalphabet = ('[a-z]');
    var Ualphabet = ('[A-Z]');
    var specialC = ('[!@#$%^&*]');
    var whitespace = /\s/; //find whitespace
    
    if(pw.length <6) //Less than 6 digits
    {
        alert("Please use a password with at least 6 digits!");
        return false;
    }
    else if(!pw.match(numbers) || !pw.match(Lalphabet) || !pw.match(Ualphabet) || !pw.match(specialC))
    {
        alert("Please use an alphanumberic password with at least ONE upppercase, ONE lowercase, ONE special character and numbers !");
        return false;
    }
    else if(pw.match(whitespace)) //If whitespace found
    {
        alert("Please make sure there is no white space in the password!");
        return false;
    }
}

function ValidateCpw (cpw, pw)
{
    if(cpw !== pw) //password is valid, now check whether the confirm pw is the same with the pw
    {
        alert("Please make sure the confirm password is the same with the password!");
        return false;
    }
}



//Display the form to edit profile
function display() 
{
    document.getElementById("display0").style.display = "none";
    document.getElementById("display1").style.display = "none";
    document.getElementById("display2_cpw").style.display = "none";
    document.getElementById("display3").style.display = "none";
    document.getElementById("display4").style.display = "none";
    document.getElementById("display5").style.display = "none";
    document.getElementById("display6").style.display = "none";
    document.getElementById("display7").style.display = "none";
    document.getElementById("display9").style.display = "none";
    document.getElementById("display10").style.display = "none";
    document.getElementById("display8").style.display = "block";

    document.getElementById("state").style.display = "block";
    document.getElementById("city").style.display = "block";
    document.getElementById("address").style.display = "block";
    document.getElementById("fname").style.display = "block";
    document.getElementById("lname").style.display = "block";
    document.getElementById("email").style.display = "block";
    document.getElementById("pw").style.display = "block";
    document.getElementById("mobile").style.display = "block";
    document.getElementById("GENDER").style.display = "block";
    document.getElementById("male").style.display = "inline-flex";
    document.getElementById("female").style.display = "inline-flex";
    document.getElementById("cpw").style.display = "block";
    document.getElementById("resume").style.display = "block";

    document.getElementById("edit_confirm_pw").style.display = "block";

    document.getElementById("button").style.display = "block";
}

//Display the profile when cancel is clicked
function cancel_edit()
{
    document.getElementById("display0").style.display = "block";
    document.getElementById("display1").style.display = "block";
    document.getElementById("display2_cpw").style.display = "none";
    document.getElementById("display3").style.display = "block";
    document.getElementById("display4").style.display = "block";
    document.getElementById("display5").style.display = "block";
    document.getElementById("display6").style.display = "block";
    document.getElementById("display7").style.display = "block";
    document.getElementById("display9").style.display = "block";
    document.getElementById("display10").style.display = "block";
    document.getElementById("display8").style.display = "block";

    document.getElementById("edit_confirm_pw").style.display = "none";

    document.getElementById("state").style.display = "none";
    document.getElementById("city").style.display = "none";
    document.getElementById("address").style.display = "none";
    document.getElementById("fname").style.display = "none";
    document.getElementById("lname").style.display = "none";
    document.getElementById("email").style.display = "none";
    document.getElementById("pw").style.display = "none";
    document.getElementById("mobile").style.display = "none";
    document.getElementById("GENDER").style.display = "none";
    document.getElementById("male").style.display = "none";
    document.getElementById("female").style.display = "none";
    document.getElementById("cpw").style.display = "none";
    document.getElementById("resume").style.display = "none";

    document.getElementById("button").style.display = "none";
}