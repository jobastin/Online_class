<?php
require('../fun.php');
if (!sessioncheck() or !$_SESSION['user']->isstaff) die('invalid authentication');
if (!isset($_GET['delete_id'])) die('invalid parameters');
$id = $_GET['delete_id'];
if (!is_numeric($id)) die('invalid input format');

$con = connect();
$q = "delete from `user` where `id` = $id";
$res = mysqli_query($con, $q) or die("delete class query error");
if ($res) mysqli_query($con, "delete from `clas` where `user_id`=$id");
mysqli_close($con);

if ($res){
    die("delete success");
}
?>