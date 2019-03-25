<?php
    //used by the AJAX situation to update the value of a review in review_ratings
    include("connection.php");

    $q = intval($_GET['q']);
    
    $sql = "UPDATE review_ratings SET helpful= helpful + 1 WHERE fk_review_id =" . $q . "";

    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);
?>