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
    }
    function show3(){
        document.getElementById("links").style.display = "inline"; 
        document.getElementById("statistics").style.display = "none"; 
        document.getElementById("classes").style.display = "none"; 
        document.getElementById("subjects").style.display = "none";
    }
    function show4(){
        document.getElementById("links").style.display = "none"; 
        document.getElementById("statistics").style.display = "none"; 
        document.getElementById("classes").style.display = "inline"; 
        document.getElementById("subjects").style.display = "none";
    }
    function show5(){
        document.getElementById("links").style.display = "none"; 
        document.getElementById("statistics").style.display = "none"; 
        document.getElementById("classes").style.display = "none"; 
        document.getElementById("subjects").style.display = "inline";
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
            params = encodeURIComponent('chapter')+'='+encodeURIComponent(chapter.value)+'&'+
                encodeURIComponent('title')+'='+encodeURIComponent(title.value)+'&'+
                encodeURIComponent('link')+'='+encodeURIComponent(link.value)+'&'+
                encodeURIComponent('id')+'='+encodeURIComponent(vidid);
            ajax.onreadystatechange = function(){
                //exit if data not ready
                if (!(this.readyState == 4 && this.status == 200)) return;
                var result = this.responseText.split('<br>');
                if (result[0] == 'edit success'){
                    for (x of result) console.log(x);
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
            console.log('edit : '+vidid);
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
            ajax.open("get", "link_delete.php?id="+vidid);
            ajax.send();
            console.log('delete : '+vidid);
        };
    }
    function loadsection(){
        url = window.location.href;
//        console.log(url.split('#')[1])
        switch (url.split('#')[1]){
            case 'statistics':
                show1();
                break;
            case 'links':
                show3();
                break;
            case 'classes':
                show4();
                break;
            case 'subjects':
                show5();
                break;
            default:
                break;
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
          <span>EDIT CLASS</span></a>
      </li>
      <hr class="sidebar-divider my-0">
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link"  href="#subjects" onclick="show5()">
          <i class="fas fa-fw fa-cog"></i>
          <span>EDIT SUBJECTS</span></a>
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
          <h3>St. ALOYSIUS ENGLISH MEDIUM SCHOOL TANIKALLA</h3>
          <ul class="navbar-nav ml-auto">

           
            <div class="topbar-divider d-none d-sm-block"></div>
            
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Principal</span>
                <img class="img-profile rounded-circle " src="../img/thumpnail.png"> 
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#myModal1">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout</a>
              </div>
            </li>
          </ul>
        </nav>

       
<!--Stastictis page -->
        <div class="container-fluid" id="statistics" name="section" style="display: inline;">

          <!-- Page Heading -->
          Stastictis page
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
            $links = getLinks();
            if ($links == false){
//                #INCOMPLETE NO LINKS HAVE BEEN ADDED
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
<!--      <th scope="col">SINO</th>-->
      <th scope="col">CLASS LOGIN ID</th>
      <th scope="col">PASSWORD</th>
      <th scope="col">ACTION</th>
    </tr>
  </thead>
  <tbody>
<?php
            $classes = getUsers(false);
            if ($links == false){
//                #INCOMPLETE NO CLASSES HAVE BEEN ADDED
            } else while ($class = mysqli_fetch_array($classes)){ ?>
    <tr>
<!--      <th scope="row">1</th>-->
      <td><?php echo $class['username']; ?></td>
      <td><?php echo $class['password']; ?></td>
      <td><input type="button" class="btn btn-info" value="Edit" data-toggle="modal" data-target="#editclass" />
          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal5">Delete</button>
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

           <B><div id="accordion" class="accordion">
        <div class="card mb-0">
            <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
                        <b>Class LKG</b>
            </div>
            <div id="collapseOne" class="card-body collapse" data-parent="#accordion"> 
                <table><tr>
                       <td>Subject 1</td>
                       <td style="width:150px;"><center><button type="button" class="btn btn-danger">Delete</button></center></td>
                   </tr></table>
            </div>
             <div id="collapseOne" class="card-body collapse" data-parent="#accordion" > 
                <table><tr>
                       <td>Subject 2</td>
                       <td style="width:150px;"><center><button type="button" class="btn btn-danger">Delete</button></center></td>
                   </tr></table>
            </div>
            <div id="collapseOne" class="card-body collapse" data-parent="#accordion" > 
               <table><tr>
                       <td>Subject 3</td>
                       <td style="width:150px;"><center><button type="button" class="btn btn-danger">Delete</button></center></td>
                   </tr></table>
            </div>
            <div id="collapseOne" class="card-body collapse" data-parent="#accordion" > 
            <button type="button" class="btn btn-success" align="left" data-toggle="modal" data-target="#addsubject">ADD SUBJECTS</button>
            </div>
            <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                <b>Class UKG</b>
            </div>
            <div id="collapseTwo" class="card-body collapse" data-parent="#accordion"> 
                <table><tr>
                       <td>Subject 1</td>
                       <td style="width:150px;"><center><button type="button" class="btn btn-danger">Delete</button></center></td>
                   </tr></table>
            </div>
             <div id="collapseTwo" class="card-body collapse" data-parent="#accordion"> 
                <table><tr>
                       <td>Subject 2</td>
                       <td style="width:150px;"><center><button type="button" class="btn btn-danger">Delete</button></center></td>
                   </tr></table>
            </div>
             <div id="collapseTwo" class="card-body collapse" data-parent="#accordion"> 
               <table><tr>
                       <td>Subject 3</td>
                       <td style="width:150px;"><center><button type="button" class="btn btn-danger">Delete</button></center></td>
                   </tr></table>
            </div>
            <div id="collapseTwo" class="card-body collapse" data-parent="#accordion" > 
            <button type="button" class="btn btn-success" align="left" data-toggle="modal" data-target="#addsubject">ADD SUBJECTS</button>
            </div>
        </div>
    </div></B>
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
            <th scope="row">Select class</th>
            <td>
                <input disabled name="classname" class="form-control" id="link_edit_classname" required/>
            </td>
        </tr>
        <tr>
            <th scope="row">Select subject</th>
            <td>
                <input disabled name="subjectname" class="form-control" id="link_edit_subjectname" required>
            </td>
        </tr>
        <tr>
            <th scope="row">Select chapter</th>
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
                    <input name="vlink" class="form-control" type="text" id="link_edit_link" required>
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
  
  
<!-- EDIT CLASS >> delete model -->
  <div class="modal" id="myModal5">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Do you want to remove this class ??
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
      </div>

    </div>
  </div>
</div>
   
 <!-- subject add model -->
  <div class="modal" id="addsubject">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        Add Subject
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <input type="text" class="form-control" placeholder="SUBJECT NAME" />
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">ADD</button>
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
         <input type="text" class="form-control" placeholder="Enter new class ID" />
         <br>
        <input type="text" class="form-control" placeholder="Enter new Password" />
        <br>
        
       <table class="table borderless">
  <thead>
    <tr>
        <td colspan="2"><h4><b>Subjects Included</b></h4></td>
    </tr>
  </thead>
  <!-- Table head -->
  <tbody>
   <tr>
      <th>
        <!-- Default unchecked -->
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck1">
          <label class="custom-control-label" for="tableDefaultCheck1">Subject 1</label>
        </div>
      </th>
      <th><div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck2">
          <label class="custom-control-label" for="tableDefaultCheck2">Subject 2</label>
        </div>
      </th>
    </tr>
    <tr>
       <th>
        <!-- Default unchecked -->
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck3">
          <label class="custom-control-label" for="tableDefaultCheck3">Subject 3</label>
        </div>
      </th>
      <th><div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck4">
          <label class="custom-control-label" for="tableDefaultCheck4">Subject 4</label>
        </div>
      </th>
    </tr>
    <tr>
       <th>
        <!-- Default unchecked -->
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck5">
          <label class="custom-control-label" for="tableDefaultCheck5">Subject 5</label>
        </div>
      </th>
      <th><div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck6" >
          <label class="custom-control-label" for="tableDefaultCheck6">Subject 6</label>
        </div>
      </th>
    </tr>
    <tr>
       <th>
        <!-- Default unchecked -->
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck7">
          <label class="custom-control-label" for="tableDefaultCheck7">Subject 7</label>
        </div>
      </th>
      <th><div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="tableDefaultCheck8" >
          <label class="custom-control-label" for="tableDefaultCheck8">Subject 8</label>
        </div>
      </th>
    </tr>
  </tbody>
</table>

    </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Update</button>
      </div>

    </div>
  </div>
</div>
      

       
<!--EDIT CLASS >> CLASS ADD MODEL -->
  <div class="modal" id="addclass">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="class_add.php" method="post">
      <!-- Modal Header -->
      <div class="modal-header">
        Add New Class
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
         <input type="text" class="form-control" placeholder="Enter new class ID" />
         <br>
        <input type="text" class="form-control" placeholder="Enter new Password" />
        <br>
        <input type="text" class="form-control" placeholder="Re-enter Password" />
        <br>
        
       <table class="table borderless">
  <thead>
    <tr>
        <td colspan="2"><h4><b>Subjects To Included</b></h4></td>
    </tr>
  </thead>
  <!-- Table head -->
  <tbody>
   <tr>
      <th>
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="Check1">
          <label class="custom-control-label" for="Check1">Subject 1</label>
        </div>
      </th>
      <th><div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="Check2">
          <label class="custom-control-label" for="Check2">Subject 2</label>
        </div>
      </th>
    </tr>
    <tr>
       <th>
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="Check3">
          <label class="custom-control-label" for="Check3">Subject 3</label>
        </div>
      </th>
      <th><div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="Check4">
          <label class="custom-control-label" for="Check4">Subject 4</label>
        </div>
      </th>
    </tr>
    <tr>
       <th>
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="Check5">
          <label class="custom-control-label" for="Check5">Subject 5</label>
        </div>
      </th>
      <th><div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="Check6" >
          <label class="custom-control-label" for="Check6">Subject 6</label>
        </div>
      </th>
    </tr>
    <tr>
       <th>
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="Check7">
          <label class="custom-control-label" for="Check7">Subject 7</label>
        </div>
      </th>
      <th><div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="Check8" >
          <label class="custom-control-label" for="Check8">Subject 8</label>
        </div>
      </th>
    </tr>
  </tbody>
</table>

    </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">ADD CLASS</button>
      </div>

  </form>
    </div>
  </div>
</div>   
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
            <th scope="row">Select class</th>
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
            <th scope="row">Select subject</th>
            <td>
                <input list="fetchsubjects" name="subject" class="form-control" requireds>
                <datalist id="fetchsubjects"></datalist>
            </td>
        </tr>
        <tr>
            <th scope="row">Select chapter</th>
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
                    <input name="vlink" class="form-control" type="text" required>
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