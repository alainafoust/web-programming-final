<?php
    session_start();
    include("connection.php");
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title>Forum - Create Topic</title>

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

    //set errors equal to empty string
    $topicSubjError = "";

    //validating user input                
    // subject line
    if (empty($_POST["topicSubj"])){
        $topicSubjError = "Please enter a topic subject.";
    }
    elseif (!preg_match("/\A[']?[a-zA-Z ]+['-]?[ a-zA-Z]+[']?\Z/",$_POST["topicSubj"])) {
        $topicSubjError = "Please enter a topic subject. Letters and whitespace are permitted.";
    }
    else{
        $topicSubj = test_input($_POST["topicSubj"]);
    }

    //function to sanatize user input
    function test_input($userInput){
        $userInput = filter_var($userInput, FILTER_SANITIZE_STRIPPED);
        $userInput = filter_var($userInput, FILTER_SANITIZE_MAGIC_QUOTES);
        $userInput = filter_var($userInput, FILTER_SANITIZE_SPECIAL_CHARS);
        return $userInput;
    }
    
    echo '<h2>Create a Topic</h2>';
    if($_SESSION['signed_in'] == false){
        //the user is not signed in
        echo 'Sorry, you have to <a href="login.php">signed in</a> to create a topic.';
    }
    else{
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $sql = "SELECT catID, catName, catDesc FROM categories";
            
            $result = mysqli_query($conn, $sql);
            
            if(!$result){
                echo 'Error, please try again later.';
            }
            else{
                if(mysqli_num_rows($result) == 0){
                    if($_SESSION['user_level'] == 1){
                        echo "You have no created categoies yet.";
                    }
                else{
                    echo 'Before you can post a topic, you must wait for admin to create one or more categories.';
                }
                }
                else{
                    echo '<form method="post" action="">
                    
                    <div class="form-group">
                    <label for="topicSubj">Subject: </label> <input type="text" name="topicSubj" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                    <label for="topicCat">Category: </label>';
                    
                    echo '<select class="form-control" name="topicCat" required>';
                        while($row = mysqli_fetch_assoc($result)){
                            echo '<option value="' . $row['catID'] . '">' . $row['catName'] . '</option>';
                        }
                    echo '</select></div>';
                    
                    echo '<div class="form-group">
                    <label for="replyContent">Message:</label> <textarea class="form-control" rows="5" name="replyContent" required></textarea>
                    
                    <br>
                    
                    <input type="submit" class="btn" value="Create Topic" >
                    </div>
                 </form>';
            }
        }
    }
    else
    {
        //start the transaction
        $query  = "BEGIN WORK;";
        $result = mysqli_query($conn, $query);
         
        if(!$result)
        {
            //Query failed, topic not added
            echo 'An error occured while creating your topic. Please try again later.';
        }
        else
        {
     
            //the form has been posted, so save it
            //insert the topic into the topics table first, then save the post into the posts table
            $sql = "INSERT INTO 
                        topics(topicSubj,
                               topicDate,
                               topicCat,
                               topicBy)
                   VALUES('" . mysqli_real_escape_string($conn, $_POST['topicSubj']) . "',
                               NOW(),
                               " . mysqli_real_escape_string($conn, $_POST['topicCat']) . ",
                               " . $_SESSION['user_id'] . "
                               )";
                      
            $result = mysqli_query($conn, $sql);
            if(!$result)
            {
                //something went wrong, display the error
                echo 'An error occured while inserting your data. Please try again later.'; 
                //comment out next line after debugging !!!
                mysqli_error($conn);
                $sql = "ROLLBACK;";
                $result = mysqli_query($conn, $sql);
            }
            else
            {
                //the first query worked, now start the second, posts query
                //retrieve the id of the freshly created topic for usage in the posts query
                $replyID = mysqli_insert_id($conn);
                 
                $sql = "INSERT INTO
                            replies(replyContent,
                                  replyDate,
                                  replyTopic,
                                  replyBy)
                        VALUES
                            ('" . mysqli_real_escape_string($conn, $_POST['replyContent']) . "',
                                  NOW(),
                                  " . $replyID . ",
                                  " . $_SESSION['user_id'] . "
                            )";
                $result = mysqli_query($conn, $sql);
                 
                if(!$result)
                {
                    //something went wrong, display the error
                    echo 'An error occured while inserting your post. Please try again later.' . mysqli_error();
                    $sql = "ROLLBACK;";
                    $result = mysqli_query($conn, $sql);
                }
                else
                {
                    $sql = "COMMIT;";
                    $result = mysqli_query($conn, $sql);
                     
                    //after a lot of work, the query succeeded!
                    echo 'You have successfully created <a href="topic.php?id='. $replyID . '">your new topic</a>.';
                }
            }
        }
    }
}

?>
    </div>
</div>
                    
<!-- keep this at the bottom of the body -->
        <?php include("footer.php"); ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
    </body>
    
</html>