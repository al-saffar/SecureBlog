<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/config/secure_session.php';
sec_session_start();

$_SESSION['token'] = hash("SHA1", time());
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
    <script type="text/JavaScript" src="js/vendor/jquery-1.11.1.js"></script> 
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/login_form.js"></script>
    <script type="text/JavaScript" src="js/register_form.js"></script>
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
    if(isset($_GET['error']))
    {
        if($_GET['error'] == 1)
        {
            echo "<div class='alert-warning'><label>Wrong e-mail or password entered, please try again!</label></div>";
        }
        else if($_GET['error'] == 2)
        {
            echo "<div class='alert-warning'><label>An error happened during registation. Please try again later.</label></div>";
        }
    }
    else if(isset($_GET['success']))
    {
        if($_GET['success'] == 1)
        {
            echo "<div class='alert-success'><label>Succesfully registered. You can now login!</label></div>";
        }
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
        <input type='hidden' id='token' name='token' value='<?php echo $_SESSION['token']; ?>'>
        <input class="btn btn-lg btn-primary btn-block" type="submit" value="Login" onclick="formhash(this.form, this.form.password, this.form.token);" />
        <input class="btn btn-lg btn-primary btn-block" type="button" value="Register" onclick="displayPopUp()" />
        </form>
        
        
    </div> <!-- /container -->
    <div id="fade" style="display:none;" onclick="closePopUp();"></div>
    <div id="regUser" style="position:relative;margin:auto auto;width:500px;height:460px; top:-250px; text-align:center;background:#d9d9d9;border: 1px solid #c0c0c0;display:none">
            <div id="err"></div>
            <form class="form-register" role="form" action="functions/register.php" method="post">
                <h2 class="">Register on Secure Blog!</h2>
                
                <div id="name" style="display:table; width:100%;">
                <label for="firstname" class="sr-only">Firstname</label>
                <input type="text" id="firstname" name="firstname" style="width:50%;display:table-cell;" class="form-control" placeholder="Firstname" required autofocus>
                <input type="text" id="lastname" name="lastname" style="width:50%;display:table-cell;" class="form-control" placeholder="Lastname" required>
                </div>
                
                <label for="mail" class="sr-only">Email address</label>
                <input type="email" id="mail" class="form-control" name="mail" placeholder="Email address" onchange="unique_mail(this.form.mail);" required>
                
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                <label for="passwordAgain" class="sr-only">Password again</label>
                <input type="password" id="passwordAgain" name="passwordAgain" class="form-control" placeholder="Password Again" required>
                
                <div style="margin-top:15px;display:table;width:100%">
                    <input type="date" max="2002-01-01" id="dob" name="dob" style="width:50%;height:42px;display:table-cell;float:left" class="form-control" required>
                
                    <select id="gender" style="display:table-cell;width:50%;float:right;">
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
                
                    <select id="city" style="display:table-cell;width:50%;">
                        <option value="0" style="color:grey;">City</option>
                        <option value="1">Frederikssund</option>
                        <option value="2">København</option>
                    </select>
                </div>
                <input type="hidden" id="valid" name="valid" value="false" />
                <input type='hidden' id='token' name='token' value='<?php echo $_SESSION['token']; ?>'>
                <input class="btn btn-lg btn-primary btn-block" style="margin-top:15px;" type="button" value="Register" onclick="registerFormCheck(this.form, this.form.firstname, this.form.lastname, this.form.mail, this.form.password, this.form.passwordAgain, this.form.dob, this.form.gender, this.form.city, this.form.valid, this.form.token);" />
            </form>
            
        </div>
  </body>
  
  <script type="text/javascript">
		function displayPopUp() {
			document.getElementById("regUser").style.display = "block";
			document.getElementById("fade").style.display = "block";
		}
		function closePopUp() {
			document.getElementById("regUser").style.display = "none";
			document.getElementById("fade").style.display = "none";
		}
  
  </script>
</html>
