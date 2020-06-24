<?php
require('../fun.php');
if (!sessioncheck() or !$_SESSION['user']->isstaff) die('invalid authentication');
if (!isset($_POST['subjectname']) or !isset($_POST['id']) or !is_numeric($_POST['id'])) die('invalide parameters');

//sterilize input?
$subject = $_POST['subjectname'];
$id = $_POST['id'];

$con = connect();
$q0 = "update `subj` set `subjectname`='".mysqli_real_escape_string($con, $subject)."' where `id`=$id";
$res0 = mysqli_query($con, $q0) or die("unable to connect to DB");
mysqli_close($con);
if ($res0) die("subject edit success<br>".$subject);

?>