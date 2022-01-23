<?php
session_start();
include("connection/connection.php");
$status="";
if (isset($_POST['plantcode']) && $_POST['plantcode']!=""){
$code = $_POST['plantcode'];
$result = mysqli_query($con,"SELECT * FROM `plants` WHERE `plantcode`='$plantcode'");
$row = mysqli_fetch_assoc($result);
$plantname = $row['plantname'];
$plantcode = $row['plantcode'];
$price = $row['price'];
$image = $row['image'];

$cartArray = array(
	$code=>array(
	'name'=>$plantname,
	'code'=>$plantcode,
	'price'=>$price,
	'quantity'=>1,
	'image'=>$image)
);

if(empty($_SESSION["shopping_cart"])) {
    $_SESSION["shopping_cart"] = $cartArray;
    $status = "<div class='box'>Product is added to your cart!</div>";
}else{
    $array_keys = array_keys($_SESSION["shopping_cart"]);
    if(in_array($code,$array_keys)) {
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