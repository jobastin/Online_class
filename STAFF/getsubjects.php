<?php
//returns a list of subjects that the user(class) could have
require('../fun.php');
$user = $_GET['user'];
if (preg_match('/^[a-zA-Z0-9]+$/', $user)){
    $con = connect();
    $res = mysqli_query($con, "select `subjectname` as `subject` from `subj` where `id` in (select `subj_id` from `clas` where `user_id`=(select `id` from `user` where `username`='$user'))") or die("Unable to fetch data");
    mysqli_close($con);
    
    while ($row = mysqli_fetch_array($res)){
        echo $row['subject']."<br/>";
    }
} else echo "Wrong username format";
?>