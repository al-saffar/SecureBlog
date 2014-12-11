function registerFormCheck(form, firstname, lastname, mail, password, passwordAgain, dob, gender, city, valid)
{   
    if(firstname === ''
                        || lastname.value === '' 
                        || mail.value === ''
                        || password.value === ''
                        || passwordAgain.value === ''
                        || dob.value === ''
                        || gender.options[gender.selectedIndex].value < 1
                        || city.options[gender.selectedIndex].value < 1)
    {
        document.getElementById('err').innerHTML = "<div class='alert-warning' style='position:absolute;width:100%;height:40px'><label>Please fill all fields</label></div>";
        return false;
    }
    var re = /^[a-zA-Z]+[a-zA-Z-_]*[a-zA-Z]+$/;
    if(!re.test(firstname.value) || !re.test(lastname.value))
    {   //name check
        document.getElementById('err').innerHTML = "<div class='alert-warning' style='position:absolute;width:100%;height:40px'><label>Invalid name</label></div>";
        return false;
    }
    var re = /^\w+[@]\w+[.][a-z]+$/;
    if(!re.test(mail.value))
    {   //email check
        document.getElementById('err').innerHTML = "<div class='alert-warning' style='position:absolute;width:100%;height:40px'><label>Invalid email</label></div>";
        return false;
    }
    if(valid.value === 'false')
    {
        return false;
    }
    if(password.value != passwordAgain.value)
    {   //matching passwords
        document.getElementById('err').innerHTML = "<div class='alert-warning' style='position:absolute;width:100%;height:40px'><label>The passwords doesn't match. please re-enter them</label></div>";
        password.value = "";
        passwordAgain.value = "";
        return false;
    }
    if(password.value.length < 6)
    {
        //password needs to be 6 long
        document.getElementById('err').innerHTML = "<div class='alert-warning' style='position:absolute;width:100%;height:40px'><label>The password need to be atleast 6 chars long</label></div>";
        password.value = "";
        passwordAgain.value = "";
        return false;
    }
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        //Passwords must contain at least one number, one lowercase and one uppercase letter.
        document.getElementById('err').innerHTML = "<div class='alert-warning' style='position:absolute;width:100%;'><label>The password need to contain a number, a lowercase and a uppercase letter</label></div>";
        password.value = "";
        passwordAgain.value = "";
        return false;
    }
    
    var d = new Date();
    var minDate = ''+(d.getFullYear()-100)+'-'+(d.getMonth()+1)+'-'+d.getDate()+'';
    var maxDate = ''+(d.getFullYear()-12)+'-'+(d.getMonth()+1)+'-'+d.getDate()+'';
    if(dob.value < minDate)
    {
        document.getElementById('err').innerHTML = "<div class='alert-warning' style='position:absolute;width:100%;height:40px;'><label>You are too old to fully understand this site</label></div>";
        return false;
    }
    if(dob.value > maxDate)
    {
        document.getElementById('err').innerHTML = "<div class='alert-warning' style='position:absolute;width:100%;height:40px;'><label>You're just a kid!</label></div>";
        return false;
    }
    
    //create hidden input that will contain the hashed pass
    var p = document.createElement("input");
    form.appendChild(p);
    p.name = "token";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
    
    var gen = document.createElement("input");
    form.appendChild(gen);
    gen.name = "gen";
    gen.type = "hidden";
    gen.value = gender.options[gender.selectedIndex].value;
    
    var cit = document.createElement("input");
    form.appendChild(cit);
    cit.name = "cit";
    cit.type = "hidden";
    cit.value = city.options[city.selectedIndex].value;
    
    password.value = hex_sha512(mail.value);
    passwordAgain.value = "";
    
    form.submit();
}

function unique_mail(mail){
    $.post('./functions/check_mail.php', {'mail' : mail.value}, function(data) {
        if(data === 'true')
        {
            document.getElementById('err').innerHTML = "";
            document.getElementById('valid').value = true;
        }
        else
        {
            document.getElementById('err').innerHTML = "<div class='alert-warning' style='position:absolute;width:100%;height:40px'><label>This mail is already in use</label></div>";
            document.getElementById('valid').value = false;
        }
    });
}