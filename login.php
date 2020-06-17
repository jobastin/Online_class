<?php 
require('fun.php');
sessiondelete();
?><!DOCTYPE html>
<html>
<head>
	<title>Login | St. Aloysius School</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>
        function checkuser(username){
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function(){
                if (!(this.readyState == 4 && this.status == 200)) return;
                if (this.responseText == 'true'){
                    ### VALID USER CODE HERE ###
                } else if (this.responseText == 'false'){
                    ### INVALID USER CODE HERE ###
                }
            }
            ajax.open("get", "checkuser.php?user=### USERNAMEHERE ###", );
            ajax.send();
        }
    </script>
</head>
<body>
	<img class="wave" src="img/background.jpg">
	<div class="navbar" style="background-color: #25CCF7;opacity: 0.2">
	   <center><b><h2>St. ALOYSIUS SCHOOL TANIKALLA</h2></b></center>
	</div>
	<div class="banner-area"></div>
	<div class="container">
		<div class="img">
			<img src="img/thumpnail.png">
		</div>
		<div class="login-content">
			<form action="student_login.html" method="post">
				<img src="img/avathar.png" style="border-radius: 50%;">
				<h2 class="title">LOGIN</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Student ID</h5>
           		   		<input type="text" class="input" name="username">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Password</h5>
           		    	<input type="password" class="input" name="password">
            	   </div>
            	</div>
            	<input type="submit" class="btn" value="Login">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>
