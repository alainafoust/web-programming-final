<?php
//create the connection
                $host = "";
                $user = "root";
                $password = "";
                $dbname = "plants_db";

                //connect
                $conn = mysqli_connect($host, $user, $password, $dbname) or die("Unable to connect to $host");

                //check connection
                if(mysqli_connect_errno()){
                    echo "Failed to connect to db: " . mysqli_connect_error();
                }
?>