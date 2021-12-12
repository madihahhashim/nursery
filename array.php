<?php
//session_start();
include('connection/connection.php');
//include("secure/encrypt_decrypt.php");

//$custid = $_POST['custid'];

	$sql = "SELECT custname, plantname, rating FROM orders JOIN customers ON orders.custid=customers.custid JOIN plants ON orders.plantid=plants.plantid ";
    $result = mysqli_query($conn,$sql);
    $arrrating = array(); 
    $rrating = array(); 
    $count = 0;           
    $checkrows = mysqli_num_rows($result);

    if ($checkrows > 0)
    {
        while($row=mysqli_fetch_assoc($result))
        {
            $arrrating[] = $row;
            $count ++;
        }
        
    }
    foreach($arrrating as $index => $rating )
        {
            print_r ($rating);
        }
    //echo $count;
            
    

?>
