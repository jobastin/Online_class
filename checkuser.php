<?php
//file that makes sure that a username exists in either classdb or staffdb
require('fun.php');
$user = $_GET['user'];
if (preg_match('/^[a-zA-Z0-9]+$/', $user)){
    $con = connect();
    $res = mysqli_query($con, "select * from user where
    username='$user';");
    mysqli_close($con);
    if(mysqli_num_rows($res)){
        echo "true";
    } else {
        echo "false : no such user";
    }
}
else
    echo "false : wrong username format";
?>