<?php
require('../fun.php');
if (!sessioncheck() or !$_SESSION['user']->isstaff or !$_SESSION['user']->isadmin) die('invalid authentication');
if (!isset($_POST['resetpasswordto']) or !isset($_POST['staffid'])) die ('invalid parameters');
if (!is_numeric($_POST['staffid'])) die("invalid input format");

$id = $_POST['staffid'];
$pass = $_POST['resetpasswordto'];

//sterilize input?

$con = connect();
$q = "update `user` set `password`='".mysqli_real_escape_string($con, $pass)."' where `id`=$id and `isstaff`=1";
$res = mysqli_query($con, $q) or die("reset query error");
mysqli_close($con);

if ($res){
    die("reset success");
}
?>