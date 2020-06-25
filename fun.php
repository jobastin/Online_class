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
        $_SESSION['user'] = new user($row['id'], $row['username'], $row['isstaff'], $row['isadmin']);
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
        if (!$returnsubject)
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
function linkexists($user, $vlink){
    //returns whether or on the link already exists for the user
    $con = connect();
    $q = "select `user`.`username`, `title`, `link` from (`vids` inner join `clas` on `vids`.`class_id`=`clas`.`id`) inner join `user` on `clas`.`user_id`=`user`.`id` where `link`='$vlink' and `username`='$user'";
    $res = mysqli_query($con, $q) or die('Data checks not working');
    mysqli_close($con);
    if (mysqli_num_rows($res)>0)
        return true;
    else return false;
}
function userexists($username){
    //return whether or not the class-user already exists
    $con = connect();
    $q = "select `username` from `user` where `username`='$username'";
    $res = mysqli_query($con, $q) or die("User Checks not working");
    mysqli_close($con);
    if (mysqli_num_rows($res)>0)
        return true;
    else return false;
}
function getUsers($textonlymode=true){
    //returns all the classes going on in school, with the subjects they attend
    $con = connect();
    $q = "select `user`.`id`, `user`.`username`, `user`.`password`, `user`.`isstaff`, `user`.`isadmin`, `classes`.`subjects` from `user` left join (select `user_id`, GROUP_CONCAT(`clas`.`subj_id` separator ',') as `subjects` from `clas` group by `clas`.`user_id`) as `classes` on `user`.`id`=`classes`.`user_id` where isstaff=0 order by `user`.`username`";
    $res = mysqli_query($con, $q) or die("Unable to fetch Users.");
    mysqli_close($con);
    
    if ($textonlymode){
        $users = array();
        while ($row = mysqli_fetch_array($res))
            array_push($users, $row['username']);
        return $users;
    } else
        if (mysqli_num_rows($res) == 0) return false;
        else return $res;
}
function getStaff(){
    //returns all the staff in the school
    $con = connect();
    $q = "select `user`.`id`, `user`.`username`, `user`.`isstaff`, `user`.`isadmin`, count(`link`) as `links`, count(distinct `class_id`) as `classes` from `user` left join `vids` on `user`.id=`vids`.`staff_id` group by `username` having `isstaff`=1 and `user`.`username` != {$_SESSION['user']->id}";
    $res = mysqli_query($con, $q) or die("Unable to fetch Users");
    mysqli_close($con);
    
    if (mysqli_num_rows($res) == 0) return false;
    else return $res;
}
function getSubjects(){
    //returns all subjects
    $con = connect();
    $q = "select * from `subj`";
    $res = mysqli_query($con, $q) or die("Unable to Fetch Subjects");
    mysqli_close($con);
    
    if (mysqli_num_rows($res) == 0) return false;
    else return $res;
}
function getLinks(){
    //returns ALL the links published in school - COULD be restricted to staff id
    //vids_id, classname, subjectname, title, link, chapter
    $con = connect();
    $q = "select `vids`.`id` as `vids_id`, `username` as `classname`, `subjectname`, `vids`.`title`, `vids`.`link`, `vids`.`chapter` from `user` inner join `clas` on `user`.`id`=`clas`.`user_id` inner join `subj` on `subj`.`id`=`clas`.`subj_id` inner join `vids` on `clas`.`id` = `vids`.`class_id` order by `username`, `subjectname`, `chapter`";
    $res = mysqli_query($con, $q) or die('Unable to Fetch Links');
    mysqli_close($con);

    if (mysqli_num_rows($res) == 0) return false;
    else return $res;
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
    function __construct($id, $username, $isstaff, $isadmin){
        $this->id = $id;
        $this->username = $username;
        $this->isstaff = $isstaff;
        $this->isadmin = $isadmin;
//        print_r($this);die;
    }
    function isstaff(){
        return (bool)$this->isstaff;
    }
}

?>