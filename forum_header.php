<ul class="nav nav-pills">
    <li><a class="item" href="overview.php">Forum Overview</a></li> 
    <li><a class="item" href="create_topic.php">Create a topic</a></li>
    <li><a class="item" href="messages.php">Messages</a></li>

<?php
//only display the category creation page if the user is admin
    if($_SESSION['user_level'] == 1){
        echo '<li><a href="create_cat.php">Create a category</a></li>
        </ul>';
    }
    else{
        echo '</ul>';
    }
?>