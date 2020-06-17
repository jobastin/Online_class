<?php
//file that makes sure that a username exists in either classdb or staffdb
require('fun.php');
$user = $_GET['user'];
if (preg_match('/^[a-zA-Z0-9]+$/', $user)){
    $res = mysqli_query(connect(), "select * from user where username='$user';");
    if(mysqli_num_rows($res)){
        echo "true";
    } else {
        echo "false : no such user";
    }
}
else
    echo "false : wrong username format";
?>