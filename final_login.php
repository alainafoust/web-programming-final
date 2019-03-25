<?php
    session_start();
    include("connection.php");
    
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title>Login</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    
    <link rel="stylesheet" type="text/css" href="css/css.css">

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
                            <li><a href="#">Plant Reviews</a></li>
                            <li><a href="map.php">Interactive Map</a></li>
                        </ul>
                        <?php
                            if($_SESSION['signed_in'] == false){
                                //show the navbar Login and Register links
                                echo '<ul class="nav navbar-nav navbar-right">
                                    <li><a href=""><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                                    
                                    <li><div class="ar login_popup"><a class="button btn" href="#login"><span class="glyphicon glyphicon-log-in"></span> Log In</a></div></li>
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
        
    <!-- BEGIN LOGIN SCRIPT -->        
        
        <?php
        
            //set errors to empty string
            $user_nameError = $user_passError = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST"){
            //validating user input                
            // username
            if (empty($_POST["user_name"])){
                $user_nameError = "Please enter your username.";
            }
            elseif (!preg_match("/\A[a-zA-Z\d]+[_]*[a-zA-Z\d]+\Z/",$_POST["user_name"])) {
                $user_nameError = "Please enter a valid username.";
            }
            else{
                $user_name = test_input($_POST["user_name"]);
            }

            //password
                if (empty($_POST["user_pass"])){
                    $user_passError = "Please enter your password.";
                }
                elseif (!preg_match("/\A(?=.*[a-zA-Z].*)\S{4,18}\Z/",$_POST["user_pass"])) {
                    $user_passError = "Please enter a valid password.";
                }
                else{
                    $user_pass = test_input($_POST["user_pass"]);
                }
            }

            //function to sanatize user input
            function test_input($userInput){
                $userInput = filter_var($userInput, FILTER_SANITIZE_STRIPPED);
                $userInput = filter_var($userInput, FILTER_SANITIZE_MAGIC_QUOTES);
                $userInput = filter_var($userInput, FILTER_SANITIZE_SPECIAL_CHARS);
                return $userInput;
            }

            if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true){
                echo 'You are already signed in, you can <a href="final_logout.php">sign out</a> if you like.';
            }
            else{
            if($_SERVER['REQUEST_METHOD'] != "POST"){
                echo '      <div class="container">
                                <h2>Sign In</h2>
                                    <form method="post" action="">
                                        <div class="form-group">
                                            <label for="user_name">Username:</label>
                                            <input class="form-control" name="user_name" type="text" required>
                                            <span class = "error"> '. $user_nameError .'</span>
                                        </div>

                                        <div class="form-group">
                                            <label for="user_pass"> Password: </label>
                                            <input class="form-control" name="user_pass" type="password" required>
                                            <span class = "error"> '. $user_passError .'</span>
                                        </div>

                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </form>         
                            </div>';
            }
            else{
                $errors = array();

                if(!isset($_POST['user_name'])){
                    $errors[] = 'Please enter your username.';
                }
                if(!isset($_POST['user_pass'])){
                    $errors[] = 'Please enter your password.';
                }
                if(!empty($errors)){
                    echo "Some of the fields are filled in incorrectly: ";
                    echo "<ul>";
                    foreach($errors as $key => $value){
                        echo "<li>" . $value . "</li>";
                    }
                    echo "</ul>";
                }
                else{
                    $sql = "SELECT user_id, user_name, user_level 
                    FROM users 
                    WHERE user_name = '" . mysqli_real_escape_string($conn, $_POST['user_name']) . "' 
                    AND user_pass = sha1('" . $_POST['user_pass'] . "')";

                    $result = mysqli_query($conn, $sql);
                    if(!$result){
                        //there's no results, so we need to display an error
                        echo "Oops, something went wrong. Please try again later.";
                        echo mysqli_error($conn);
                    }
                    else{
                        if(mysqli_num_rows($result) == 0){
                            echo "Wrong username or password. Please try again.";
                        }
                        else{
                            //set session variables!
                            $_SESSION['signed_in'] = true;

                            while($row = mysqli_fetch_assoc($result)){
                                $_SESSION['user_id'] = $row['user_id'];
                                $_SESSION['user_name'] = $row['user_name'];
                                $_SESSION['user_level'] = $row['user_level'];
                            }
                            echo 'Welcome, ' . $_SESSION['user_name'] . '!';
                            header('Location: final_home.php' );
                        }
                    }
                }
            }
        }

        ?>
    <!-- END LOGIN SCRIPT -->
                        
    <!-- keep this at the bottom of the body -->
    <?php include("footer.php"); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
              
    </body>
</html>