<?php

// PDO statement to fetch the post data
$query = "SELECT * FROM `tasks` WHERE id = :id";
$post_stmt = $con->prepare($query);
