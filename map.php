<?php
    session_start();
    include("connection.php");
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title>Interactive Plant Map</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    
    <link rel="stylesheet" type="text/css" href="css/map.css">

    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/map_script.js"></script>
    
    <!-- favicons -->
    
    <link rel="apple-touch-icon" sizes="152x152" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="favicons/manifest.json">
    <meta name="theme-color" content="#ffffff">
       
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
                        <li><a href="review_index.php">Reviews</a></li>
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
        <h1>Interactive Map</h1>
        <p>Find and share houseplant, gardening, and all-things-plant-related locations in your area!</p>
    </div>
    <!-- the following input and div are for the search box and map elements that will be created in the javascript code -->                      
    <div id="map" height="60%" width="100%"></div>
    <br> <br>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                    
    <div class="container-fluid">
    <p>Instructions:
        <ul>
            <li>To add a location:</li>
            <ol>
                <li>Zoom or use the search bar to find your location</li>
                <li>Click the location or approximate location to add a marker</li>
                <li>Click once more to add the marker info</li>
            </ol>
            <li>To view location details:</li>
            <ol>
                <li>Click an existing marking to view location details</li>
            </ol>
        </ul>    
    </p>                
    </div>

    <!-- keep this at the bottom of the body -->
    <!-- API Script -->
    
    <script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8Ly1_QO0eaXaP2s11VjB9vDWGCmNG_sY&libraries=places&callback=initMap"></script>                

    <?php include('footer.php') ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    </body>
    
</html>