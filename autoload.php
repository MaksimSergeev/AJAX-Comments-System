<?php

function __autoload($class_name)
{
        $filename = "./" . $class_name . ".php";
        if (is_file($filename)) {
            include_once $filename;
        }
}