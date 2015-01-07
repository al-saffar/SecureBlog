function formhash(form, password, token) {
    
    var tok = token.value;
    var pass = password.value;
    
    token.value = hex_sha512(pass); //make the value the hashed password
    password.value = tok;
    
    form.submit();
}