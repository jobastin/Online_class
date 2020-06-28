<?php
require('../fun.php');
if (!sessioncheck() or !isset($_POST['staffusername']) or !isset($_POST['staffpassword']))
    header('Location: ../');
if ($_SESSION['user']->isstaff != '1')
    header('Location: ../');

$staff = $_SESSION['user'];
$staffuser = $_POST['staffusername'];
$staffpass = $_POST['staffpassword'];
if (isset($_POST['staffisadmin']) and $_POST['staffisadmin'] == "1")
    $staffisad = 1;
else $staffisad = 0;

//sterilize input?

if ($_POST['staffisadmin'] === "1")
    echo "success";
if (false){ //userexists($staffuser)){ ?>
    <script>
        alert("That user already exists");
        window.location.replace("../STAFF/#staff");
    </script>
<?php } else {
    $con = connect();
    $q = "insert into `user` values (NULL, '$staffuser', '$staffpass', 1, $staffisad)";
    $res = mysqli_query($con, $q);
    mysqli_close($con);
    if ($res){ ?>
    <script>
        alert("New Staff added");
        window.location.replace("../STAFF/#staff");
    </script>
<?php }
} ?>