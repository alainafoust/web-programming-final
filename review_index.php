<?php
    session_start();
    include("connection.php");  
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title>Plant Review Index</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    
    <link rel="stylesheet" type="text/css" href="css/css.css">
    
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/jquery.leanModal.min.js"></script>
    
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
           <h1>Plant Reviews</h1>
                  
        <?php
    
            $sql = "SELECT DISTINCT plant_type FROM plants";
        
            $result = mysqli_query($conn, $sql);
        
            //error handling
            if(!$result){
                echo "Plant wikis cannot be displayed at this time, please try again later.";
            }
            else{
                if(mysqli_num_rows($result) == 0){
                    echo "There are no plants added to our wikis yet. Please check back later.";
                }
                else{
                    while($row = mysqli_fetch_assoc($result)){
                        //var_dump($row);

                        foreach($row as $key => $value){

                            echo '<h2>' . $row['plant_type'] . '</h2><hr><ul>';

                            $p_sql ="SELECT plant_id, plant_name FROM plants WHERE plant_type='" . $row['plant_type'] . "';";

                            $plant_result = mysqli_query($conn, $p_sql);

                            if(!$plant_result){
                                echo "Plants cannot be displayed at this time, please try again later.";
                            }
                            else{
                                if(mysqli_num_rows($plant_result) == 0){
                                    echo "There are no plants added to our wikis yet, please check back later...";
                                }
                                else{
                                    while($plant_row = mysqli_fetch_assoc($plant_result)){
                                        //var_dump($plant_row);

                                            echo '<li><a href="review_page.php?id=' . $plant_row['plant_id'] . '">' . $plant_row['plant_name'] . '</a></li>';

                                    }
                                    echo'</ul>';
                                }
                            }
                        }

                    }   
                }
            }
           
            mysqli_close($conn); 
        
        ?>
           
        </div>
        

        <!-- keep this at the bottom of the body -->
        
        <?php include("footer.php"); ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
    </body>
    
</html>