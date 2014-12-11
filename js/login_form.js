function formhash(form, password) {
    
    //create input tag
    var p = document.createElement("input");
 
    //add the input tag to the form
    form.appendChild(p);
    
    p.name = "token"; //name it p
    p.type = "hidden"; //make it hidden
    p.value = hex_sha512(password.value); //make the value the hashed password
 
    password.value = hex_sha512("thepasswordissecret");
 
    // submit the form
    form.submit();
}