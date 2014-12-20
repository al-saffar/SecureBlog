<?php
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/database/db_connect.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/config/secure_session.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/blogMapper.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/sql/loginMapper.php';
include_once ''.$_SERVER['DOCUMENT_ROOT'].'/SecureBlog/classes/post.php';

sec_session_start();

if(!login_check($mysqli))
{
    header('Location: index.php');
}

$posts = getPosts($mysqli);

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
          
      </div>

      <div class="row">

        <div class="col-sm-8 blog-main">
        <div class="blog-post" style='padding:5px;'>
            <form action="functions/post.php" method="POST" enctype="multipart/form-data">
                
                <textarea id="new_post" name="new_post" rows="1" style="max-width:100%;min-width:100%;resize:none;" placeholder="What's on your mind?" onclick="expand_post_area()" onblur="collapse_post_area()"></textarea>
                <div style='display:table;'>
                  <div style="display:table-cell;width:100%;">
                      <input type='file' id='post_image' name='post_image'/>
                      <input type="hidden" name="MAX_FILE_SIZE" value="50000" />
                  </div>
                  <div style='display:table-cell;'>
                      <input type='hidden' id='token' name='token' value='<?php echo $_SESSION['token']; ?>'>
                      <input type='submit' name='submit_post' value='Post'/>
                  </div>
                </div>
            </form>
        </div>
        
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
                                <div style='float:right;font-size:12px;<?php echo ($post->getPosterID() != $_SESSION['userID'] ? "padding-right:20px;" : "") ?>display:table-cell;'>
                                    <?php echo $post->getTime(); ?>
                                    <?php 
                                    if($post->getPosterID() == $_SESSION['userID'])
                                    {
                                        echo "<a id='delete_post_".$post->getPostID()."' style='cursor:pointer;'>[X]</a>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div>
                                <div class='blog-post-body'>
                                    <?php 
                                        echo $post->getPost(); 
                                        if($post->getHasImage() == 1)
                                        {
                                            $image = $post->getPath();
                                            echo "<img src='assets/uploads/$image' style='width:100%'/>";
                                        }
                                    ?>
                                   
                                </div>
                            </div>
                            <div style='width:100%;text-align:right;padding-right:15px;border-top:1px solid #e1e1e1'>
                                <a id='comment_click_<?php echo $post->getPostID(); ?>' style="cursor:pointer;">comments</a>
                            </div>
                            <div id='comments_<?php echo $post->getPostID(); ?>' style='width:100%;border-top:1px solid #e1e1e1;display:none;'>
                                <div style='padding-left:5px;'>Comments</div>
                                <div style='width:100%;padding-right:5px;padding-left:5px;padding-bottom:5px;'>
                                    <input id='write_comment_<?php echo $post->getPostID(); ?>' placeholder="Write a comment.." style='width:100%;'/>
                                </div>
                                <div id='comment_section_<?php echo $post->getPostID(); ?>'>
                                    
                                </div>
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
            <h4>Your Ad HERE</h4>
            <p>Do you want to advertise on the most Secure blog ever? <br>Then what are you waiting for?<br><br>Contact us and lets work out the details</p>
          </div>
          <div class="sidebar-module sidebar-module-inset">
            <h4>Your Ad HERE</h4>
            <p>Do you want to advertise on the most Secure blog ever? <br>Then what are you waiting for?<br><br>Contact us and lets work out the details</p>
          </div>
        </div><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </div><!-- /.container -->

    <footer class="blog-footer">
      <p>CopyRight (c) Secure Blog Co. 2014-2060</p>
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
    function expand_post_area()
    {
        $('#new_post').attr('rows','4');
    }
    function collapse_post_area()
    {
        if($('#new_post').val().length < 1)
        {
            $('#new_post').attr('rows','1');
        }
    }
    
    $( document ).ready(function() {
        <?php 
            if($posts != NULL)
            {
                foreach ($posts as $post)
                {
                    ?>
                    
                    $('#comment_click_<?php echo $post->getPostID(); ?>').on("click", function(){
                        if($('#comments_<?php echo $post->getPostID(); ?>').css('display') == 'none')
                        {
                            $('#comments_<?php echo $post->getPostID(); ?>').css("display", "block");
                            load_comments(<?php echo $post->getPostID(); ?>);
                        }
                        else
                        {
                            $('#comments_<?php echo $post->getPostID(); ?>').css("display", "none");
                        }
                    });
                    
                    $('#write_comment_<?php echo $post->getPostID(); ?>').keyup(function (e) {
                        if (e.keyCode == 13) {
                            if($('#write_comment_<?php echo $post->getPostID(); ?>').val() !== "")
                            {
                                post_comment(<?php echo $post->getPostID(); ?>,  $('#write_comment_<?php echo $post->getPostID(); ?>').val());
                                $('#write_comment_<?php echo $post->getPostID(); ?>').val("");
                            }
                        }
                    });
                    
                    $('#delete_post_<?php echo $post->getPostID(); ?>').on("click", function(){
                        window.location = "functions/delete_post.php?id=<?php echo $post->getPostID(); ?>&token=<?php echo $_SESSION['token']; ?>";
                    });
                    
                    <?php
                }
            }
        ?>
    });
    
    function load_comments(postID)
    {
        $("#comment_section_"+postID+"").html("");
        var token = '<?php echo $_SESSION['token']; ?>';
        $.post('./functions/load_comments.php', {'id' : postID, 'token' : token}, function(data) {
            var res = data.split("|");
            
            for(i = 0; i < res.length; i++)
            {
                var com = res[i].split(".");
                
                com[0] = com[0].replace(/string\([0-9]+\) "/i, "");
                
                var strTest = com[1];
                if(strTest && strTest.indexOf("undefined") == -1)
                {
                    $("#comment_section_"+postID+"").html($("#comment_section_"+postID+"").html()+""+com[0]+": "+com[1]+"<br>");
                }
            }
        });
    }
    
    function post_comment(postID, comment){
        var token = '<?php echo $_SESSION['token']; ?>';
        $.post('./functions/post_comment.php', {'post_id' : postID, 'comment' : comment, 'token' : token}, function(data) {
            load_comments(postID);
        });
    }
    </script>
<!--    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script> -->
  </body>
</html>

