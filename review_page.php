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
    
    <script>
        //function to update helpful value
        function updateHelpful(str){
            if(str == ""){
                return;
            }
            else{
                if (window.XMLHttpRequest){
                    //newer browsers
                    xmlhttp = new XMLHttpRequest();
                }
                else{
                    //older browsers
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function(){
                    if (this.readyState == 4 && this.status == 200){
                        alert("Update initiated!");
                        //$(this).addClass('disabled');
                    }
                };
                //send the review id to the php file
                xmlhttp.open("GET", "helpful.php?q="+str, true);
                xmlhttp.send();
            }

        }
        
        //function that changes the way the reviews are sorted
        function sortReviews(sort_id, plant_id, plant_name){
            //get the plant id and name in question via hidden inputs
                //might not be the best way to do this, but it works...
            plant_id = document.getElementById("hidden_id").value;
            plant_name = document.getElementById("hidden_name").value;
            //document.write(plant_id);
            
            if(sort_id == "" && plant_id == ""){
                document.getElementById("reviews").innerHTML = "";
                return;
            }
            else{
                if (window.XMLHttpRequest){
                    //newer browsers
                    xmlhttp_rev = new XMLHttpRequest();
                }
                else{
                    //older browsers
                    xmlhttp_rev = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp_rev.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200){
                        document.getElementById("reviews").innerHTML = this.responseText;
                    }
                };
                //send the above values and the sort id via the select box values to the php file
                xmlhttp_rev.open("GET", "get_reviews.php?p=" + plant_id + "&r=" + sort_id + "&n=" + plant_name, true);
                xmlhttp_rev.send();
            }
        }

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
                    
    <!-- BEGIN PLANT INFO -->
    <div class="container-fluid">
    
    <?php
            
        //get the data we need from the plants table
        $plants_sql = "SELECT plant_id, plant_name, plant_desc, plant_type FROM plants WHERE plant_id='" . mysqli_real_escape_string($conn, $_GET['id']) . "'";
        //run the query
        $plants_res = mysqli_query($conn, $plants_sql);

        //error handling
        if(!$plants_res){
            echo "This page's content cannot be displayed. Please try again later.";
            //echo mysqli_error($conn);
        }
        else{
            if(mysqli_num_rows($plants_res) == 0){
                echo "The plant's info could not be displayed. Please try again later.";
                //echo mysqli_error($conn);
            }
            //else: there is a result so let's do something with it
            else{
                
                while($p_row = mysqli_fetch_assoc($plants_res)){
                    $avg = "SELECT ROUND(AVG(rating), 0) as avg FROM reviews WHERE fk_plant_id='" . mysqli_real_escape_string($conn, $_GET['id']) . "'";
                    $avg_res = mysqli_query($conn, $avg);
                    
                    while($avg_row = mysqli_fetch_assoc($avg_res)){
                        
                    //trying for AJAX:
                    echo '<input type="hidden" name="plant_id" id="hidden_id" value="' . $p_row['plant_id'] . '">';
                    echo '<input type="hidden" name="plant_id" id="hidden_name" value="' . $p_row['plant_name'] . '">';
                    
                    echo '<div class="container">';
                    
                    echo '<h2>' . $p_row['plant_name'] . ' Reviews</h2>';
                    
                    echo '<hr>';
                    
                    echo 'Plant Type: ' . $p_row['plant_type'];
                    
                    echo '<br> <br>';
                    
                    echo 'Description: ' . $p_row['plant_desc'];
                        
                    echo '<br> <br>';
                        
                    echo 'Average Rating: ' . $avg_row['avg'];
                    
                    echo '<h3>Reviews: </h3>';
                    
                    echo '<div class="form-group">
                            <label for="sortBy">Sort By: </label>
                            <select id="sortBy" class="form-control selectpicker" onload="sortReviewsLoad(this.value, ' . $p_row['plant_id'] . ')" onchange="sortReviews(this.value,'.$p_row['plant_id'].')">
                                <option value="1" selected>Newest First</option>
                                <option value="2">Oldest First</option>
                                <option value="3">Most Helpful to Least Helpful</option>
                                <option value="4">Least Helpful to Most Helpful</option>
                            </select>
                        </div>';
                    
                    echo '<div id="reviews">';
                    
                        //testing as innerHTML default
                        //newest first
                        $sql = "SELECT review_id, fk_plant_id, rating, review, fk_reviewer_name, review_date FROM reviews WHERE fk_plant_id='" . mysqli_real_escape_string($conn, $_GET['id']) . "' ORDER BY review_date DESC";

                        $result = mysqli_query($conn, $sql);

                        //error handling
                        if(!$result){
                            echo "The review content cannot be displayed. Please try again later.";
                            //echo mysqli_error($conn);
                        }
                        else{
                            if(mysqli_num_rows($result) == 0){
                                echo 'It looks like no one has reviewed this plant yet. <a href="new_review.php?id=' . $p_row['plant_id'] . '">However, you could be the first to do so!</a>';
                                //echo mysqli_error($conn);
                            }
                            //else: there is a result so let's do something with it
                            else{

                                while($row = mysqli_fetch_assoc($result)){
                                    echo '<div class="panel panel-default">';
                                        echo '<div class="panel-heading">
                                                    By: ' . $row['fk_reviewer_name'] . '
                                                    <br> Date: ' . $row['review_date'] . '
                                                    <br> Rating: ' . $row['rating'] . '
                                                </div>';
                                        echo '<div class="panel-body">' . $row['review'] . '</div>';

                                        echo '<div class="panel-footer">
                                                    Was this review helpful? <button type="button" class="btn btn-success btn-xs" value="' . $row['review_id'] . '" onclick="updateHelpful(this.value)">Yes</button>
                                                </div>';
                                    //close the individual review container
                                    echo '</div>';
                                }
                                echo '<a href="new_review.php?id=' . mysqli_real_escape_string($conn, $_GET['id']) . '" type="button" class="btn btn-default" role="button">Write A Review for ' . $p_row['plant_name'] . '</a>';
                            }
                        }
                    echo '</div>';
                    
                    echo '</div>'; 
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