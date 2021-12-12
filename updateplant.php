<!DOCTYPE html>
<?php
function modalTitle($op)
{
  if($op == 'success')
    $title = 'Berjaya!';
  else
    $title = 'Amaran!';

  return $title;
}
function modalMessage($op)
{
  if($op == 'success')
    $msg = 'Data telah berjaya dikemaskini.';
  else if($op == 'errkod')
    $msg = 'Data tidak berjaya dikemaskini.';

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
  $placeid =$_POST['placeid'];
  $typeid =$_POST['typeid'];
  $sizeid =$_POST['sizeid'];
  $adminid =$_POST['adminid'];
  $curtime = date("Y-m-d H:i:s");


  $query = "UPDATE plants SET  plantcode = '$plantcode', plantname = '$plantname', descriptions='$descriptions', price = '$price', rating='$rating',
             placeid=$placeid, typeid=$typeid, sizeid=$sizeid, adminid=$adminid, updatetime = '".$curtime."' WHERE plantid = $plantid";
  //echo $query;
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

?>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Nursery Plants Recommendation System</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="indexadmin.php">Admin</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="login.html">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="indexadmin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Nursery
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="adminupload.php">Add New Plants</a>
                                    <a class="nav-link" href="viewplant.php">View Plants</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    &nbsp;
                <div class="container-fluid">
          
                    <!-- DataTales Example -->
                    <div class="shadow mb-4">
                        <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">UPDATE PLANTS</h6>
                        </div>
                        <div class="card-body">
                    
                        <form name="login" class="user" method="post" action = "updateplant.php">
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
                            
                            <div class="form-group" style="width: 100%" class="btn-lg justify-content-center">
                            <input type="submit" name="update"  value="Update" class="btn btn-warning text-white" onclick="return Confirm()"/>
                            <input type="submit" name="delete"  value="Delete" class="btn btn-danger text-white" onclick="return Confirm()"/>
                            </div>
                            
                            
                            </form>
                        </div>
                        </div>
                        <div class="row-fluid">
                        <!-- /.container-fluid -->
                        <!-- display successful modal -->
                            <div id="myModal" class="modal fade">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">
                                                <?php if(isset($_GET['op'])) { echo modalTitle($_GET['op']); } ?>
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            <p><?php if(isset($_GET['op'])) { echo modalMessage($_GET['op'], $_GET['tot'], $_GET['ins'], $_GET['upd']); } ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- end modal -->

                        </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
