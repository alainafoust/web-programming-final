<?php

    include("connection.php");

    function parseToXML($htmlStr){
        $xmlStr = str_replace('<','&lt;',$htmlStr);
        $xmlStr = str_replace('>','&gt;',$xmlStr);
        $xmlStr = str_replace('"','&quot;',$xmlStr);
        $xmlStr = str_replace("'",'&#39;',$xmlStr);
        $xmlStr = str_replace("&",'&amp;',$xmlStr);
        return $xmlStr;
    }

    //select our markers
    $sql = "SELECT * FROM markers WHERE 1";
    $result = mysqli_query($conn, $sql);
    if(!$result){
        echo mysqli_error($conn);
    }

    header("Content-type: text/xml");

    //start the XML file
    echo '<markers>';

    //run thru the rows
    while($row = mysqli_fetch_assoc($result)){
        //add the XML document nodes
        echo '<marker ';
        echo 'id="' . $row['marker_id'] . '" ';
        echo 'marker_name="' . parseToXML($row['marker_name']) . '" ';
        echo 'description="' . parseToXML($row['description']) . '" ';
        echo 'lat="' . $row['lat'] . '" ';
        echo 'lng="' . $row['lng'] . '" ';
        echo 'marker_type="' . $row['marker_type'] . '" ';
        echo '/>';
    }
    //end the XML file
    echo '</markers>';

?>