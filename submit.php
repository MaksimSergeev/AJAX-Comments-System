<?php

// Error reporting:
error_reporting(E_ALL);
require_once('autoload.php');

/*
/	This array is going to be populated with either
/	the data that was sent to the script, or the
/	error messages.
/*/

$arr = array();
$validates = Comment::validate($arr);

if($validates)
{
	/* Everything is OK, insert to database: */
    $db = Db::getConnection();
    $db -> beginTransaction();
    $stmt = $db -> prepare("INSERT INTO comments (name, email, body) VALUES (:name, :email, :body)");
    $stmt -> bindParam(':name', $arr['name']);
    $stmt -> bindParam(':email', $arr['email']);
    $stmt -> bindParam(':body', $arr['body']);
    $stmt -> execute();

	$arr['dt'] = date('r',time());
	$arr['id'] = $db -> lastInsertId();

	/*
	/	The data in $arr is escaped for the query,
	/	but we need the unescaped variables, so we apply,
	/	stripslashes to all the elements in the array:
	*/
	
	$arr = array_map('stripslashes',$arr);
	
	$insertedComment = new Comment($arr);

	/* Outputting the markup of the just-inserted comment: */

	echo json_encode(array('status'=>1,'html'=>$insertedComment -> markup()));

}
else
{
	/* Outputtng the error messages */
	echo '{"status":0,"errors":'.json_encode($arr).'}';
}

?>