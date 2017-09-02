<?php

class Comment
{
    private $data = array();

    public function __construct($row)
    {
        $this->data = $row;
    }

    //	This method outputs the XHTML markup of the comment
    public function markup()
    {
        // Setting up an alias, so we don't have to write $this->data every time:
        $d = &$this->data;

        // Converting the time to a UNIX timestamp:
        $d['dt'] = strtotime($d['dt']);

        // Create comment div block
        return '
			    <div class="comment" id="d' . $d['id'] . '"> 
				    <div class="name">' . $d['name'] . '</div>
				    <div class="date">' . date('H:i:s \o\n d M Y', $d['dt']) . '</div>
				    <div class="body">' . $d['body'] . '</div>
				    <div align="right">
                        <button type="button" id="' . $d['id'] . '" data-toggle="modal" name="edit" data-target="#userModal" class="btn btn-primary btn-xs pull-right edit">Edit</button>
                    </div>
                    <div align="right">
                        <button type="button" id="' . $d['id'] . '" name="delete" class="btn btn-primary btn-xs pull-right del">Del</button>
                    </div>
			    </div>
		';
    }

    // This method is used to validate the data sent via AJAX.
    public static function validate(&$arr)
    {

        $errors = array();
        $data = array();

        // Using the filter_input function
        if (!($data['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))) {
            $errors['email'] = '  Please enter a valid Email!';
        }

        // Using the filter with a custom callback function:
        if (!($data['body'] = filter_input(INPUT_POST, 'body', FILTER_CALLBACK, array('options' => 'Comment::validate_text')))) {
            $errors['body'] = '  Please enter a comment body!';
        }

        if (!($data['name'] = filter_input(INPUT_POST, 'name', FILTER_CALLBACK, array('options' => 'Comment::validate_text')))) {
            $errors['name'] = '  Please enter a name!';
        }

        if (!empty($errors)) {
            // If there are errors, copy the $errors array to $arr:
            $arr = $errors;
            return false;
        }

        // If the data is valid, sanitize all the data and copy it to $arr:
        foreach ($data as $k => $v) {
            $arr[$k] = $v;
        }

        // Ensure that the email is lower case:
        $arr['email'] = strtolower(trim($arr['email']));

        return true;
    }

    //	This method is used internally as a FILTER_CALLBACK
    private static function validate_text($str)
    {
        if (mb_strlen($str, 'utf8') < 1)
            return false;

        // Encode all html special characters (<, >, ", & .. etc) and convert
        // the new line characters to <br> tags:
        $str = nl2br(htmlspecialchars($str));

        // Remove the new line characters that are left
        $str = str_replace(array(chr(10), chr(13)), '', $str);

        return $str;
    }
}

?>