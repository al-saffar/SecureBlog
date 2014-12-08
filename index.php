<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/loginMapper.php';
sec_session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    
    <title>Secure Blog</title>
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/login_form.js"></script>
    
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/forms.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <?php 
    if(isset($_GET['error']) && $_GET['error'] == 1)
    {
    ?>
      <div class="alert-warning"><label>Wrong e-mail or password entered, please try again!</label></div>
    <?php 
    }
    ?>
    
    <div class="container">

        <form class="form-signin" role="form" action="functions/login.php" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="mail" class="sr-only">Email address</label>
        <input type="email" id="mail" class="form-control" name="mail" placeholder="Email address" required autofocus>
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <input class="btn btn-lg btn-primary btn-block" type="button" value="Login" onclick="formhash(this.form, this.form.password);" />
        </form>
        <!--
        <div style="position:relative;margin:auto auto;width:500px;height:460px; top:-140px; text-align:center;background:#d9d9d9;border: 1px solid #c0c0c0;">
            
            <form class="form-register" role="form" action="functions/login.php" method="post">
                <h2 class="">Register on Secure Blog!</h2>
                
                <div style="display:table; width:100%;">
                <input type="text" id="firstname" name="firstname" style="width:50%;display:table-cell;" class="form-control" placeholder="Firstname" required>
                <input type="text" id="lastname" name="lastname" style="width:50%;display:table-cell;" class="form-control" placeholder="Lastname" required>
                </div>
                
                <label for="mail" class="sr-only">Email address</label>
                <input type="email" id="mail" class="form-control" name="mail" placeholder="Email address" required autofocus>
                
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                <label for="passwordAgain" class="sr-only">Password again</label>
                <input type="password" id="password" name="passwordAgain" class="form-control" placeholder="Password Again" required>
                
                <div style="margin-top:15px;display:table;">
                    <input type="number" id="age" name="age" style="width:20%;display:table-cell;float:left" class="form-control" placeholder="Age" required>
                
                    <select style="display:table-cell;width:45%;position:relative;left:-25px;">
                        <option value="0" style="color:grey;">Choose Gender</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>
                </div>
                
                <div style="margin-top:15px;display:table;width:100%">
                    <select style="display:table-cell;width:50%;">
                        <option value="0" style="color:grey;">Country</option>
                        <option value="1">Denmark</option>
                        <option value="2">Germany</option>
                    </select>
                
                    <select style="display:table-cell;width:50%;">
                        <option value="0" style="color:grey;">City</option>
                        <option value="1">Frederikssund</option>
                        <option value="2">København</option>
                    </select>
                </div>
                
                <input class="btn btn-lg btn-primary btn-block" style="margin-top:15px;" type="button" value="Register" onclick="formhash(this.form, this.form.password);" />
            </form>
            
        </div> -->
    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
  
  <script type="text/javascript">
		function displayPopUp() {
			document.getElementById("createUser").style.display = "block";
			document.getElementById("fadeOn").style.display = "block";

		}
		function closePopUp() {
			document.getElementById("createUser").style.display = "none";
			document.getElementById("fadeOn").style.display = "none";
		}
  
  
</html>
