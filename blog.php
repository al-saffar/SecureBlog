<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/config/secure_session.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/blogMapper.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/classes/post.php';

sec_session_start();

$posts = getPosts($mysqli);
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

    <title>SecureBlog</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/blog.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="#"><?php echo $_SESSION['firstname']." ".$_SESSION['lastname']; ?></a>
        </nav>
      </div>
    </div>

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">The Bootstrap Blog</h1>
        <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p>
      </div>

      <div class="row">

        <div class="col-sm-8 blog-main">

        <?php 
            if($posts != NULL)
            {
                foreach ($posts as $post)
                {
                    ?>
                        <div class='blog-post'>
                            <div style="width:100%;display:table;">
                                <div class='blog-post-head' style='float:left;display:table-cell;'>
                                    <?php echo $post->getPosterName(); ?> says: 
                                </div>
                                <div style='float:right;padding-right:10px;font-size:12px;display:table-cell;'>
                                    <?php echo $post->getTime(); ?>
                                </div>
                            </div>
                            <div>
                                <div class='blog-post-body'>
                                    <?php echo $post->getPost(); ?>
                                </div>
                            </div>
                            <div style='width:100%;text-align:right;padding-right:15px;border-top:1px solid #e1e1e1'>
                                <a>comments</a>
                            </div>
                        </div>
                    <?php
                }
            }
        ?>

          <nav>
            <ul class="pager">
              <li><a href="#">Previous</a></li>
              <li><a href="#">Next</a></li>
            </ul>
          </nav>

        </div><!-- /.blog-main -->

        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
            <h4>About</h4>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
          </div>
          <div class="sidebar-module">
            <h4>Archives</h4>
            <ol class="list-unstyled">
              <li><a href="#">March 2014</a></li>
              <li><a href="#">February 2014</a></li>
              <li><a href="#">January 2014</a></li>
              <li><a href="#">December 2013</a></li>
              <li><a href="#">November 2013</a></li>
              <li><a href="#">October 2013</a></li>
              <li><a href="#">September 2013</a></li>
              <li><a href="#">August 2013</a></li>
              <li><a href="#">July 2013</a></li>
              <li><a href="#">June 2013</a></li>
              <li><a href="#">May 2013</a></li>
              <li><a href="#">April 2013</a></li>
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>Elsewhere</h4>
            <ol class="list-unstyled">
              <li><a href="#">GitHub</a></li>
              <li><a href="#">Twitter</a></li>
              <li><a href="#">Facebook</a></li>
            </ol>
          </div>
        </div><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </div><!-- /.container -->

    <footer class="blog-footer">
      <p>Blog template built for <a href="http://getbootstrap.com">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!--    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script> -->
  </body>
</html>

