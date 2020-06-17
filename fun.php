<?php

function connect($caller="fun"){
    //helps to connect to whicheveer database is being used
    $server = "localhost";
    $db = "onlineclass";
    $user = "root";
    $pw = "";
    $con = mysqli_connect($server, $user, $pw, $db) or die("$caller : Unable to connect to db.");
    return $con;
}

function isstaff($sessionvar){
    //checks if the session belongs to a staff member
    return false;
}

function sessioncheck(){
    //checks if a user has logged in, returns to signinpage otherwise
    session_start();
    if (!isset($_SESSION['user'])){
        header('Location: signin.php');
    }
}
function sessiondelete(){
    //deletes session information
    session_start();
    if (isset($_SESSION['user'])){
        unset($_SESSION['user']);
        session_destroy();
    }
}

?>