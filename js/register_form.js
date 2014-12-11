function registerFormCheck(form, firstname, lastname, mail, password, passwordAgain, dob, gender, city)
{
    if(firstname === ''
                        || lastname.value === '' 
                        || mail.value === ''
                        || password.value === ''
                        || passwordAgain.value === ''
                        || dob.value === ''
                        || gender.options[gender.selectedIndex].value === 0
                        || city.options[gender.selectedIndex].value === 0)
    {
        alert("err"+dob.value+gender.options[gender.selectedIndex].value+""+city.options[gender.selectedIndex].value);
    }
    if(password != passwordAgain)
    {
        //passwords doesn't match
    }
    if(password.value.length < 6)
    {
        //password needs to be 6 long
    }
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
        //Passwords must contain at least one number, one lowercase and one uppercase letter.
    }
    
    //create hidden input that will contain the hashed pass
    var p = document.createElement("input");
    form.appendChild(p);
    p.name = "p";
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
    
    //reset password values
    password.value = "";
    passwordAgain.value = "";
    
    form.submit();
}