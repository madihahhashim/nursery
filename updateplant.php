<!DOCTYPE html>
<?php
session_start();
function modalTitle($op)
{
  if($op == 'success')
    $title = 'Success!';
  else
    $title = 'Warning!';

  return $title;
}
function modalMessage($op)
{
  if($op == 'success')
    $msg = 'Image uploaded successfully';
  else if($op == 'errkod')
    $msg = 'Failed to upload image';

  return $msg;
}

function modalDelTitle($del)
{
  if($del == 'success')
    $title = 'Berjaya!';
  else
    $title = 'Amaran!';

  return $title;
}
function modalDelMessage($del)
{
  if($del == 'success')
    $msg = 'Data telah berjaya dipadam.';
  else if($del == 'errkod')
    $msg = 'Data tidak berjaya dipadam.';

  return $msg;
}

$message = "";
 if(isset($_GET['plantid']))
 {
   include("connection/connection.php");
   //include("secure/encrypt_decrypt.php");
   $plantid = $_GET['plantid'];
   $sql = "SELECT * FROM plants WHERE plantid = $plantid";
   
   $qry = mysqli_query($conn, $sql);
   $resultb = mysqli_fetch_assoc($qry);
   //echo $resultb;
 }

if(isset($_POST['update']))
{
  include("connection/connection.php");
  $plantcode = strtoupper($_POST['plantcode']);
  $plantid = $_POST['plantid'];
  $plantname = strtoupper($_POST['plantname']);
  $descriptions = $_POST['descriptions'];
  $price =$_POST['price'];
  $rating =$_POST['rating'];
  //$image =$_POST['image'];
  $placeid =$_POST['placeid'];
  $typeid =$_POST['typeid'];
  $sizeid =$_POST['sizeid'];
  $adminid =$_POST['adminid'];
  $curtime = date("Y-m-d H:i:s");


  $query = "UPDATE plants SET  plantcode = '$plantcode', plantname = '$plantname', descriptions='$descriptions', price = '$price', rating='$rating', 
             placeid=$placeid, typeid=$typeid, sizeid=$sizeid, adminid=$adminid, updatetime = '".$curtime."' WHERE plantid = $plantid";
  //echo $query;
  
    if(!mysqli_query($conn, $query)) 
    {
    echo "<script>
        $(document).ready(function(){
        $('#update-confirm').modal('show');
        });
        </script>";
        header("Location: viewplant.php?op=errkod");
    } 
    else 
    {
    echo "<script>
    $(document).ready(function(){
        $('#update-confirm').modal('show');
    });
        </script>";

        header("Location: viewplant.php?op=success");
    }
}
else if(isset($_POST['delete']))
{
  include("connection/connection.php");

  $plantcode = strtoupper($_POST['plantcode']);
  $plantid = $_POST['plantid'];
  $plantname = strtoupper($_POST['plantname']);
  $descriptions = $_POST['descriptions'];
  $price =$_POST['price'];
  $rating =$_POST['rating'];
  $placeid =$_POST['placeid'];
  $typeid =$_POST['typeid'];
  $sizeid =$_POST['sizeid'];
  $adminid =$_POST['adminid'];


  $query = "DELETE FROM plants WHERE plantid = $plantid";
  echo $query;
    if (!mysqli_query($conn, $query)) 
    {
    echo "<script>
        $(document).ready(function(){
        $('#update-confirm').modal('show');
        });
        </script>";

    header("Location: viewplant.php?op=errkod");
    } 
    else 
    {
    echo "<script>
    $(document).ready(function(){
        $('#update-confirm').modal('show');
    });
        </script>";

    header("Location: viewplant.php?op=success");
    }
}
else if(isset($_POST['upload'])) 
{ 
  
// If upload button is clicked ...
  $filename = $_FILES["uploadfile"]["name"];
  $tempname = $_FILES["uploadfile"]["tmp_name"];    
      $folder = "C:/xampp/htdocs/nursery/img/image/".$filename;
        
      include("connection/connection.php");
      $plantid = $_POST['plantid'];
      // Get all the submitted data from the form
      $sql = "UPDATE plants SET  image = '$filename' WHERE plantid = $plantid";

      // Execute query
      mysqli_query($conn, $sql);
        
      // Now let's move the uploaded image into the folder: image
      if (move_uploaded_file($tempname, $folder))  
      {
          $message = "Image uploaded successfully";
      }
      else
      {
          $message = "Failed to upload image";
      }
}
//$result = mysqli_query($conn, "SELECT * FROM plants");

