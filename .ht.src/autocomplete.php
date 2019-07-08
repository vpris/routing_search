<?php

// Database configuration
$dbHost     = '127.0.0.1';
$user = "root";
$pass = "root";
$dbName     = 'tests';

if (file_exists(__DIR__ . 'database/config_local.php')) {
    include __DIR__ . 'database/config_local.php';
}

// Connect with the database
$db = new mysqli($dbHost, $user, $pass, $dbName);

// Get search terms
$searchTerm = $_GET['term'];
$term = "%".$searchTerm."%";
// Get matched data from skills table
$query = $db->query("SELECT DISTINCT title AS title
                            FROM tasks
                            WHERE title LIKE '$term'
                            OR keywords LIKE '$term'
                            OR content LIKE '$term'
                            OR groupsApp LIKE '$term'
                            ORDER BY clicks ASC
                            ");

// Generate skills data array
$skillData = array();
if($query->num_rows > 0){
    while($row = $query->fetch_assoc()){
        $data['id'] = $row['id'];
        $data['value'] = $row['title'];
        $data['keywords'] = $row['keywords'];
        $data['content'] = $row['content'];
        $data['groupsApp'] = $row['groupsApp'];
        array_push($skillData, $data);
    }
}

// Return results as json encoded array
echo json_encode($skillData);