<?php
error_reporting(E_ALL);
require_once('autoload.php');

if (isset($_POST["sort_id"])) {

    $db = Db::getConnection();
    $query = "SELECT * FROM comments ORDER BY ";
    
    //switch key for query:
    switch ($_POST["sort_id"]) {
        case 'Name A-Z': $query .= "name ASC";
            break;
        case 'Name Z-A': $query .= "name DESC";
            break;
        case 'Email A-Z': $query .= "email ASC";
            break;
        case 'Email Z-A': $query .= "email DESC";
            break;
        case 'Date First': $query .= "dt ASC";
            break;
        case 'Date Last': $query .= "dt DESC";
            break;
    }

    $stmt = $db->query($query);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);


    while ($row = $stmt->fetch()) {
        $comments[] = new Comment($row);
    }
    if(isset($comments)) {
    	
        //Output comments
        foreach ($comments as $c) {
            echo $c -> markup();
        }
    }

}