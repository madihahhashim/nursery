<!DOCTYPE html>
<?php
function loginTitle($op)
{
  if($op == 'errkod')
    $title = 'Warning!';

  return $title;
}
function loginMessage($op)
{
 
  if($op == 'errkod')
    $msg = 'Incorrect Email/Password';

  return $msg;
}
if(isset($_POST['login']))
{
    include("connection/connection.php");

    $admincode = $_POST['admincode'];
    $addpassword = $_POST['addpassword'];

    $sql = "SELECT * FROM admin WHERE admincode = '".$admincode."' AND addpassword = $addpassword";

    //echo $sql;
    $qry  = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($qry);
    //echo $row;
    if($row > 0)
    {
      session_start();
        $data = mysqli_fetch_assoc($qry);
        
	
		$_SESSION['adminid'] = $data['adminid'];
		$_SESSION['userlogged'] = 1;
		$_SESSION['adname'] = $data['adname'];
        header("Location: indexadmin.php");
       

    }
    else {
      "<script>
      $(document).ready(function(){
        $('#myModal').modal('show');
      });
        </script>";
        header("Location: loginadmin.php?op=errkod");
    }
    
}
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

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="vendor/jquery/jquery.min.js"></script>
 <script language="javascript">
  <?php if(isset($_GET['op'])) { ?>
			var document;
			$(document).ready(function(){
				$('#myModal').modal('show');
			});
	<?php } ?>
	</script>
</head>

<body class="bg-gradient-primary">

    <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"><img src="img/bg-img/17.jpg" alt="" style="width:460px;height:400px;"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                        </div>
                        <form name="loginformcust" action="loginadmin.php" method="post">
                        <div class="form-group">
                          <input type="text" class="form-control " placeholder="Username" name="admincode" required="required">
                        </div>
                        <div class="form-group">
                          <input type="password" class="form-control " placeholder="Password" name="addpassword" required="required">
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block" name='login'>Login</button>
                        <br>

                      </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
  
      <!--  Modal-->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <?php if(isset($_GET['op'])) { echo loginTitle($_GET['op']); } ?>
          </h4>
				</div>
        <div class="modal-body">
          <p><?php if(isset($_GET['op'])) { echo loginMessage($_GET['op']); } ?></p>
        </div>
          </button>
          <div class="modal-footer">
            <button class="btn btn-danger" type="button" data-dismiss="modal">OK</button>
          </div>
      </div>
    </div>
  </div>
      <!--End modal -->
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>