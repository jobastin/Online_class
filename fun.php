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
    mysqli_close($con);
    
    if (mysqli_num_rows($res)==1){
        $row = mysqli_fetch_array($res);
//        print_r($row);die();
//        print_r($_SESSION); die();
        session_start();
        $_SESSION['user'] = new user($row['id'], $row['username'], $row['password'], $row['isstaff'], $row['isadmin']);
        if ($_SESSION['user']->isstaff()){
            header('Location: staff/');
            return;
        }
        else{
            header('Location: student/');
            return;
        }
    } else
        header("Location: login.php");
}

function sessioncheck(){
    //checks if a user has logged in, returns to signinpage otherwise
    session_start();
    if (!isset($_SESSION['user'])){
        return false;
    } else {
        return true;
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

function classes($userid, $returnsubject = false){
    //returns an array of class objects, having classes that user attend
    //if returnsubject is not false, it returns the id of clas the user attends
    
    $con = connect();
    $q = "select `clas`.`id`, `subj_id`, `subjectname` from `clas` inner join `subj` on `clas`.`subj_id`=`subj`.`id` where `clas`.`user_id`=$userid";
    $res = mysqli_query($con, $q) or die('Unable to Fetch Data');
    mysqli_close($con);
    
    $subjects = array();
    while($row = mysqli_fetch_array($res)){
        if (!returnsubject)
            array_push($subjects, new subject($row['id'], $row['subj_id'], $row['subjectname']));
        else
            if ($row['subjectname'] == $returnsubject)
                return $row['id'];
    }
    return $subjects;
}
function vidlink($clas){
    //returns an array of arrays containing links to the subjects in $clas variable
    $alllinks = array();
    $con = connect();
    foreach ($clas as $sub){
        $q = "select * from `vids` where `class_id`=$sub->id";
        $res = mysqli_query($con, $q) or die("Unable to Fetch Classes");
        $links = array();
        while ($row = mysqli_fetch_array($res)){
            array_push($links, new ytlink($row['staff_id'], $row['class_id'], $row['title'], $row['link'], $row['chapter']));
        }
        array_push($alllinks, $links);
    }
    mysqli_close($con);
    return $alllinks;
}
function fetchclasses(){
    //returns all the classes going on in school
    $con = connect();
    $res = mysqli_query($con, "select username from `user` where isstaff=0") or die("Unable to fetch Users.");
    $users = array();
    while ($row = mysqli_fetch_array($res))
        array_push($users, $row['username']);
    mysqli_close($con);
    return $users;
}

class ytlink{
    function __construct($staffid, $classid, $title, $vlink, $chapter){
        $this->staffid = $staffid;
        $this->classid = $classid;
        $this->title = $title;
        $this->vlink = $vlink;
        $this->chapter = $chapter;
    }
}
class subject{
    function __construct($id, $subjid, $subjectname){
        $this->id = $id;
        $this->subjid = $subjid;
        $this->subjectname = $subjectname;
    }
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