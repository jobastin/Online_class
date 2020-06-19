<?php
require('../fun.php');
if (!sessioncheck())
    header('Location: ../');
$staff = $_SESSION['user'];
$class = $_POST['class'];
$subj = $_POST['subject'];
$title = $_POST['title'];
$vlink = $_POST['vlink'];
$chapt = $_POST['chapter'];


$con = connect();
$q = "select `user`.`username`, `title`, `link` from (`vids` inner join `clas` on `vids`.`class_id`=`clas`.`id`) inner join `user` on `clas`.`user_id`=`user`.`id` where `link`='$vlink' and `username`='$class'";
$res = mysqli_query($con, $q);
if (mysqli_num_rows($res)>0){
    //ALREADY EXISTING LINKS STUFF
    die("$vlink is already provided to $class.");
} else {
    $q = "insert into `vids` values (NULL, $staff->id, (select `id` from `clas` where `user_id` = (select `id` from `user` where `username`='$class') and `subj_id`=(select `id` from `subj` where `subjectname`='$subj')), '$title', '$vlink', $chapt)";
    $res = mysqli_query($con, $q);
    if ($res){
        //SUCCESS STUFF
        header('Location: ../staff/');
    } else {
        //FAILURE STUFF
        die ("Error on database insert : ".mysqli_error($con));
    }
}
?>