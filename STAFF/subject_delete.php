<?php
require('../fun.php');
if (!sessioncheck() or !$_SESSION['user']->isstaff) die('invalid authentication');
if (!isset($_GET['deleteid'])) die('invalid parameters');
$id = $_GET['deleteid'];
if (!is_numeric($id)) die('invalid input format');

$con = connect();
$q0 = "delete from `subj` where `id`=$id";
$q1 = "delete from `clas` where `subj_id`=$id";
$res0 = mysqli_query($con, $q0) or die("Unable to delete");
$res1 = mysqli_query($con, $q1);
mysqli_close($con);

if ($res0) 
    if ($res1) die("delete success");
    else die("delete success, but files may be corrupt")
?>