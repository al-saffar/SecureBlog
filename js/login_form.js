function formhash(form, password) {
    
    //create input tag
    var p = document.createElement("input");
 
    //add the input tag to the form
    form.appendChild(p);
    
    p.name = "p"; //name it p
    p.type = "hidden"; //make it hidden
    p.value = hex_sha512(password.value); //make the value the hashed password
 
    //delete the plain text password
    password.value = "";
 
    // submit the form
    form.submit();
}