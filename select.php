<?php
error_reporting(E_ALL);
require_once('autoload.php');

if (isset($_POST["com_id"])) {
    
    // select comment for insert to textarea (body) 
    $output = array();
    $db = Db::getConnection();
    $db->beginTransaction();
    $stmt = $db->prepare("SELECT body FROM comments WHERE id = '".$_POST["com_id"]."'");
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach ($result as $row) {
        $output["body"] = $row["body"];
    }
    echo json_encode($output);
}
