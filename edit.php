<?php
error_reporting(E_ALL);
require_once('autoload.php');
if(isset($_POST["com_id"])) {

    $arr["com_id"] = $_POST["com_id"];
    $arr["body"] = $_POST["body"];
    $validates = Comment::validateEdit($arr);
    $arr['dt'] = date("Y-m-d H:i:s");

    if ($validates) {
        // Update comment by id:
        $db = Db::getConnection();
        $db->beginTransaction();
        $stmt = $db->prepare("UPDATE comments SET dt = :dt, body = :body WHERE id = :id");
        $stmt->bindParam(':id', $arr["com_id"]);
        $stmt->bindParam(':body', $arr["body"]);
        $stmt->bindParam(':dt', $arr["dt"]);
        $result = $stmt->execute();

    }
}
else
{
    //Outputting the error messages
    echo '{"status":0,"errors":'.json_encode($arr).'}';
}

