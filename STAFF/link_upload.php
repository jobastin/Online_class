<?php
require('../fun.php');
if (!sessioncheck() or !isset($_POST['class']) or !isset($_POST['subject']) or !isset($_POST['title']) or !isset($_POST['vlink']) or !isset($_POST['chapter']))
    header('Location: ../');
if ($_SESSION['user']->isstaff != '1')
    header('Location: ../');

$staff = $_SESSION['user'];
$class = $_POST['class'];
$subj = $_POST['subject'];
$title = $_POST['title'];
$vlink = $_POST['vlink'];
$chapt = $_POST['chapter'];

if (linkexists($class, $vlink)){ ?>
    <script>
           alert("The provided Link alredy exist");
           window.location.replace("../STAFF/");
    </script>
<?php } else {
    $con = connect();
    $q = "insert into `vids` values (NULL, $staff->id, (select `id` from `clas` where `user_id` = (select `id` from `user` where `username`='$class') and `subj_id`=(select `id` from `subj` where `subjectname`='$subj')), '$title', '$vlink', $chapt)";
    $res = mysqli_query($con, $q);
    mysqli_close($con);
    if ($res){?>
       <script>
           alert("Uploaded Successfully");
           window.location.replace("../staff/");
        </script>
        <?php
      
    } else { ?>
        <script>
           alert("Unable to upload to Database");
           window.location.replace("../staff/");
        </script>
<?php 
//            die ("Error on database insert : ".mysqli_error($con));
    }
} ?>