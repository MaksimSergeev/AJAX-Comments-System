<?php
error_reporting(E_ALL);
require_once('autoload.php');

$arr = array();
$validates = Comment::validate($arr);

if($validates) {
	
	//Insert to database
    $db = Db::getConnection();
    $db -> beginTransaction();
    $stmt = $db -> prepare("INSERT INTO comments (name, email, body) VALUES (:name, :email, :body)");
    $stmt -> bindParam(':name', $arr['name']);
    $stmt -> bindParam(':email', $arr['email']);
    $stmt -> bindParam(':body', $arr['body']);
    $stmt -> execute();

	$arr['dt'] = date('r',time());
	$arr['id'] = $db->lastInsertId();

	//stripslashes to all the elements in the array
	$arr = array_map('stripslashes',$arr);
	$insertedComment = new Comment($arr);

	// Outputting the markup of the just-inserted comment
	echo json_encode(array('status'=>1,'html'=>$insertedComment -> markup()));

}
else
{
	//Outputting the error messages
	echo '{"status":0,"errors":'.json_encode($arr).'}';
}
