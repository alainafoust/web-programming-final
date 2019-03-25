<?php
    session_start();
    include("connection.php");
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title>Home</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    
    <link rel="stylesheet" type="text/css" href="css/home_css.css">

    <script src="js/jquery-3.1.1.min.js"></script>
    
    <!-- favicons -->
    
    <link rel="apple-touch-icon" sizes="152x152" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="favicons/manifest.json">
    <meta name="theme-color" content="#ffffff">
    
    <script>
        //well height js from Marky Roden at: 
        //https://xomino.com/2015/03/29/aligning-bootstrap-well-heights-within-the-same-row/
        $('.row').each(function(){
          var panelHeight=0
          $(this).find('.panel').each( function(){
              var temp = $(this).height()
              if (temp>panelHeight){
               panelHeight=temp
              }
          }).height(panelHeight+"px")
        })            
    </script>
    
</head>
    <body>
        
    <!-- BEGIN NAV BAR -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapsemenu" aria-expaded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="row hidden-xs">
                        <img src="" alt="" />
                    </div>
                    <a class="navbar-brand" href="final_home.php">Plants, Plants, Plants!</a>
                </div>
                <div class="collapse navbar-collapse" id="collapsemenu">
                    <ul class="nav navbar-nav">
                        <li><a href="overview.php">Forum and Messaging</a></li>
                        <li><a href="review_index.php">Plant Reviews</a></li>
                        <li><a href="map.php">Interactive Map</a></li>
                    </ul>
                    <?php
                        if($_SESSION['signed_in'] == false){
                            //show the navbar Login and Register links
                            echo '<ul class="nav navbar-nav navbar-right">
                                <li><a href=""><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>

                                <li><div class="ar login_popup"><a class="button btn" href="final_login.php"><span class="glyphicon glyphicon-log-in"></span> Log In</a></div></li>
                                </ul>
                            </div>
                        </div>
                    </nav>';
                        }
                        else{
                            //show the navbar with Logout links
                            echo '<ul class="nav navbar-nav navbar-right">
                                <p class="navbar-text">Hello ' . $_SESSION['user_name'] . ' Not you?</p>
                                <li><a href="final_logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                                </ul>
                            </div>
                        </div>
                    </nav>';
                        }
                    ?>



    <!-- END NAV BAR -->

        <div class="container-fluid">

            <div class="hero_image"> 
                <img class="center-block img-responsive" src="images/succulent-trio-2026503_1280.jpg" alt="three succulents in a row">
                <div class="row" id="about">
                    <div class="center-block">
                        <h1>Plants, Plants, Plants!</h1>
                        <p>
                            Reviews &#124; Reviews about plants! <br>
                            Plant Care Wiki &#124; Crowd-sourced plant care guides!
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">

            </div>

            <div class="row">
                <div class="col-sm-4" style="background-color:;">
                    <div class="panel panel-default" id="section_desc">
                        <div class="panel-body">
                            Read, edit, and learn from our community through plant care focused wikis.
                            <br>
                            <br>
                            <a href="plant_index.php" button class="btn btn-primary btn-lg btn-block" role="button">Plant Care Wiki</a>
                            <br>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4" style="background-color:;">
                    <div class="panel panel-default" id="section_desc">
                        <div class="panel-body">
                            Curious about a new plant but not sure if you have enough time or patience to care for it? Check out our plant reviews to help decide if that fiddle leaf fig tree or ficus is right for you.
                            <br>
                            <br>
                            <a href="review_index.php" button class="btn btn-primary btn-lg btn-block" role="button">Plant Reviews</a>
                            <br>
                        </div>    
                    </div>
                </div>

                <div class="col-sm-4" style="background-color:;">
                    <div class="panel panel-default" id="section_desc">
                        <div class="panel-body">
                            Chat with your fellow plant lovers about all things plants!
                            <br>
                            <br>
                            <button type="button" class="btn btn-primary btn-lg btn-block">Plant Forum</button>
                            <br>
                        </div>
                    </div>
                </div>   
            </div> 
        </div>

        <!-- keep this at the bottom of the body -->
        <?php include("footer.php"); ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
    </body>
    
</html>