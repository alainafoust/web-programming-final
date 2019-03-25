<?php
    include ("connection.php");

    //get the data
    $name = $_GET['name'];
    $desc = $_GET['desc'];

    $type = $_GET['type'];

    $lat = $_GET['lat'];
    $lng = $_GET['lng'];

    $name = mysqli_real_escape_string($conn, $name);
    $desc = mysqli_real_escape_string($conn, $desc);
    
    $type = mysqli_real_escape_string($conn, $type);

    $lat = mysqli_real_escape_string($conn, $lat);
    $lng = mysqli_real_escape_string($conn, $lng);
    
    //save the data by inserting a row in the table
    $sql = "INSERT INTO markers
                (marker_name, description, lat, lng, marker_type)
            VALUES ('". $name ."', '". $desc ."', ". $lat .", ". $lng .", '". $type ."')";

    $result = mysqli_query($conn, $sql);

    if(!$result){
        echo mysqli_error($conn);
    }
    else{
        //echo "PHP File: We did it!";
    }

    mysqli_close($conn);
?>