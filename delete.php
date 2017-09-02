<?php
error_reporting(E_ALL);
require_once('autoload.php');

if(isset($_POST["com_id"]))
{
    $db = Db::getConnection();
    $db -> beginTransaction();
    $stmt = $db->prepare("DELETE FROM comments WHERE id = :id");
    $stmt -> bindParam(':id', $_POST["com_id"]);

    $result = $stmt->execute();
}

