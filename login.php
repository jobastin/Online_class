<?php 
require('fun.php');
sessiondelete();
if (!isset($_POST['submit'])){
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<link rel="apple-touch-icon" sizes="76x76" href="./assets/img/favicon.ico">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>Login | St. Aloysius School</title>
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport'/>
    
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Nunito:300,300i,400,600,800" rel="stylesheet">
    
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    
<!-- Main CSS -->
<link href="css/main.css" rel="stylesheet"/>
    
<!-- Animation CSS -->
<link href="./assets/css/vendor/aos.css" rel="stylesheet"/>
    <script>
        function checkuser(username){
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function(){
                if (!(this.readyState == 4 && this.status == 200)) return;
                console.log('"'+this.responseText+'"')
                if (this.responseText == 'true'){
                    ### VALID USER CODE HERE ###
                } else if (this.responseText == 'false'){
                    ### INVALID USER CODE HERE ###
                }
            }
            ajax.open("get", "checkuser.php?user="+username);
            ajax.send();
        }
    </script>
</head>
    
<body> 
<nav class="topnav navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
<div class="container-fluid">
	<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>
	<div class="navbar-collapse collapse" id="navbarColor02" style="">
		<ul class="navbar-nav mr-auto d-flex align-items-center">
			<li class="nav-item">
			<a class="nav-link" href="#">Home</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="#">Contact</a>
			</li>
		</ul>
	</div>
</div>
</nav>
<!-- End Navbar -->
    
<!-- Main -->
<div class="d-md-flex h-md-100 align-items-center">
	<div class="col-md-6 p-0 bg-indigo h-md-100" style="background-image: url(img/thumpnail.png); background-repeat: no-repeat;
  background-attachment: fixed;
  background-position:102px 54px;">
		<div class="text-white d-md-flex align-items-center h-100 p-5 text-center justify-content-center">
		</div>
	</div>
	<div class="col-md-6 p-0 bg-white h-md-100 loginarea" style="background-image: url(img/img11.JPG); background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 700px auto;
  background-position:right top;
  opacity: 1;">
		<div class="d-md-flex align-items-center h-md-100 p-5 justify-content-center">
			<form class="border rounded p-5" style="background-color: white;opacity: 1;" action="login.php" method="post">
				<h3 class="mb-4 text-center">Sign In</h3>
				<div class="form-group">
					<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Login ID" required="" oninput="checkuser(this.value);" name="username">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required="" name="password">
				</div>
				<button type="submit" class="btn btn-success btn-round btn-block shadow-sm" name="submit">Sign in</button>
			</form>
		</div>
	</div>
</div>    
<script src="./assets/js/vendor/jquery.min.js" type="text/javascript"></script>
<script src="./assets/js/vendor/popper.min.js" type="text/javascript"></script>
<script src="./assets/js/vendor/bootstrap.min.js" type="text/javascript"></script>
<script src="./assets/js/functions.js" type="text/javascript"></script>
    
<!-- Animation -->
<script src="./assets/js/vendor/aos.js" type="text/javascript"></script>
<noscript>
    <style>
        *[data-aos] {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
    </style>
</noscript>
<script>
    AOS.init({
        duration: 700
    });
</script>
 
<!-- Disable animation on less than 1200px, change value if you like -->
<script>
AOS.init({
  disable: function () {
    var maxWidth = 1200;
    return window.innerWidth < maxWidth;
  }
});
</script>

</body>
</html>
<?php 
} else {
    if (!(isset($_POST['username']) and isset($_POST['password'])))
        header('Location: login.php');
    signin($_POST['username'], $_POST['password']);
}
?>