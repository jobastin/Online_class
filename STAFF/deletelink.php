<?php
require('../fun.php');
if (!sessioncheck()) die('invalid authentication');
if (!isset($_GET['id'])) die('invalid parameters');
$id = $_GET['id'];
if (!is_numeric($id)) die('invalid input format');

$con = connect();
$q = "delete from `vids` where `id` = $id";
$res = mysqli_query($con, $q) or die("delete link query error");
mysqli_close($con);

if ($res){
    die("delete success");
}

?>$