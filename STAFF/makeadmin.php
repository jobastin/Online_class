<?php
require('../fun.php');
if (!sessioncheck() or !$_SESSION['user']->isstaff or !$_SESSION['user']->isadmin) die('invalid authentication');
if (!isset($_POST['staffid']) or !isset($_POST['admin'])) die('invalid parameters');
if (!is_numeric($_POST['staffid'])) die('invalid input format');

$id = $_POST['staffid'];
if ($_POST['admin'] == 'true') $admin = 1; else $admin = 0;

$con = connect();
$q = "update `user` set `isadmin`=$admin where `id`=$id and `isstaff`=1";
$res = mysqli_query($con, $q) or die("administrator query error");
mysqli_close($con);

if ($res){
    die("update success");
}
?>