<?php
//file that makes sure that a username exists in either classdb or staffdb
require('fun.php');
$user = $_GET['user'];
if (preg_match('/^[a-zA-Z0-9]+$/', $user))
    echo $user." true";///////////////////////////////////////////////////
else
    echo "false";
?>