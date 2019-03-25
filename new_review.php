<?php
    session_start();
    include("connection.php");
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title>Create a New Review</title>

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
                                           
        <?php
                
            //set errors to empty string
            $rating_error = $review_error = "";
                    
            //validating user input 
            if ($_SERVER["REQUEST_METHOD"] == "POST"){               
                
                //review rating
                if (empty($_POST["rating"])){
                    $rating_error = "Please enter a rating.";
                }
                elseif (!preg_match("/\A[1-5]{1}\Z/", $_POST["rating"])) {
                        $review_error = "Please enter a valid rating.";
                }
                else{
                    $rating = test_input($_POST["rating"]);
                }

                //review textarea
                    if (empty($_POST["review"])){
                        $review_error = "Please enter your review.";
                    }
                    elseif (!preg_match("/\A[a-zA-Z ]+(.)*\Z/",$_POST["review"])) {
                        $review_error = "Please enter a valid review.";
                    }
                    else{
                        $review = test_input($_POST["review"]);
                    }
            }
                
            //function to sanatize user input
            function test_input($userInput){
                $userInput = filter_var($userInput, FILTER_SANITIZE_STRIPPED);
                $userInput = filter_var($userInput, FILTER_SANITIZE_MAGIC_QUOTES);
                $userInput = filter_var($userInput, FILTER_SANITIZE_SPECIAL_CHARS);
                return $userInput;
            }
                
                if($_SESSION['signed_in'] == false){
                //have the user log in to make a review
                echo 'You must be <a href="final_login.php">logged in</a> to write a review.';
                }
                else{
                if($_SERVER['REQUEST_METHOD'] != 'POST'){
                    
                    $new_sql = "SELECT plant_id, plant_name, plant_type FROM plants WHERE plant_id='" . mysqli_real_escape_string($conn, $_GET['id']) . "'";

                    $new_res = mysqli_query($conn, $new_sql);

                    //error handling
                    if(!$new_res){
                        echo "This page's content cannot be displayed. Please try again later.";
                        //echo mysqli_error($conn);
                    }
                    else{
                        if(mysqli_num_rows($new_res) == 0){
                            echo "The plant's info could not be displayed. Please try again later.";
                            //echo mysqli_error($conn);
                        }
                        //else: there is a result so let's do something with it
                        else{
                            while($new_row = mysqli_fetch_assoc($new_res)){

                            echo'<div class="container-fluid">
                                    <form action="" method="post" accept-charset="utf-8">
                                        <fieldset><legend>Write a Review for ' . $new_row['plant_name'] . '</legend>	
                                            <p>
                                                <label for="rating">Rating</label>
                                                <input type="radio" name="rating" value="1" / required> 1 
                                                <input type="radio" name="rating" value="2" /> 2
                                                <input type="radio" name="rating" value="3" /> 3 
                                                <input type="radio" name="rating" value="4" /> 4 
                                                <input type="radio" name="rating" value="5" /> 5
                                            </p>
                                            <span class = "error"> '. $rating_error .'</span>
                                            <p><label for="review">Review</label>
                                                <textarea name="review" class="form-control" rows="8" cols="3" required></textarea>
                                            </p>
                                            <span class = "error"> '. $review_error .'</span>
                                            <p>
                                                <input type="submit" class="btn btn-default" value="Submit Review">
                                            </p>
                                        </fieldset>
                                    </form>
                                </div>';
                            }
                        }
                    }
                }
                else{
                    
                    //we need a few pieces of info from the plants table:
                    $new_sql = "SELECT plant_id, plant_name, plant_type FROM plants WHERE plant_id='" . mysqli_real_escape_string($conn, $_GET['id']) . "'";

                    $new_res = mysqli_query($conn, $new_sql);
                    $new_row = mysqli_fetch_assoc($new_res);
                    
                    //start our INSERT work
                    $query = "BEGIN WORK;";
                    $result = mysqli_query($conn, $query);
                    
                    if(!$result){
                        //begin transaction failed, show error
                        echo 'An error occured while saving your review. Please try again later.';
                    }
                    else{
                        //we're good to start, save into the reviews table first
                        $sql = "INSERT INTO
                                    reviews (
                                        fk_plant_id,
                                        fk_plant_type,
                                        rating, 
                                        review, 
                                        fk_reviewer_name, 
                                        review_date) 

                                    VALUES (
                                        '" . $new_row['plant_id'] . "',
                                        '" . $new_row['plant_type'] . "',
                                        '" . mysqli_real_escape_string($conn, $_POST['rating']) . "', 
                                        '" . mysqli_real_escape_string($conn, $_POST['review']) . "', 
                                        '" . $_SESSION['user_name'] ."', 
                                        NOW()
                                    )";
                        $result = mysqli_query($conn, $sql);
                        if(!$result){
                            //error msg
                            echo '*** An error occured while saving your review, please try again later. ***';
                            
                            //mysqli_error($conn)
                            //so, we stop the transaction on the db w/ rollback
                            $sql = "ROLLBACK;";
                            $result = mysqli_query($conn, $sql);
                        }
                        else{
                            //first query on reviews worked, now we go for review_ratings
                            
                            //NOTE: NOW() may not be the best choice for fk_review_date as I'm not sure that both queries will have the same time...but it's not super important so I'll test it as such for now
                            
                            //an easy enough way to retrieve the id of the newly created review to use in the review_ratings table:
                            $reviewID = mysqli_insert_id($conn);
                            
                            $sql = "INSERT INTO
                                        review_ratings(
                                            fk_review_id,
                                            helpful, 
                                            fk_review_date
                                        )
                                    VALUES(
                                        '" . $reviewID . "',
                                        0,
                                        NOW()
                                    )";
                            $result = mysqli_query($conn, $sql);
                            
                            if(!$result){
                                //error msg and same as above, don't run the query, rollback
                                echo 'An error occurred. Please try again later.';
                                //mysqli_error($conn);
                                $sql = "ROLLBACK;";
                                $result = mysqli_query($conn, $sql);   
                            }
                            else{
                                //else, we're going for it!
                                $sql = "COMMIT;";
                                $result = mysqli_query($conn, $sql);
                                
                                //all's good, let's let the user know
                                echo 'Review successfully added! View it <a href="review_page.php?id=' . $new_row['plant_id'] . '">here</a>.';
                                
                            }
                        }
                    }
                }
            }
            mysqli_close($conn);
        ?>
                    
<!-- keep this at the bottom of the body -->
        
        <?php include("footer.php"); ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
    </body>
    
</html>