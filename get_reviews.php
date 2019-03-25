<?php
    //used by the AJAX situation to sort reviews
    include("connection.php");

    //the sort value, the plant id, and plant name respectively
    $r = intval($_GET['r']);
    $p = intval($_GET['p']);
    $n = $_GET['n'];

    //echo '$r =' . $r;
    //echo '$p =' . $p;

    if($r == 1){
        //newest first
        $sql = "SELECT review_id, fk_plant_id, rating, review, fk_reviewer_name, review_date FROM reviews WHERE fk_plant_id='" . $p . "' ORDER BY review_date DESC";
        
        $result = mysqli_query($conn, $sql);
        
        //error handling
        if(!$result){
            echo "The review content cannot be displayed. Please try again later.";
            //echo mysqli_error($conn);
        }
        else{
            if(mysqli_num_rows($result) == 0){
                echo 'It looks like no one has reviewed this plant yet. <a href="new_review.php?id=' . $p . '">However, you could be the first to do so!</a>';
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
                echo '<a href="new_review.php?id=' . $p . '" type="button" class="btn btn-default" role="button">Write A Review for ' . $n . '</a>';
            }
        }
    }
    elseif($r == 2){
        //oldest first
        $sql = "SELECT review_id, fk_plant_id, rating, review, fk_reviewer_name, review_date FROM reviews WHERE fk_plant_id='" . $p . "' ORDER BY review_date ASC";
        
        $result = mysqli_query($conn, $sql);
        
        //error handling
        if(!$result){
            echo "The review content cannot be displayed. Please try again later.";
            //echo mysqli_error($conn);
        }
        else{
            if(mysqli_num_rows($result) == 0){
                echo 'It looks like no one has reviewed this plant yet. <a href="new_review.php?id=' . $p . '">However, you could be the first to do so!</a>';
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
                echo '<a href="new_review.php?id=' . $p . '" type="button" class="btn btn-default" role="button">Write A Review for ' . $n . '</a>';
            }
        }
    }

    elseif($r == 3){
        //most to least helpful
        $sql = "SELECT helpful AS h, review_id, fk_plant_id, rating, review, fk_reviewer_name, review_date FROM reviews INNER JOIN review_ratings ON (reviews.review_id=review_ratings.fk_review_id) WHERE fk_plant_id='" . $p . "' ORDER BY h DESC";
        
        $result = mysqli_query($conn, $sql);
        
        //error handling
        if(!$result){
            echo "The review content cannot be displayed. Please try again later.";
            //echo mysqli_error($conn);
        }
        else{
            if(mysqli_num_rows($result) == 0){
                echo 'It looks like no one has reviewed this plant yet. <a href="new_review.php?id=' . $p . '">However, you could be the first to do so!</a>';
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
                                    <br> How many times marked helpful: ' . $row['h'] .
                                    '
                                </div>';
                        echo '<div class="panel-body">' . $row['review'] . '</div>';

                        echo '<div class="panel-footer">
                                    Was this review helpful? <button type="button" class="btn btn-success btn-xs" value="' . $row['review_id'] . '" onclick="updateHelpful(this.value)">Yes</button>
                                </div>';
                    //close the individual review container
                    echo '</div>';
                }
                echo '<a href="new_review.php?id=' . $p . '" type="button" class="btn btn-default" role="button">Write A Review for ' . $n . '</a>';
            }
        }
    }
    elseif($r == 4){
        //least to most helpful
        $sql = "SELECT helpful AS h, review_id, fk_plant_id, rating, review, fk_reviewer_name, review_date FROM reviews INNER JOIN review_ratings ON (reviews.review_id=review_ratings.fk_review_id) WHERE fk_plant_id='" . $p . "' ORDER BY h ASC";
        
        $result = mysqli_query($conn, $sql);
        
        //error handling
        if(!$result){
            echo "The review content cannot be displayed. Please try again later.";
            //echo mysqli_error($conn);
        }
        else{
            if(mysqli_num_rows($result) == 0){
                echo 'It looks like no one has reviewed this plant yet. <a href="new_review.php?id=' . $p . '">However, you could be the first to do so!</a>';
                //echo mysqli_error($conn);
            }
            //else: there is a result so let's do something with it
            else{
        
                while($row = mysqli_fetch_assoc($result)){
                    echo '<div class="panel panel-default">';
                        echo '<div class="panel-heading">
                                    By: ' . $row['fk_reviewer_name'] . '
                                    <br> Date: ' . $row['review_date'] . '
                                    <br> Rating: ' . $row['rating'] . 
                                    '
                                    <br> How many times marked helpful: ' . $row['h'] .
                                    '
                                </div>';
                        echo '<div class="panel-body">' . $row['review'] . '</div>';

                        echo '<div class="panel-footer">
                                    Was this review helpful? <button type="button" class="btn btn-success btn-xs" value="' . $row['review_id'] . '" onclick="updateHelpful(this.value)">Yes</button>
                                </div>';
                    //close the individual review container
                    echo '</div>';
                }
                echo '<a href="new_review.php?id=' . $p . '" type="button" class="btn btn-default" role="button">Write A Review for ' . $n . '</a>';
            }
        }
    }

    mysqli_close($conn);
?>