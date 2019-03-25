<?php
    session_start();
    include("connection.php");
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title>Forum - Create Cateorgy</title>

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
    $catSubjError = "";

    //validating user input                
    // subject line
    if (empty($_POST["catName"])){
        $catSubjError = "Please enter a category name.";
    }
    elseif (!preg_match("/\A[']?[a-zA-Z ]+['-]?[ a-zA-Z]+[']?\Z/",$_POST["catName"])) {
        $catSubjError = "Please enter a category name. Letters and whitespace are permitted.";
    }
    else{
        $catName = test_input($_POST["catName"]);
    }

    //function to sanatize user input
    function test_input($userInput){
        $userInput = filter_var($userInput, FILTER_SANITIZE_STRIPPED);
        $userInput = filter_var($userInput, FILTER_SANITIZE_MAGIC_QUOTES);
        $userInput = filter_var($userInput, FILTER_SANITIZE_SPECIAL_CHARS);
        return $userInput;
    }
    
    echo '<h2>Create a Category</h2>';
    if($_SESSION['signed_in'] == false){
        //the user is not signed in
        echo 'Sorry, you have to <a href="login.php">signed in</a> to create a category.';
    }
    else{
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
                    echo '<form method="post" action="">
                    
                    <div class="form-group">
                    <label for="catName">Category Name: </label> 
                    <input type="text" name="catName" class="form-control" required>
                    </div>';
                
                    echo '<div class="form-group">
                    <label for="catDesc">Category Description:</label> <textarea class="form-control" rows="3" name="catDesc" required></textarea>
                    </div>
                    
                    <br>
                    <div>' echo $catSubjError; '</div>
                    <input type="submit" class="btn" value="Create Category" >
                    </div>
                 </form>';
        }
        
    else{
        //form's posted: insert into categories
        $sql = "INSERT INTO categories (catName, catDesc, catDate) 
                VALUES ('" . mysqli_real_escape_string($conn, $_POST['catName']) . "', '" . mysqli_real_escape_string($conn, $_POST['catDesc']) . "', NOW())";
        $result = mysqli_query($conn, $sql);
        if(!$result){
            //error handling
            echo 'Something went wrong. Please try again later.';
            echo mysqli_error($conn);
        }
        else{
            echo 'New category sucessfully added. <a href="overview.php">Return to the forum overview.</a>';
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