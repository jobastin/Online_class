<?php
$loginpage = "login.php";

function connect($caller="fun"){
    //helps to connect to whicheveer database is being used
    $server = "localhost";
    $db = "onlineclass";
    $user = "root";
    $pw = "";
    $con = mysqli_connect($server, $user, $pw, $db) or die("$caller : Unable to connect to db.");
    return $con;
}

function signin($username, $password){
    //to make sure the creds are okay
    $con = connect();
    $user = mysqli_real_escape_string($con, $username);
    $pass = mysqli_real_escape_string($con, $password);
    $res = mysqli_query($con, "select * from `user` where username='$user' and password='$password'") or die("Sign in Error");
    if (mysqli_num_rows($res)==1){
        $row = mysqli_fetch_array($res);
//        print_r($row);die();
//        print_r($_SESSION); die();
        session_start();
        $_SESSION['user'] = new user($row['id'], $row['username'], $row['password'], $row['isstaff'], $row['isadmin']);
        if ($_SESSION['user']->isstaff()){
//            die('going to staff/');
            header('Location: staff/');
        }
        else{
//            die('going to student/');
            header('Location: student/');
        }
    }
    header("Location: login.php");
}

function sessioncheck(){
    //checks if a user has logged in, returns to signinpage otherwise
    session_start();
    if (!isset($_SESSION['user'])){
        header('Location: login.php');
    }
}
function sessiondelete(){
    //deletes session information
    session_start();
    if (isset($_SESSION['user'])){
        unset($_SESSION['user']);
    }
    session_destroy();
}

class user{
    function __construct($id, $username, $password, $isstaff, $isadmin){
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->isstaff = $isstaff;
        $this->isadmin = $isadmin;
//        print_r($this);die;
    }
    function isstaff(){
        return (bool)$this->isstaff;
    }
}

?>