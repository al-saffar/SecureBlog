<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/config/secure_session.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/admin/functions/encryptDecrypt.php';
//include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/admin/functions/deleteUser.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/admin/classes/user.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'../SecureBlog/sql/loginMapper.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/admin/sql/usersMapper.php';
//include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/functions/logout.php';



sec_session_start();
if(!login_check($mysqli))
{
    header('Location: ../index.php');
}

$allUsers = getUsers($mysqli);
$alladm = getAdmins($mysqli);
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

    <title>Admin - SecureBlog</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a class="navbar-brand" href="#">Admin: <?php print_r(decrypt($_SESSION ['adminLogin'], $_SERVER['REMOTE_ADDR'])); ?>
            <?php  print_r('- IP: '.$_SERVER['REMOTE_ADDR']); ?></a>
            
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <form class="navbar-form navbar-right" method="POST" action="../functions/logout.php" >
            <li>   <input class="btn btn-danger" type="submit" value="Logout" ></li>
          </form>
          </ul>
            
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search for users...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Users <span class="sr-only">(current)</span></a></li>
            <li><a href="accesslog.php">Login log</a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Export</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item</a></li>
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
            <li><a href="">More navigation</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>

          <div class="row placeholders">
                <?php 
            if(isset($alladm))
            {
                foreach ($alladm as $user)
                {
                ?>     
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="../img/admin.jpg" class="img-responsive">
              <h4>Admin</h4>
              
              <span class="text-muted"><?php echo $user->getFirstname(); ?><?php echo ' '.$user->getLastname(); ?></span>
            </div>
         
             <?php 
                }
            }
                ?>    
          </div>
       
          <h2 class="sub-header">Users</h2>
          <div class="table-responsive">
              <form action="../admin/functions/deleteUser.php" method="POST">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>ID</th>
                  <th>mail</th>
                  <th>Firstname</th>
                  <th>Lastname</th>
                  <th>DOB</th>
                  <th>Gender</th>
                  <th>Type</th>
                  <th>Timestamp</th>
                  
                </tr>
              </thead>
              <tbody>
                  
                   <?php 
            if(isset($allUsers))
            {
                foreach ($allUsers as $user)
                {
                    $id = $user->getId();
                    $email = $user->getEmail();
                    $firstname = $user->getFirstname();
                    $lastname = $user->getLastname();
                    $DOB = $user->getDOB();
                    $gender = $user->getGender();
                    $type = $user->getType();
                    $timestamp = $user->getTimestamp();
                         echo "<tr>
                             
                    <td><input type=\"checkbox\" name=\"checkbox\" value=\"$id\"></td>
                    <td>$id</td>
                    <td>$email</td>
                    <td>$firstname</td>
                    <td>$lastname</td>
                    <td>$DOB</td>
                    <td>$gender</td>
                    <td>$type</td>
                    <td>$timestamp;
                </tr>";
              
            }
            }
            ?>
               
               
              </tbody>
            </table>
               <input type='hidden' id='token' name='token' value=<?php$_SESSION['token'];?>
               <input class="btn btn-danger" type="submit" value="DELETE" >
               </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
