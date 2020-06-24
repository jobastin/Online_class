<?php
require('../fun.php');
if (!sessioncheck() or !isset($_POST['subject']))
    header('Location: ../');
if ($_SESSION['user']->isstaff != '1')
    header('Location: ../');

$subject = $_POST['subject'];
//sterilize input?

$con = connect();
$q = "select `subjectname` from `subj` where `subjectname`='".mysqli_real_escape_string($con, $subject)."'";
$q1 = "insert into `subj` values (NULL, '".mysqli_real_escape_string($con, $subject)."')";
$res = mysqli_query($con, $q) or die("unable to connect");
if (mysqli_num_rows($res)==0)
    $res1 = mysqli_query($con, $q1) or die("Unable to add");
mysqli_close($con);

if (mysqli_num_rows($res)>0){ ?>
    <script>
        alert("That class already exists");
        window.location.replace("../STAFF/#subjects");
    </script>
<?php } else if ($res1){ ?>
    <script>
        alert("Subject Added Successfully");
        window.location.replace("../STAFF/#subjects");
    </script>
<?php } ?>
