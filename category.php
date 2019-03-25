<?php
    session_start();
    include("connection.php");
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title>Forum - Categories</title>

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
    <?php include("forum_header.php"); ?>
        <div class="container">               
<?php

    //we need the category id to create the page to view a given category
    $sql = "SELECT catID, catName, catDesc FROM categories WHERE catID = '" .  mysqli_real_escape_string($conn, $_GET['id']) . "'";

    $result = mysqli_query($conn, $sql);

    if(!$result){
        echo 'The category could not be displayed. Please try again later.';
        echo mysqli_error($conn);
    }
    else{
        if(mysqli_num_rows($result) == 0){
            echo 'Oops, it seems that this category does not exist.';
        }
        else{
            while($row = mysqli_fetch_assoc($result)){
                echo '<h2>Topic: ' . $row['catName'] . '</h2>';
            }
            
        $sql = "SELECT topicID, topicSubj, topicDate, topicCat FROM topics WHERE topicCat = '" . mysqli_real_escape_string($conn, $_GET['id']) . "'";
        
        $result = mysqli_query($conn, $sql);
            
        if(!$result){
            echo 'The topics could not be displayed. Please try again later.';
        }
        else{
            if(mysqli_num_rows($result) == 0){
                echo 'There are no topics in this category yet. Feel free to create one!';
            }
            else{
                //we have results so we can display them!
                
                //create our table frame
                echo'
                <table class="table table-bordered">
                    <tr>
                        <th>Topic</th>
                        <th>Date Created</th>
                    </tr>';
                
                while($row = mysqli_fetch_assoc($result)){
                echo '<tr>';
                    echo '<td>';
                        echo '<h3><a href="topic.php?id=' . $row['topicID'] . '">' . $row['topicSubj'] . '</a></h3>';
                    echo '</td>';
                    echo '<td>';
                        echo date('M-d-Y', strtotime($row['topicDate']));
                    echo '</td>';
                echo '</tr>';
                }
            }
        }
    }
}

?>
        </div>
    </div>

<!-- keep this at the bottom of the body -->
        <?php //include("footer.php"); ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
    </body>
    
</html>