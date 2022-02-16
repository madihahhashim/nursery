<!DOCTYPE html>
<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';
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

$status="";
if (isset($_POST['action']) && $_POST['action']=="remove")
{
    if(!empty($_SESSION["shopping_cart"])) 
    {
        foreach($_SESSION["shopping_cart"] as $key => $value) 
        {
            if($_POST["plantcode"] == $key)
            {
                unset($_SESSION["shopping_cart"][$key]);
                $status = "<div class='box' style='color:red;'>
                Product is removed from your cart!</div>";
            }
            if(empty($_SESSION["shopping_cart"]))
            unset($_SESSION["shopping_cart"]);
        }		
    }
}

if (isset($_POST['action']) && $_POST['action']=="change")
{
  foreach($_SESSION["shopping_cart"] as &$value)
  {
    if($value['plantcode'] === $_POST["plantcode"])
    {
        $value['quantity'] = $_POST["quantity"];
        break; // Stop the loop after we've found the product
    }
    }	
}
$arrcart = array();
if(isset($_POST['checkout']))
{
    foreach($_SESSION["shopping_cart"] as &$value)
    {
        array_push($arrcart, $value['plantid']);
        //print_r($value);
    }


    for($i = 0; $i < count($arrcart); $i++) 
    {
        include("connection/connection.php");
        $query = "INSERT INTO orders(custid, plantid) VALUES ( '".$_SESSION['custid']."','".$arrcart[$i]."')";
        if (!mysqli_query($conn, $query)) 
        {
        echo "<script>
        $(document).ready(function(){
        $('#myModal').modal('show');
        });
        </script>";
    
        header("Location: cart.php?op=errkod");
        } 
        else 
        {
        echo "<script>
        $(document).ready(function(){
            $('#myModal').modal('show');
        });
            </script>";
        
        header("Location: shop.php");
        }
        
    }
    $sql = "SELECT * FROM orders join plants on orders.plantid = plants.plantid 
    join customers on orders.custid = customers.custid WHERE  orders.custid = '".$_SESSION['custid']."' ";
    $qry = mysqli_query($dbconn,$sql);
    $r=mysqli_fetch_assoc($qry);

    $orderid = $r['orderid'];
    $custname = $r['custname'];
    $plantcode = $r['plantcode'];
    $plantname = $r['plantname'];
    $price = $r['price'];
    $custphone = $r['custphone'];
    $custemail = $r['custemail'];
  //echo $email;
  // Instantiation and passing `true` enables exceptions
  $mail = new PHPMailer(true);
  
  try  
  {
      //Server settings
     $mail->isSMTP();                                            // Set mailer to use SMTP
          $mail->Host       = 'madihahhashim99@gmail.com';  // Specify main and backup SMTP servers
          $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
          $mail->Username   = 'madihahhashim99@gmail.com';                     // SMTP username
          $mail->Password   = 'abc123';                               // SMTP password
          //$mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
          $mail->Port       =  2525;                                     // TCP port to connect to
  
      //Recipients
  
  
      $mail->setFrom('madihahhashim99@gmail.com', 'Alazea Sdn Bhd');
      $mail->addAddress('$madihahhashim99@gmail.com', 'Customer');     // Add a recipient
  
  
                 // Name is optional
      $mail->addReplyTo('madihahhashim99@gmail.com', 'Detail');
      $mail->addCC('cc@example.com');
      $mail->addBCC('bcc@example.com');
  
      // Attachments
      //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
      //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
  
      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Alazea Sdn Bhd';
  
      $mail->Body = '<html>
                      <body>
                      <h2>Your Detail  for Booking</h2>
  
                      <h1>Your booking has been confirm</h1>
  
                         <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ORDER ID</th>
                                    <th>CUSTOMER NAME</th>
                                    <th>PLANTS CODE</th>
                                    <th>PLANTS NAME</th>
                                    <th>PRICE</th>
  
                                </tr>
                              </thead>
  
                              <tbody>
                                <tr>
                                <td>'.$orderid.'</td>
                                <td>'.$custname.'</td>
                                <td>'.$plantcode.'</td>
                                <td>'.$plantname.'</td>
                                <td>'.$price.'</td>
  
  
                                </tr>
                              </tfoot>
                            </table>
                          </div>
  
                      </body>
                      </html>';
  
      $mail->send();
  
  
        echo"<script language = 'javascript'>
        alert('Message has been sent!');
        window.location='cart.php';</script>";
  
  
  } 
  catch (Exception $e) 
  {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
    session_unset("shopping_cart");
    session_destroy("shopping_cart");
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Nursery Plants Recommendation System</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css">
    <script language="javascript">
  <?php if(isset($_GET['op'])) { ?>
			var document;
			$(document).ready(function(){
				$('#myModal').modal('show');
			});
	<?php } ?>
	</script>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-circle"></div>
        <div class="preloader-img">
            <img src="img/core-img/leaf.png" alt="">
        </div>
    </div>

    <!-- ##### Header Area Start ##### -->
    <header class="header-area">

        <!-- ***** Top Header Area ***** -->
        <div class="top-header-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="top-header-content d-flex align-items-center justify-content-between">
                            <!-- Top Header Content -->
                            <div class="top-header-meta">
                                
                            </div>

                            <!-- Top Header Content -->
                            <div class="top-header-meta d-flex">
                                
                                 <!-- Logout -->
                                 <div class="login">
                                    <a href="index.php"><i class="fa fa-user" aria-hidden="true"></i> <span>Logout</span></a>
                                </div>
                                <!-- Cart -->
                                <?php
                                    if(!empty($_SESSION["shopping_cart"])) 
                                    {
                                        $cart_count = count(array_keys($_SESSION["shopping_cart"]));
                                        ?>
                                        <div class="cart">
                                        <a href="cart.php"><i class="fa fa-shopping-cart" ></i> Cart <span><span class="cart-quantity">(<?php echo $cart_count; ?>)</span></span></a>
                                        
                                        </div>
                                        <?php
                                    }
                                ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ***** Navbar Area ***** -->
        <div class="alazea-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="alazeaNav">

                        <!-- Nav Brand -->
                        <a href="index.php" class="nav-brand"><img src="img/core-img/logo.png" alt=""></a>

                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">

                            <!-- Close Button -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Navbar Start -->
                            <div class="classynav">
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="shop.php">Shop</a></li>
                                    <li><a href="vieworder.php">Order</a></li>
                                </ul>

                                <!-- Search Icon -->
                                <div id="searchIcon">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </div>

                            </div>
                            <!-- Navbar End -->
                        </div>
                    </nav>

                    <!-- Search Form -->
                    <div class="search-form">
                        <form action="#" method="get">
                            <input type="search" name="search" id="search" placeholder="Type keywords &amp; press enter...">
                            <button type="submit" class="d-none"></button>
                        </form>
                        <!-- Close Icon -->
                        <div class="closeIcon"><i class="fa fa-times" aria-hidden="true"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(img/bg-img/24.jpg);">
            <h2>Cart</h2>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->

    <!-- ##### Shop Area Start ##### -->
    <section class="shop-page section-padding-0-100">
        <div class="container">
            <div class="row">
                <!-- Shop Sorting Data -->
                <div class="col-12">
                    <div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Sidebar Area -->
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="shop-sidebar-area">

                    </div>
                </div>
                <div class="cart">
                    <?php
                    if(isset($_SESSION["shopping_cart"])){
                        $total_price = 0;
                    ?>	
                    <table class="table">
                    <tbody>
                    <tr>
                    <td></td>
                    <td>PLANT NAME</td>
                    <td>QUANTITY</td>
                    <td>UNIT PRICE</td>
                    <td>ITEMS TOTAL</td>
                    </tr>	
                    <?php		
                    foreach ($_SESSION["shopping_cart"] as $product){
                    ?>
                    <tr>
                    <td>
                    <img src="img/bg-img/<?php echo $product["images"]; ?>" style="width:200px;height:200px;" />
                    </td>
                    <td><?php echo $product["plantname"]; ?><br />
                    <form method='post' action=''>
                    <input type='hidden' name='plantcode' value="<?php echo $product["plantcode"]; ?>" />
                    <input type='hidden' name='action' value="remove" />
                    <button type='submit' class='btn btn-danger btn-user btn-block'>Remove Item</button>
                    </form>
                    </td>
                    <td>
                    <form method='post' action=''>
                    <input type='hidden' name='plantcode' value="<?php echo $product["plantcode"]; ?>" />
                    <input type='hidden' name='action' value="change" />
                    <select name='quantity' class='quantity' onChange="this.form.submit()">
                    <option <?php if($product["quantity"]==1) echo "selected";?>
                    value="1">1</option>
                    <option <?php if($product["quantity"]==2) echo "selected";?>
                    value="2">2</option>
                    <option <?php if($product["quantity"]==3) echo "selected";?>
                    value="3">3</option>
                    <option <?php if($product["quantity"]==4) echo "selected";?>
                    value="4">4</option>
                    <option <?php if($product["quantity"]==5) echo "selected";?>
                    value="5">5</option>
                    </select>
                    </form>
                    </td>
                    <td><?php echo "$".$product["price"]; ?></td>
                    <td><?php echo "$".$product["price"]*$product["quantity"]; ?></td>
                    </tr>
                    <?php
                    $total_price += ($product["price"]*$product["quantity"]);
                    }
                    ?>
                    <tr>
                    <td colspan="5" align="right">
                    <strong>TOTAL: <?php echo "$".$total_price; ?></strong>
                    </td>
                    </tr>
                    </tbody>
                    </table>
                    <form method='post' action='cart.php'>	
                        <button type="submit" class="btn btn-primary btn-user btn-block" name='checkout'>Checkout</button>
                    </form>
                    <?php
                    }else{
                        echo "<h3>Your cart is empty!</h3>";
                        }
                    ?>
                    </div>

                    <div style="clear:both;"></div>

                    <div class="message_box" style="margin:10px 0px;">
                    <?php echo $status; ?>
                    </div>
                
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Shop Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area bg-img" style="background-image: url(img/bg-img/3.jpg);">
        <!-- Main Footer Area -->
        <div class="main-footer-area">
            <div class="container">
                <div class="row">

                    <!-- Single Footer Widget -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="single-footer-widget">
                            <div class="footer-logo mb-30">
                                <a href="#"><img src="img/core-img/logo.png" alt=""></a>
                            </div>
                            <p>Lorem ipsum dolor sit samet, consectetur adipiscing elit. India situs atione mantor</p>
                            <div class="social-info">
                                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Single Footer Widget -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="single-footer-widget">
                            <div class="widget-title">
                                <h5>QUICK LINK</h5>
                            </div>
                            <nav class="widget-nav">
                                <ul>
                                    <li><a href="#">Purchase</a></li>
                                    <li><a href="#">FAQs</a></li>
                                    <li><a href="#">Payment</a></li>
                                    <li><a href="#">News</a></li>
                                    <li><a href="#">Return</a></li>
                                    <li><a href="#">Advertise</a></li>
                                    <li><a href="#">Shipping</a></li>
                                    <li><a href="#">Career</a></li>
                                    <li><a href="#">Orders</a></li>
                                    <li><a href="#">Policities</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    

                    <!-- Single Footer Widget -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="single-footer-widget">
                            <div class="widget-title">
                                <h5>CONTACT</h5>
                            </div>

                            <div class="contact-information">
                                <p><span>Address:</span> 505 Silk Rd, New York</p>
                                <p><span>Phone:</span> +1 234 122 122</p>
                                <p><span>Email:</span> info.deercreative@gmail.com</p>
                                <p><span>Open hours:</span> Mon - Sun: 8 AM to 9 PM</p>
                                <p><span>Happy hours:</span> Sat: 2 PM to 4 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom Area -->
        <div class="footer-bottom-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="border-line"></div>
                    </div>
                    <!-- Copywrite Text -->
                    <div class="col-12 col-md-6">
                        <div class="copywrite-text">
                            <p>&copy; <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
</p>
                        </div>
                    </div>
                    <!-- Footer Nav -->
                    <div class="col-12 col-md-6">
                        <div class="footer-nav">
                            <nav>
                                <ul>
                                    <li><a href="#">Home</a></li>
                                    <li><a href="#">About</a></li>
                                    <li><a href="#">Service</a></li>
                                    <li><a href="#">Portfolio</a></li>
                                    <li><a href="#">Blog</a></li>
                                    <li><a href="#">Contact</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->
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
    <!-- ##### All Javascript Files ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins js -->
    <script src="js/plugins/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>
</body>

</html>