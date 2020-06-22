<?php
require('../fun.php');
if (!sessioncheck() or !isset($_POST['username']) or !isset($_POST['password']) or !isset($_POST['password2']))
    header('Location: ../');
if ($_SESSION['user']->isstaff != '1')
    header('Location: ../');
if (isset($_POST['subjects'])){
    $subjects = $_POST['subjects'];
    foreach($subjects as $subject){
        if (!is_numeric($subject))
            header('Location: ../');
    }
} else $subjects = array()
$username = $_POST['username'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

if (userexists($username)){ ?>
    <script>
           alert("The class already exist");
           window.location.replace("../STAFF/");
    </script>
<?php } else if ($password != $password2){ ?>
    <script>
           alert("Password mismatch");
           window.location.replace("../STAFF/");
    </script>
<?php } else {
    $con = connect();
    $q = "insert into `user` values (NULL, '$username', '$password', 0, 0)";
    $res = mysqli_query($con, $q);
    if ($res){
        $uid = mysqli_insert_id($con);
        foreach ($subjects as $subject){
            if (!mysqli_query($con, "insert into `clas` values(NULL, $uid, $subject)")){
                mysqli_close($con); ?>
                <script>
                   alert("class added, Please verify subjects");
                   window.location.replace("../staff/");
                </script>
<?php           break;
            }
        } ?>
       <script>
           alert("Class Added");
           window.location.replace("../staff/");
        </script>
<?php
    } else { 
        mysqli_close($con); ?>
        <script>
           alert("Unable to add to Database");
           window.location.replace("../staff/");
        </script>
<?php
    }
} ?>