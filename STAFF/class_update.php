<?php
require ('../fun.php');
if (!sessioncheck() or !$_SESSION['user']->isstaff) die('invalid authentication');
if (!isset($_POST['classname']) or !isset($_POST['password']) or !isset($_POST['subjects']) or !isset($_POST['id'])) die ('invalid parameters');

$classname = $_POST['classname'];
$password = $_POST['password'];
$newsubjects = explode(",", $_POST['subjects']);
$oldsubjects = array();
$userid = $_POST['id'];

//sterilize input?

//echo "\"";
//print_r($subjects);
//echo "\"";
//die();

$q0 = "update `user` set `username`='$classname', `password`='$password' where `id`=$userid and `isstaff`=0";
$q1 = "select `subj_id` from `clas` where `user_id`=$userid";
$q2 = "delete from `clas` where ";
$q3 = "insert into `clas` values ";

$con = connect();
$res0 = mysqli_query($con, $q0) or die("unable to connect");

$res1 = mysqli_query($con, $q1) or die("subjects error");
while ($row = mysqli_fetch_array($res1))
    array_push($oldsubjects, $row['subj_id']);
$deletesubs = array_diff($oldsubjects, $newsubjects);
$addsubs = array_diff($newsubjects, $oldsubjects);

foreach($deletesubs as $sub)
    $q2 .= "(`user_id`=$userid and `subj_id`=$sub) or ";
$q2 .= "0";
foreach($addsubs as $sub)
    $q3 .= "(NULL, $userid, $sub), ";
$q3 = rtrim($q3, ", ");

if ($res0) echo("class edit success<br>$classname<br>$password<br>'");

foreach (array_merge($addsubs, array_diff($oldsubjects, $deletesubs)) as $sub) echo "$sub,"; echo "'";
if (sizeof($deletesubs)!=0){
    $res2 = mysqli_query($con, $q2);
    if (!$res2) echo("<br>unable to delete old classes");
}
if (sizeof($addsubs)!=0){
    $res3 = mysqli_query($con, $q3);
    if (!$res3) echo("<br>unable to add new classes");
}
    
mysqli_close($con);


?>