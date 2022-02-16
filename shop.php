<!DOCTYPE html>
<?php
session_start();
include("connection/connection.php");
include("secure/encrypt_decrypt.php");
$status="";

    if (isset($_POST['plantcode']) && $_POST['plantcode']!="")
    {
        $plantcode = $_POST['plantcode'];
        $result = mysqli_query($conn,"SELECT * FROM plants WHERE plantcode='$plantcode'");
        $row = mysqli_fetch_assoc($result);
        $plantid = $row['plantid'];
        $plantname = $row['plantname'];
        $plantcode = $row['plantcode'];
        $price = $row['price'];
        $images = $row['images'];

        $cartArray = array(
            $plantcode=>array(
            'plantid'=>$plantid,
            'plantname'=>$plantname,
            'plantcode'=>$plantcode,
            'price'=>$price,
            'quantity'=>1,
            'images'=>$images)
        );

        if(empty($_SESSION["shopping_cart"])) {
            $_SESSION["shopping_cart"] = $cartArray;
            $status = "<div class='box'>Product is added to your cart!</div>";
        }
        else
        {
            $array_keys = array_keys($_SESSION["shopping_cart"]);
            if(in_array($plantcode,$array_keys)) {
            $status = "<div class='box' style='color:red;'>
            Product is already added to your cart!</div>";	
            } else {
            $_SESSION["shopping_cart"] = array_merge(
            $_SESSION["shopping_cart"],
            $cartArray
            );
            $status = "<div class='box'>Product is added to your cart!</div>";
            }

        }
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
            <h2>Shop</h2>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Shop</li>
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
                        <!-- Shop Page Count -->
                        <div class="shop-page-count">
                            <p>Showing 1–9 of 72 results</p>
                        </div>
                        <!-- Search by Terms -->
                        <div class="search_by_terms">
                            <form action="#" method="post" class="form-inline">
                                <select class="custom-select widget-title">
                                  <option selected>Short by Popularity</option>
                                  <option value="1">Short by Newest</option>
                                  <option value="2">Short by Sales</option>
                                  <option value="3">Short by Ratings</option>
                                </select>
                                <select class="custom-select widget-title">
                                  <option selected>Show: 9</option>
                                  <option value="1">12</option>
                                  <option value="2">18</option>
                                  <option value="3">24</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Sidebar Area -->
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="shop-sidebar-area">
                        
                    <h4 class="widget-title">Categories</h4>
                    <!-- Divider -->
                        <hr class="sidebar-divider d-none d-md-block">
                    <form  method="post" action = "filter.php" >
                        <!-- Shop Widget -->
                        <div >
                            <h4 class="widget-title">Types</h4>
                            <br>
                            <input type="radio" id="flower" name="typeid" value="2">
                            <label for="flower">Flowers</label><br>
                            <input type="radio" id="tree" name="typeid" value="1">
                            <label for="tree">Trees</label><br>
                            <input type="radio" id="herb" name="typeid" value="3">
                            <label for="herb">Herbs</label>
                        </div>
                        <br>

                        <!-- Divider -->
                        <hr class="sidebar-divider d-none d-md-block">

                        <!-- Shop Widget -->
                        <div >                       
                            <h4 class="widget-title">Places</h4>
                            <br>
                            <input type="radio" id="indoor" name="placeid" value="1">
                            <label for="indoor">Indoor Plant</label><br>
                            <input type="radio" id="outdoor" name="placeid" value="2">
                            <label for="outdoor">Outdoor Plant</label>
                        </div>
                        <br>

                        <!-- Divider -->
                        <hr class="sidebar-divider d-none d-md-block">

                        <!-- Shop Widget -->
                        <div >                       
                            <h4 class="widget-title">Sizes</h4>
                            <br>
                            <input type="radio" id="small" name="sizeid" value="1">
                            <label for="small">Small</label><br>
                            <input type="radio" id="medium" name="sizeid" value="2">
                            <label for="medium">Medium</label><br>
                            <input type="radio" id="big" name="sizeid" value="3">
                            <label for="big">Big</label>
                        </div>
                        <br>
                        <input type="submit" name="filter"  value="Filter" class="btn btn-warning text-white" onclick="return Confirm()"/>
                                </form> 
                    </div>
                </div>
                <!-- All Products Area -->
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="shop-products-area">
                        <div class="row">
                            <?php
                            $result = mysqli_query($conn,"SELECT * FROM plants");
                            $counter = 1;
                            while($row = mysqli_fetch_assoc($result)){
                                ?> 
                                <!-- Single Product Area -->

                                        <div class='product_wrapper'>
                                            <form method='post' action='shop.php'>
                                            <input type='hidden' name='plantid' value=<?php echo "{$row['plantid']}" ;?>  />
                                            <input type='hidden' name='plantcode' value=<?php echo "{$row['plantcode']}" ;?> />
                                            <div class='image'><a href="shop-details.php?plantid=<?php echo "{".urlencode(secured_encrypt($row['plantid']))."}" ;?>"><img src="img/bg-img/<?php echo "{$row['images']}" ;?>" alt="" style="width:150px;height:150px;"></a></div>
                                            <div class='name'><a href="shop-details.php?plantid=<?php echo "{".urlencode(secured_encrypt($row['plantid']))."}" ;?>"><?php echo "{$row['plantname']}" ;?></a></div>
                                            <div class='price'>RM <?php echo "{$row['price']}" ;?></div>
                                            <button type='submit'  class='buy'>Buy Now</button>
                                            </form>
                                        </div>
                                        <?php      }
                                            $counter++;
                                             mysqli_close($conn);
                                        ?>
                                        <!-- Product Info -->
                                        <div style="clear:both;"></div>
                                        <div class="message_box" style="margin:10px 0px;">
                                        <?php echo $status; ?>
                                        </div>

                    </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </nav>
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