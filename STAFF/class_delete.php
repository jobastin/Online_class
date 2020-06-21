<?php
require('../fun.php');
if (!sessioncheck()) die('invalid authentication');
if (!isset($_GET['id'])) die('invalid parameters');
$id = $_GET['id'];
if (!is_numeric($id)) die('invalid input format');

$con = connect();
$q = ";";
$res = mysqli_query($con, $q) or die("delete class query error");
mysqli_close($con);

if ($res){
    die("delete success");
}
?>