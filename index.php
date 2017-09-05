<?php
// Error reporting:
error_reporting(E_ALL);
require_once('autoload.php');
//Select all the comments and populate the $comments array with objects
$db = Db::getConnection();
$comments = array();
$result = $db->query("SELECT * FROM comments ORDER BY id ASC");
$result->setFetchMode(PDO::FETCH_ASSOC);

while ($row = $result->fetch()) {
    $comments[] = new Comment($row);
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Commenting</title>
    <link rel="stylesheet" type="text/css" href="styles.css"/>
</head>
<body>
<div class="container" id="main">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <h1 class="title-comment">Leave a comment</h1>
<!--sort-list-->
        <div id="sort-head">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle btn-xs" type="button" data-toggle="dropdown">Sort by:
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a class="name-a" href="#">Name A-Z</a></li>
                    <li><a class="name-d" href="#">Name Z-A</a></li>
                    <li><a class="email-a" href="#">Email A-Z</a></li>
                    <li><a class="email-d" href="#">Email Z-A</a></li>
                    <li><a class="date-a" href="#">Date First</a></li>
                    <li><a class="date-d" href="#">Date Last</a></li>
                </ul>
            </div>
        </div>
<!--sort-list-->
        <div id="content">
            <?php

            //	Output the comments one by one:
            foreach ($comments as $c) {
                echo $c->markup();
            }
            ?>
        </div>
<!--form_add_comment-->
        <div class="form-area" id="addCommentContainer">
            <form role="form" id="addCommentForm" method="post" action="">
                <h3>Add a Comment</h3>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" placeholder="name" class="form-control" id="name"/>
                    <label for="email">Email</label>
                    <input type="text" name="email" placeholder="email" class="form-control" id="email"/>
                    <div class="form-group">
                        <label for="body">Comment</label>
                        <textarea class="form-control" type="textarea" name="body" id="body" placeholder="comment body"
                                  maxlength="140" rows="4"></textarea>
                    </div>
                    <input type="submit" id="submit" name="submit" class="btn btn-primary pull-right" value="Submit"/>
                </div>
            </form>
        </div>
<!--form_add_comment-->
        <div class="col-md-3"></div>
    </div>

<!--modal_edit-->
    <div id="userModal" class="modal fade">
        <div class="modal-dialog">
            <form method="post" id="user_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"></button>
                        <h4 class="modal-title">Edit Comment</h4>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control form2" type="textarea" name="body" id="body"
                                  placeholder="Comment Body" maxlength="140" rows="4"></textarea>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="com_id" id="com_id" value=""/>
                        <input type="submit" name="action" id="action" class="btn btn-primary btn-sm edit"
                               value="Edit"/>
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<!--modal_edit-->

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>