?>
    
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Title -->
    <title>Nursery Plants Recommendation System</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>

        #img_div{
            width: 80%;
            padding: 5px;
            margin: 15px auto;
            border: 1px solid #cbcbcb;
        }
        #img_div:after{
            content: "";
            display: block;
            clear: both;
        }
        img{
            float: left;
            margin: 5px;
            width: 300px;
            height: 140px;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="indexadmin.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img class="icon-circle" src="img/core-img/favicon.ico">
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>


            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="indexadmin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                
            </div>

             <!-- Nav Item - Pages Collapse Menu -->
             <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Plants</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="uploadplant.php">Add new plants</a>
                        <a class="collapse-item" href="viewplant.php">List plants</a>
                    </div>
                </div>
            </li>




            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                       

                         <!-- Nav Item - User Information -->
                         <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Hi <?php echo $_SESSION['adname']; ?>!</span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Update Plants</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                        <form  method="post" action = "updateplant.php" enctype="multipart/form-data">
                        <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="plantid"  value="<?php echo $resultb['plantid']; ?>"  required >
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="plantcode"  value="<?php echo $resultb['plantcode']; ?>"  required >
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="plantname"  value="<?php echo $resultb['plantname']; ?>"  required >
                            </div>
                            <div class="form-group">
                                <select class="select2 form-control custom-select" placeholder="Type" name="typeid" value="<?php echo $resultb['typeid']; ?>">
                                <option>TYPE</option>
                                    <?php
                                        include("connection/connection.php");
                                        $sql ="SELECT * FROM types";
                                        $qry = mysqli_query($conn, $sql);
                                        $row3 = mysqli_num_rows($qry);
                                        if($row3 > 0)
                                        {
                                            while($r = mysqli_fetch_assoc($qry))
                                            {
                                                if($resultb['typeid'] == $r['typeid'])
                                                echo "<option value='".$r['typeid']."' selected>".$r['typename']." </option>";
                                                else {
                                                echo "<option value='".$r['typeid']."'>".$r['typename']." </option>";
                                                }
                                            }
                                        }
                                            ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="select2 form-control custom-select"  name="placeid" value="<?php echo $resultb['placeid']; ?>">
                                <option>PLACE</option>   
                                        <?php
                                        include("connection/connection.php");
                                        $sql ="SELECT * FROM place";
                                        $qry = mysqli_query($conn, $sql);
                                        $row4 = mysqli_num_rows($qry);
                                        if($row4 > 0)
                                        {
                                            while($r = mysqli_fetch_assoc($qry))
                                            {
                                            
                                                if($resultb['placeid'] == $r['placeid'])
                                                echo "<option value='".$r['placeid']."' selected>".$r['placename']." </option>";
                                                else {
                                                echo "<option value='".$r['placeid']."'>".$r['placename']." </option>";
                                                }
                                            
                                            }
                                        }
                                            ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="select2 form-control custom-select"  name="sizeid" value="<?php echo $resultb['sizeid']; ?>">
                                <option>SIZE</option>   
                                        <?php
                                        include("connection/connection.php");
                                        $sql ="SELECT * FROM sizes";
                                        $qry = mysqli_query($conn, $sql);
                                        $row4 = mysqli_num_rows($qry);
                                        if($row4 > 0)
                                        {
                                            while($r = mysqli_fetch_assoc($qry))
                                            {
                                            
                                                if($resultb['sizeid'] == $r['sizeid'])
                                                echo "<option value='".$r['sizeid']."' selected>".$r['sizename']." </option>";
                                                else {
                                                echo "<option value='".$r['sizeid']."'>".$r['sizename']." </option>";
                                                }
                                            
                                            }
                                        }
                                            ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="descriptions" placeholder="DESCRIPTIONS" value="<?php echo $resultb['descriptions']; ?>" required >
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="price" placeholder="PRICE" value="<?php echo $resultb['price']; ?>" required >
                            </div>
                            <div class="form-group">
                                <input type="text"  class="form-control form-control-user" name="rating" placeholder="RATING" value="<?php echo $resultb['rating']; ?>" required >
                            </div>
                            <div class="form-group">
                                <select class="select2 form-control custom-select"  name="adminid" value="<?php echo $resultb['adminid']; ?>">
                                <option>ADMIN</option>
                                    
                                    <?php
                                        include("connection/connection.php");
                                        $sql ="SELECT * FROM admin";
                                        $qry = mysqli_query($conn, $sql);
                                        $row2 = mysqli_num_rows($qry);
                                        if($row2 > 0)
                                        {
                                            while($r = mysqli_fetch_assoc($qry))
                                            {
                                            if($resultb['adminid'] == $r['adminid'])
                                                echo "<option value='".$r['adminid']."' selected>".$r['adname']." </option>";
                                                else {
                                                echo "<option value='".$r['adminid']."'>".$r['adname']." </option>";
                                                }
                                        }
                                        }
                                    ?>
                                </select>
                            </div>
                                <input type="file" name="uploadfile" value=""/>
                                    
                                <div>
                                    <button type="submit" name="upload">UPLOAD</button>
                                    </div>
                            <div class="form-group" style="width: 100%" class="btn-lg justify-content-center">
                            <input type="submit" name="update"  value="Update" class="btn btn-warning text-white" onclick="return Confirm()"/>
                            <input type="submit" name="delete"  value="Delete" class="btn btn-danger text-white" onclick="return Confirm()"/>
                            </div>
                            
                            
                            </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!--  Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title">
									<?php if(isset($_GET['op'])) { echo modalTitle($_GET['op']); } ?>
								</h4>
							</div>
							<div class="modal-body">
								<p><?php if(isset($_GET['op'])) { echo modalMessage($_GET['op']); } ?></p>
							</div>
          </button>
          <div class="modal-footer">
          <button class="btn btn-danger" type="button" data-dismiss="modal">OK</button>
        </div>
        </div>
       
    </div>
  </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>