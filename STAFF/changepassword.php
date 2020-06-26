<?php
require('../fun.php');
if (!sessioncheck() or !$_SESSION['user']->isstaff) die('invalid authentication');
if (!isset($_POST['setpasswordto']) or !isset($_POST['staffid']) or !isset($_POST['oldpassword'])) die('invalid parameters');
if (!is_numeric($_POST['staffid'])) die("invalid input format");

$id = $_POST['staffid'];
$newpass = $_POST['setpasswordto'];
$oldpass = $_POST['oldpassword'];

//sterilize input?

$con = connect();
$q1 = "select * from `user` where `id`=$id and `password`='".mysqli_real_escape_string($con, $oldpass)."'";
$q2 = "update `user` set `password`='".mysqli_real_escape_string($con, $newpass)."' where `id`=$id and `isstaff`=1";
$res1 = mysqli_query($con, $q1) or die("Fetch Error");

if ($res1){
    if (mysqli_num_rows($res1) == 1){
        $res2 = mysqli_query($con, $q2) or die("Password Change Error");
        if ($res2){
            die("password change success");
        }
    } else {
        die ("wrong password");
    }
}
//if (!isset($_POST[]))