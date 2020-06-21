<?php 
require('../fun.php');
if (!sessioncheck()) die('invalid authentication');
if (!isset($_POST['chapter']) or !isset($_POST['title']) or !isset($_POST['link']) or !isset($_POST['id'])) die('invalid parameters');

$chapter = $_POST['chapter'];
$title = $_POST['title'];
$link = $_POST['link'];
$id = $_POST['id'];

//sterilize input?

$con = connect();
$q = "update `vids` set title='$title', link='$link', chapter=$chapter where id=$id";
$res = mysqli_query($con, $q) or die("edit link query error");
mysqli_close($con);

if ($res){
    die("edit success<br>".$title."<br>".$chapter."<br>".$link);
}
?>