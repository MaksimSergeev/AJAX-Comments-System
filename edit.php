<?php

error_reporting(E_ALL);
require_once('autoload.php');
// update comment
if (isset($_POST["com_id"])) {

        $db = Db::getConnection();
        $db->beginTransaction();
        $stmt = $db->prepare("UPDATE comments SET body = :body WHERE id = :id");
        $stmt->bindParam(':id', $_POST["com_id"]);
        $stmt->bindParam(':body', $_POST["body"]);
        $result = $stmt->execute();


        if (!empty($result)) {
            echo 'Data Updated';
        }
}

