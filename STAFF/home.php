<?php
require('../fun.php');
if(sessioncheck() == false)
    //redirect to login if session isn't set
    header('Location: ../login.php');
else{
    $user = $_SESSION['user'];
    if (!$user->isstaff()){
        //redirects to student landing if user is a student
        header('Location: ../student/');
    } else {
?><!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>St. Aloysius School | <?php echo $user->username; ?></title>
  <link rel="shortcut icon" href="../img/thumpnail.png" type="image/png">
  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../css/media.css" rel="stylesheet">
  
  
  <script>
    function show1(){
        document.getElementById("links").style.display = "none"; 
        document.getElementById("statistics").style.display = "inline"; 
        document.getElementById("classes").style.display = "none"; 
        document.getElementById("subjects").style.display = "none";
        document.getElementById("staff").style.display = "none";
    }
    function show3(){
        document.getElementById("links").style.display = "inline"; 
        document.getElementById("statistics").style.display = "none"; 
        document.getElementById("classes").style.display = "none"; 
        document.getElementById("subjects").style.display = "none";
        document.getElementById("staff").style.display = "none";
    }
    function show4(){
        document.getElementById("links").style.display = "none"; 
        document.getElementById("statistics").style.display = "none"; 
        document.getElementById("classes").style.display = "inline"; 
        document.getElementById("subjects").style.display = "none";
        document.getElementById("staff").style.display = "none";
    }
    function show5(){
        document.getElementById("links").style.display = "none"; 
        document.getElementById("statistics").style.display = "none"; 
        document.getElementById("classes").style.display = "none"; 
        document.getElementById("subjects").style.display = "inline";
        document.getElementById("staff").style.display = "none";
    }
    function show6(){
        document.getElementById("links").style.display = "none"; 
        document.getElementById("statistics").style.display = "none"; 
        document.getElementById("classes").style.display = "none"; 
        document.getElementById("subjects").style.display = "none";
        document.getElementById("staff").style.display = "inline";
    }
    function loadsubjects(classname){
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function(){
            //exit of data not ready
            if (!(this.readyState == 4 && this.status == 200)) return;
            //obtain data from db
    //        console.log(this.responseText);
            var subjects = [];
            for (x of this.responseText.split("<br/>"))
                subjects.push(x);
            subjects.pop();
            console.log(subjects);

            //clear data list options
            var datalist = document.getElementById("fetchsubjects");
            var datalistparent = datalist.parentElement;
            datalistparent.removeChild(datalist);
            datalist = document.createElement("datalist");
            datalist.id = "fetchsubjects";
            datalistparent.appendChild(datalist);

            //add options to the data list
            subjects.forEach(item => {
                let option = document.createElement('option');
                option.value = item;
                option.className = "subjectlist"
                datalist.appendChild(option);
            });
        };
        ajax.open("get", "getsubjects.php?user="+classname);
        ajax.send();
    }
    function links_edit(editonsuccess, vidid){
        //set default values to edit modal
        var chapter = document.getElementById('link_edit_chapter');
        var title = document.getElementById('link_edit_title');
        var link = document.getElementById('link_edit_link');
        document.getElementById('link_edit_classname').value = editonsuccess.getElementsByTagName('td')[0].innerHTML;
        document.getElementById('link_edit_subjectname').value = editonsuccess.getElementsByTagName('td')[1].innerHTML;
        document.getElementById('link_edit_vidid').value = vidid;
        chapter.value = editonsuccess.getElementsByTagName('td')[2].innerHTML;
        title.value = editonsuccess.getElementsByTagName('td')[3].innerHTML;
        link.value = editonsuccess.getElementsByTagName('td')[4].innerHTML;
        
        document.getElementById('link_edit_submit').onclick = function(){
            var ajax = new XMLHttpRequest();
            var params = encodeURIComponent('chapter')+'='+encodeURIComponent(chapter.value)+'&'+
                encodeURIComponent('title')+'='+encodeURIComponent(title.value)+'&'+
                encodeURIComponent('link')+'='+encodeURIComponent(link.value)+'&'+
                encodeURIComponent('id')+'='+encodeURIComponent(vidid);
            ajax.onreadystatechange = function(){
                //exit if data not ready
                if (!(this.readyState == 4 && this.status == 200)) return;
                var result = this.responseText.split('<br>');
                for (x of result) console.log(x);
                if (result[0] == 'link edit success'){
                    editonsuccess.getElementsByTagName('td')[2].innerHTML = result[2];
                    editonsuccess.getElementsByTagName('td')[3].innerHTML = result[1];
                    editonsuccess.getElementsByTagName('td')[4].innerHTML = result[3];
                } else {
                    // #INCOMPLETE : display db edit link error message
                }
            }
            ajax.open("post", "link_update.php");
            ajax.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            ajax.send(params);
            console.log('link edit : '+vidid);
        }
    }
    function links_delete(vidid, deleteonsuccess){
        document.getElementById('links_delete').onclick=function(){
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function(){
                //exit if data not ready
                if (!(this.readyState == 4 && this.status == 200)) return;
                
                console.log(this.responseText);
                if (this.responseText == "delete success")
                    deleteonsuccess.remove();
                else{
                    // #INCOMPLETE : display db delete link error message
                }
            };
            ajax.open("get", "link_delete.php?deleteid="+vidid);
            ajax.send();
            console.log('link delete : '+vidid);
        };
    }
    function classes_edit(editonsuccess, userid, subjectstring){
        //fetch existing data
        var checksubjects = subjectstring.split(','); //console.log(checksubjects);
        var classname = document.getElementById('class_edit_classname');
        var password = document.getElementById('class_edit_password');
        var subjectboxes = document.getElementsByName('changed_subjects[]');
        for (x of subjectboxes) x.checked = checksubjects.includes(x.value);
        classname.value = editonsuccess.getElementsByTagName('td')[0].innerHTML;
        password.value = editonsuccess.getElementsByTagName('td')[1].innerHTML;
        
        document.getElementById('class_edit_submit').onclick = function(){
            var subjects = [];
            for (x of subjectboxes)
                if (x.checked == true)
                    subjects.push(x.value);
//            console.log(classname.value);
//            console.log(password.value);
//            console.log(subjects);
            var ajax = new XMLHttpRequest();
            var params = encodeURIComponent('classname')+'='+encodeURIComponent(classname.value)+'&'+
                encodeURIComponent('password')+'='+encodeURIComponent(password.value)+'&'+
                encodeURIComponent('subjects')+'='+encodeURIComponent(subjects)+'&'+
                encodeURIComponent('id')+'='+encodeURIComponent(userid);
            ajax.onreadystatechange = function(){
                //exit if data not ready
                if (!(this.readyState == 4 && this.status == 200)) return;
                var result = this.responseText.split('<br>');
                for (x of result) console.log(x);
                if (result[0] == 'class edit success'){
                    editonsuccess.getElementsByTagName('td')[0].innerHTML = result[1];
                    editonsuccess.getElementsByTagName('td')[1].innerHTML = result[2];
                    editonsuccess.getElementsByTagName('button')[0].onclick="classes_edit(this.parentElement.parentElement), "+userid+", "+result[3]+")";
                } else {
                    // #INCOMPLETE : display edit class error message
                    ;
                }
            }
            ajax.open("post", "class_update.php");
            ajax.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            ajax.send(params);
            console.log('class edit : '+userid);
        }
    }
    function classes_delete(id, deleteonsuccess){
        document.getElementById('class_delete').onclick=function(){
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function(){
                //exit if data not ready
                if (!(this.readyState == 4 && this.status == 200)) return;
                
                console.log(this.responseText);
                if (this.responseText == "delete success")
                    deleteonsuccess.remove();
                else{
                    // #INCOMPLETE : display db delete class error message
                }
            };
            ajax.open("get", "class_delete.php?delete_id="+id);
            ajax.send();
            console.log('class delete : '+id);
        }
    }
    function subjects_edit(editonsuccess, subjid){
        var subject = document.getElementById('subject_edit_subject');
        subject.value = editonsuccess.getElementsByTagName('td')[0].innerHTML;
        
        document.getElementById('subject_edit_submit').onclick = function(){
            var ajax = new XMLHttpRequest();
            var params = encodeURIComponent('subjectname')+'='+encodeURIComponent(subject.value)+'&'+
                encodeURIComponent('id')+'='+encodeURIComponent(subjid);
            ajax.onreadystatechange = function(){
                //exit if data not ready
                if (!(this.readyState == 4 && this.status == 200)) return;
                var result = this.responseText.split('<br>');
                for (x of result) console.log(x);
                if ((result[0]) == 'subject edit success'){
                    editonsuccess.getElementsByTagName('td')[0].innerHTML = result[1];
                } else {
                    // #INCOMPLETE : display db edit subject error message
                }
            };
            ajax.open("post", "subject_update.php");
            ajax.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            ajax.send(params);
            console.log('subject edit : '+subjid);
        };
    }
    function subjects_delete(subjid, deleteonsuccess){
        document.getElementById('subject_delete').onclick = function(){
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function(){
                //exit if data not ready
                if (!(this.readyState == 4 && this.status == 200)) return;
                
                console.log(this.responseText);
                if (this.responseText == "delete success")
                    deleteonsuccess.remove();
                else {
                    // #INCOMPLETE : display db delete subject link error message
                }
            };
            ajax.open("get", "subject_delete.php?deleteid="+subjid);
            ajax.send();
            console.log('subject delete : '+subjid);
        };
    }
    function loadsection(){
        url = window.location.href;
//        console.log(url.split('#')[1])
        switch (url.split('#')[1]){
            case 'statistics': show1(); break;
            case 'links': show3(); break;
            case 'classes': show4(); break;
            case 'subjects': show5(); break;
            case 'staff': show6(); break;
            default: break;
        }
    }
</script>
<style>
    .borderless td, .borderless th {
    border: none;
}
    </style>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
        </div>
        <div class="sidebar-brand-text mx-3">Admin Panel</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="#statistics"  onclick="show1()">
          <i class="fa fa-cogs"></i>
          <span>STATISTICS</span></a>
      </li>
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link"  href="#links" onclick="show3()">
          <i class="fa fa-upload"></i>
          <span>UPLOADS</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        CHANGES
      </div>

      <li class="nav-item">
        <a class="nav-link"  href="#classes" onclick="show4()">
          <i class="fas fa-fw fa-cog"></i>
          <span>CLASSES</span></a>
      </li>
      <hr class="sidebar-divider my-0">
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link"  href="#subjects" onclick="show5()">
          <i class="fas fa-fw fa-cog"></i>
          <span>SUBJECTS</span></a>
      </li>
      
      
      <hr class="sidebar-divider my-0">
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link"  href="#staff" onclick="show6()">
          <i class="fas fa-user"></i>
          <span>STAFF</span></a>
      </li>
      
      <hr class="sidebar-divider">
      <!-- Heading -->
    </ul>
    </div>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <!-- Topbar Navbar -->
          <h3>St. ALOYSIUS ENGLISH MEDIUM SCHOOL THANIKALLA</h3>
          <ul class="navbar-nav ml-auto">

           
            <div class="topbar-divider d-none d-sm-block"></div>
            
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $user->username; ?></span>
                <img class="img-profile rounded-circle " src="../img/thumpnail.png"> 
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#myModal1">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../logout.php" data-toggle="modal" data-target="#logoutModal" id="logout">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>

       
<!--Stastictis page -->
        <div class="container-fluid" id="statistics" name="section" style="display: inline;">

          <div style="margin-left:15px;margin-right:15px;">
         <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Total Number of Videos Uploaded</h5>
            <b><p class="card-text"><?php
            $links = getLinks();
            if ($links) echo mysqli_num_rows($links);
            else echo "#INCOMPLETE";
            ?></p></b>
          </div>
        </div>
      </div>
      <br>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Totla Number of Classes</h5>
            <b><p class="card-text"><?php
            $classes = getUsers(false);
            if ($classes) echo mysqli_num_rows($classes);
            else echo "#INCOMPLETE";
            ?></p></b>
          </div>
        </div>
      </div>
    </div>
</div>
     <br>
      <div  style="margin-left:15px;margin-right:15px;">
         <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Totla Number of Subjects</h5>
            <b><p class="card-text"><?php
            $allsubs = getSubjects();
            if ($allsubs) echo mysqli_num_rows($allsubs);
            else echo "#INCOMPLETE";
            ?></p></b>
          </div>
        </div>
      </div>
      <br>
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Total Number Of xxxxx</h5>
            <b><p class="card-text">Number</p></b>
          </div>
        </div>
      </div>
    </div>
</div>
        </div>    
<!--profile edit -->
        <div class="container-fluid" id="staff" name="section" style="display: none;">
        <table class="table borderless" style="margin: auto;width: 50% !important;">
  <thead>
    <tr>
      <th scope="col">Staff username</th>
      <th scope="col">Links Uploaded</th>
      <th scope="col">Classes</th>
      <th scope="col">Administrator</th>
    </tr>
  </thead>
  <tbody>
<?php
//            isstaff and isadmin attribs also exist
            $staffs = getStaff();
            if ($staffs){
                while ($row = mysqli_fetch_array($staffs)){ ?>
    <tr>
      <td><?php echo $row['username']; ?></td>
      <td><?php echo $row['links']; ?></td>
      <td><?php echo $row['classes']; ?></td>
      <td><?php if ($row['isadmin']) echo "Yes"; else echo "No"; ?></td>
<!--
      <td>
         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#changepassword">Change Password</button>
         <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteprofile">Delete</button>
          </td>
-->
    </tr>           
<?php           }
            } else {
                #INCOMPLETE show no staff message - you have no other staff but you alone XD COMEDY
            }
?>
    <tr>
       <td colspan="2"></td>
        <td><button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#addprofile">ADD STAFF</button>
        </td>
    </tr>
  </tbody>
</table>
</div> 
          
<!-- PROFILE >> change password -->
  <div class="modal" id="changepassword">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
       Change Password
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       <div class="input-group">
                <input class="form-control" type="password" placeholder="Current Password">
            </div>
            <br>
            <div class="input-group">
                <input class="form-control" type="password" placeholder="New Password">
            </div>
            <br>
            <div class="input-group">
                <input class="form-control" type="password" placeholder="Confrim New Password">
            </div>
            <br>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">CONFRIM</button>
      </div>

    </div>
  </div>
</div>
   
<!-- PROFILE >> delete -->
  <div class="modal" id="deleteprofile">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Do you want to remove this profile ??
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">CONFRIM</button>
      </div>

    </div>
  </div>
</div>

<!-- PROFILE >> add new profile -->
  <div class="modal" id="addprofile">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="staff_upload.php" method="post">

      <!-- Modal Header -->
      <div class="modal-header">
       New Staff Member
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <div class="input-group">
                <input name="staffusername" class="form-control" type="text" placeholder="Username">
            </div>
            <br>
            <div class="input-group">
                <input name="staffpassword" class="form-control" type="text" placeholder="Set Password">
            </div>
            <br>
            <div class="custom-control custom-checkbox">
          <input name="staffisadmin" value="1" type="checkbox" class="custom-control-input" id="admincheck">
          <label class="custom-control-label" for="admincheck">Admin User</label>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <input type="submit" class="btn btn-success" value="CONFIRM" /><!--data-dismiss="modal"-->
      </div>

        </form>
    </div>
  </div>
</div>
   
               
                                             
<!--edit page -->       
     <div class="container-fluid" id="links" name="section" style="display: none;">

          <!-- Page Heading -->
    <table class="table borderless">
  <thead>
<!--
  IF YOU EDIT THE COLUMN ORDER MAKE SURE YOU EDIT THE links_edit() ACCORDINGLY.
  It relies on the order of columns to obtain that specific data
   -->
    <tr>
      <th scope="col">CLASS</th>
      <th scope="col">SUBJECT</th>
      <th scope="col">CHAPTER NUMBER</th>
      <th scope="col">TITLE</th>
      <th scope="col">YOUTUBE LINK</th>
      <th scope="col">ACTION</th>
    </tr>
  </thead>
  <tbody>
<?php
            if ($links == false){
//                #INCOMPLETE NO LINKS HAVE BEEN ADDED message
            } else while ($link = mysqli_fetch_array($links)){ ?>
    <tr>
        <td><?php echo $link['classname']; ?></td>
        <td><?php echo $link['subjectname']; ?></td>
        <td><?php echo $link['chapter']; ?></td>
        <td><?php echo $link['title']; ?></td>
        <td><?php echo $link['link']; ?></td>
        <td>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal3" onclick="links_edit(this.parentElement.parentElement, <?php echo $link['vids_id']; ?>)">Edit</button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal4" onclick="links_delete(<?php echo $link['vids_id']; ?>, this.parentElement.parentElement)">Delete</button>
        </td>
    </tr>                
<?php       } ?>
    <tr>
       <td colspan="5"></td>
        <td>
            <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#newupload">New Upload</button>
        </td>
    </tr>
  </tbody>
</table>
        </div> 
                 
     <!-- edit class DETAILS -->            
<div class="container-fluid" id="classes" name="section" style="display: none;">
  <table class="table borderless" >
  <thead>
    <tr>
<!--
  IF YOU EDIT THE COLUMN ORDER MAKE SURE YOU EDIT THE classes_edit() ACCORDINGLY.
  It relies on the order of columns to obtain that specific data
   -->
<!--      <th scope="col">SINO</th>-->
      <th scope="col">CLASS LOGIN ID</th>
      <th scope="col">PASSWORD</th>
      <th scope="col">ACTION</th>
    </tr>
  </thead>
  <tbody>
<?php
            if ($classes == false){
//                #INCOMPLETE NO CLASSES HAVE BEEN ADDED message
            } else while ($class = mysqli_fetch_array($classes)){ ?>
    <tr>
<!--      <th scope="row">1</th>-->
      <td><?php echo $class['username']; ?></td>
      <td><?php echo $class['password']; ?></td>
        <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#editclass" onclick="classes_edit(this.parentElement.parentElement, <?php echo $class['id'].', \''.$class['subjects'].'\''; ?>)">Edit</button>
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal6" onclick="classes_delete(<?php echo $class['id']; ?>, this.parentElement.parentElement)" >Delete</button>
          </td>
    </tr>
<?php       } ?>
    <tr>
       <td colspan="2"></td>
        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addclass">ADD CLASS</button>
        </td>
    </tr>
  </tbody>
</table>
       
        </div>               

            <!-- edit subjects -->     
<div class="container-fluid" id="subjects" name="section" style="display: none;">

            <table class="table borderless" style="margin: auto;width: 50% !important;">
  <thead>
    <tr>
      <th scope="col">SUBJECTS</th>
      <th scope="col">ACTION</th>
    </tr>
  </thead>
  <tbody>
<?php 
            $allsubs = getSubjects();
            if ($allsubs == false){
//                #INCOMPLETE - show no subjects message
            } else while ($row = mysqli_fetch_array($allsubs)){ ?>
    <tr>
      <td><?php echo $row['subjectname']; ?></td>
      <td>
         <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editsubject" onclick="subjects_edit(this.parentElement.parentElement, <?php echo $row['id']; ?>)">Edit</button>
         <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal5" onclick="subjects_delete(<?php echo $row['id']; ?>, this.parentElement.parentElement)">Delete</button>
          </td>
    </tr>
<?php       } ?>
    <tr>
       <td colspan="2"></td>
        <td><button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#addsubject">ADD SUBJECT</button>
        </td>
    </tr>
  </tbody>
</table>

        </div> 
                  
                  
                  
                  

                  
      </div>
      <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="../logout.php" id="logout">Logout</a>
        </div>
      </div>
    </div>
  </div>
  
   <!-- Profile Modal-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="input-group">
                <input class="form-control" type="password" placeholder="Current Password">
            </div>
            <br>
            <div class="input-group">
                <input class="form-control" type="password" placeholder="New Password">
            </div>
            <br>
            <div class="input-group">
                <input class="form-control" type="password" placeholder="Confrim New Password">
            </div>
            <br>
        </div>
        <div class="modal-footer">
          <a class="btn btn-primary" href="login.html">Save</a>
        </div>
      </div>
    </div>
  </div>
  
 <!--upload edit model -->
       <div class="modal fade" id="myModal3">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
         <table class="table borderless" >
    <tbody>
        <tr>
            <th scope="row">Class</th>
            <td>
                <input disabled name="classname" class="form-control" id="link_edit_classname" required/>
            </td>
        </tr>
        <tr>
            <th scope="row">Subject</th>
            <td>
                <input disabled name="subjectname" class="form-control" id="link_edit_subjectname" required>
            </td>
        </tr>
        <tr>
            <th scope="row">Chapter</th>
            <td>
                 <input name="chapter" class="form-control" type="number" min="0" id="link_edit_chapter" required>
            </td>
        </tr>
        <tr>
            <th scope="row">Video Title</th>
            <td>
                <div class="dropdown">
                    <input name="title" class="form-control" type="text" id="link_edit_title" required>
                </div>
            </td>
        </tr>
        <tr>
            <th scope="row">Video Link</th>
            <td>
                <div class="dropdown">
                    <input name="vlink" class="form-control" type="text" id="link_edit_link" required title="Find the Video link by clicking on the share option underneath the YouTube video and copying the link." placeholder="example : https://youtu.be/lJIrF4YjHfQ">
                </div>
            </td>
        </tr>
    </tbody>
</table>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <button name="submit" type="submit" class="btn btn-success" data-dismiss="modal" id="link_edit_submit">Update</button>
        </div>
        <input type="number" hidden id="link_edit_vidid" name="vids_id">
      </div>
    </div>
  </div>
  
  
  <!-- EDIT UPLOAD >> delete model -->
  <div class="modal" id="myModal4">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Do you want to remove this ??
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" id="links_delete">Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
      </div>

    </div>
  </div>
</div>
  
  
<!-- delete SUBJECTS >> delete model -->
  <div class="modal" id="myModal5">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Do you want to remove this subject ??
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" id="subject_delete">Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
      </div>

    </div>
  </div>
</div>
 <!-- delete CLASS >> delete model -->
  <div class="modal" id="myModal6">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Do you want to remove this class. All other information regarding the class will also be deleted.
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" id="class_delete">Yes, Remove Class</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No, Keep Class</button>
      </div>

    </div>
  </div>
</div>
   
 <!-- subject add model -->
  <div class="modal" id="addsubject">
  <div class="modal-dialog">
   <form action="subject_upload.php" method="post">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        Add Subject
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <input name="subject" type="text" class="form-control" placeholder="SUBJECT NAME" />
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <input type="submit" class="btn btn-success" value="Add Subject" /> <!-- data-dismiss="modal" -->
      </div>

    </div>
      </form>
  </div>
</div>
  

<!-- EDIT SUBJECTS >> subject edit model -->
  <div class="modal" id="editsubject">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        Edit Subject Name
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <input type="text" id="subject_edit_subject" class="form-control" placeholder="SUBJECT NAME" />
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" id="subject_edit_submit" class="btn btn-success" data-dismiss="modal">ADD</button>
      </div>

    </div>
  </div>
</div>





<!-- EDIT CLASS >> UPDATE class INFO model -->
  <div class="modal" id="editclass">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        Change Class Info
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         <input id="class_edit_classname" type="text" class="form-control" placeholder="Class Name" />
         <br>
        <input id="class_edit_password" type="text" class="form-control" placeholder="Password" />
        <br>
        
       <table class="table borderless">
  <thead>
    <tr>
        <td colspan="2"><h4><b>Subjects Included</b></h4></td>
    </tr>
  </thead>
  <!-- Table head -->
  <tbody>
<?php
            $subs = getSubjects();
            $alternate = false;
            if ($subs == false){
//                #INCOMPLETE : SHOW MESSAGE : NO SUBJECTS TO ADD
            } else while ($sub = mysqli_fetch_array($subs)){
                if (!$alternate){ ?>
    <tr>
<?php           } ?>
      <th>
        <div class="custom-control custom-checkbox">
          <input name='changed_subjects[]' value="<?php echo $sub['id']; ?>" type="checkbox" class="custom-control-input" id="SubjectEdit<?php echo $sub['id']; ?>">
          <label class="custom-control-label" for="SubjectEdit<?php echo $sub['id']; ?>"><?php echo $sub['subjectname']; ?></label>
        </div>
      </th>
<?php           if ($alternate){ ?>
    </tr>
<?php           }
                $alternate = !$alternate;
            }
            if ($alternate){ ?>
    </tr>
<?php       } ?>
  </tbody>
</table>

    </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button id="class_edit_submit" type="button" class="btn btn-success" data-dismiss="modal">Update</button>
      </div>

    </div>
  </div>
</div>
      

       
<!--EDIT CLASS >> CLASS ADD MODEL -->
  <div class="modal" id="addclass">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="class_upload.php" method="post">
      <!-- Modal Header -->
      <div class="modal-header">
        Add New Class
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         <input type="text" class="form-control" placeholder="Class Name" name="username"/>
         <br>
        <input type="text" class="form-control" placeholder="Password" name="password"/>
        <br>
        <input type="text" class="form-control" placeholder="Confirm Password" name="password2" />
        <br>
        
       <table class="table borderless">
  <thead>
    <tr>
        <td colspan="2"><h4><b>Subjects To Included</b></h4></td>
    </tr>
  </thead>
  <!-- Table head -->
  <tbody>
<?php
            $subs = getSubjects();
            $alternate = false;
            if ($subs == false){
//                #INCOMPLETE : SHOW MESSAGE : NO SUBJECTS TO ADD - copy from same line existing on top
            } else while ($sub = mysqli_fetch_array($subs)){
                if (!$alternate){ ?>
    <tr>
<?php           } ?>
      <th>
        <div class="custom-control custom-checkbox">
          <input name='subjects[]' value="<?php echo $sub['id']; ?>" type="checkbox" class="custom-control-input" id="Subject<?php echo $sub['id']; ?>">
          <label class="custom-control-label" for="Subject<?php echo $sub['id']; ?>"><?php echo $sub['subjectname']; ?></label>
        </div>
      </th>
<?php           if ($alternate){ ?>
    </tr>
<?php           }
                $alternate = !$alternate;
            }
            if ($alternate){ ?>
    </tr>
<?php       } ?>
  </tbody>
</table>

    </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <input type="submit" class="btn btn-success" value="ADD CLASS" /><!-- data-dismiss="modal" -->
      </div>

  </form>
    </div>
  </div>
</div> 

  
    
     

     
     
     
     
     
     
     
<!-- UPLOAD >>>upload new video -->     
<div id="newupload" class="modal fade " role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       <h3>Upload New Video</h3>
        <button type="button" class="close" data-dismiss="modal">&times;</button>  
      </div>
      <div class="modal-body modal-md">
         <form method="post" action="link_upload.php">
          <center><table class="table-sm"  style="width:400px;height:350px;">
    <tbody>
        <tr>
            <th scope="row">Class</th>
            <td>
                <input list="fetchclasses" name="class" class="form-control" onchange="loadsubjects(this.value)" required/>
                <datalist id="fetchclasses">
<?php
        $classes = getUsers();
        foreach($classes as $class){ ?>
                    <option value="<?php echo $class; ?>"> 
<?php   } ?>
                </datalist>
            </td>
        </tr>
        <tr>
            <th scope="row">Subject</th>
            <td>
                <input list="fetchsubjects" name="subject" class="form-control" requireds>
                <datalist id="fetchsubjects"></datalist>
            </td>
        </tr>
        <tr>
            <th scope="row">Chapter</th>
            <td>
                 <input name="chapter" class="form-control" type="number" required min="0">
            </td>
        </tr>
        <tr>
            <th scope="row">Video Title</th>
            <td>
                <div class="dropdown">
                    <input name="title" class="form-control" type="text" required>
                </div>
            </td>
        </tr>
        <tr>
            <th scope="row">Video Link</th>
            <td>
                <div class="dropdown">
                    <input name="vlink" class="form-control" type="text" required title="Find the Video link by clicking on the share option underneath the YouTube video and copying the link." placeholder="example : https://youtu.be/lJIrF4YjHfQ">
                </div>
            </td>
        </tr>
        <tr>
           <td colspan="2">
                <center><input class="btn btn-success btn-primary btn-lg form-control" type="submit"  value="Upload"></center>
            </td>
        </tr>
    </tbody>
</table>
</center>
</form>
      </div>
    </div>

  </div>
</div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>
  <script>loadsection();</script>
</body>

</html>
<?php
    }
}
?>