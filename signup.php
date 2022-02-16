<!DOCTYPE html>
<?php


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
		$msg = 'Customer data has been saved successfully.';
	else if($op == 'errkod')
		$msg = 'Customer data already exists. Please try again.';

	return $msg;
}

if(isset($_POST['submit']))
{
  include("connection/connection.php");

    $custcode =$_POST['custcode'];
    $custname =strtoupper($_POST['custname']);
    $custaddress = $_POST['custaddress'];
    $custemail = $_POST['custemail'];
    $custpassword =$_POST['custpassword'];
    $custphone =$_POST['custphone'];

  $duplicate = "SELECT custcode FROM customers WHERE custcode = '".$custcode."'";
  $check = mysqli_query($conn,$duplicate);
  $checkrows = mysqli_num_rows($check);
  echo $duplicate;
  echo $checkrows;
  if ($checkrows > 0)
  {
    header("Location: signup.php?op=errkod");
    return false;
  }
  else
  {
    $query = "INSERT INTO customers( custcode, custname, custaddress, custphone, custemail, custpassword)VALUES( '$custcode','$custname','$custaddress','$custphone','$custemail','$custpassword')";
  }

  if (!mysqli_query($conn, $query)) 
  {
    echo "<script>
  $(document).ready(function(){
    $('#myModal').modal('show');
  });
    </script>";

    header("Location: signup.php?op=errkod");
  } 
  else 
  {
    echo "<script>
    $(document).ready(function(){
      $('#myModal').modal('show');
    });
      </script>";

  header("Location: logincustomer.php");
  }

  //echo $query;
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
                    <div class="col-lg-5 d-none d-lg-block "><img src="img/bg-img/36.jpg" alt="" style="width:500px;height:570px;"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>
                            <form name="registercust" action="signup.php" method="post">
                            <div class="form-group">
                               <input type="text" class="form-control form-control-user" name="custcode" placeholder="User Name">
                             </div>
                             <div class="form-group">
                               <input type="text" class="form-control form-control-user" name="custname" placeholder="Full Name">
                             </div>
                           <div class="form-group">
                             <input type="text" class="form-control form-control-user" name="custaddress" placeholder="Address">
                           </div>
                           
                           <div class="form-group">
                               <input type="number" class="form-control form-control-user" name="custphone" placeholder="Phone Number (Without '-')">
                             </div>
                             <div class="form-group">
                               <input type="email" class="form-control form-control-user" name="custemail" placeholder="Email Address">
                             </div>
                           <div class="form-group">
                             <input type="password" class="form-control form-control-user" name="custpassword" placeholder="Password">
                           </div>
                           
                           <button type="submit" class="btn btn-primary btn-user btn-block" name='submit'>Register Account</button>

                          </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="logincustomer.php">Already have an account? Login!</a>
                            </div>
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
            <?php if(isset($_GET['op'])) { echo modalTitle($_GET['op']); } ?>
        </h4>
        </div>
        <div class="modal-body">
            <p><?php if(isset($_GET['op'])) { echo modalMessage($_GET['op']); } ?></p>
        </div>
          </button>
          <div class="modal-footer">
          <button class="btn btn-warning" type="button" data-dismiss="modal">OK</button>
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
     <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

</body>

</html>