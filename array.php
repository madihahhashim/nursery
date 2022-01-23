<?php
session_start();
include('connection/connection.php');
//include("secure/encrypt_decrypt.php");

//$custid = $_POST['custid'];
require_once("recommendation.php");


    
$sql = "SELECT  custname, group_concat(plantname) as plantnames, group_concat(rate ) AS rates
FROM orders INNER JOIN customers ON orders.custid=customers.custid  JOIN plants ON orders.plantid=plants.plantid where rate is not null
group BY customers.custname  ";
$result = mysqli_query($conn,$sql);
$arrrating = array(); 
$arrname = array(); 
$arrplant = array(); 
$name = array(); 
$plantrates = array(); 
$checkrows = mysqli_num_rows($result);



if ($checkrows > 0)
{
    while($row=mysqli_fetch_assoc($result))
    {
        
        array_push($arrname, $row['custname']);
        array_push($arrplant, explode(',', $row['plantnames']));
        array_push($arrrating, explode(',', $row['rates']));
    }

}

for($k = 0; $k < count($arrname); $k++) 
{
    $c[$k]=array_combine($arrplant[$k],$arrrating[$k]);
}

$recommend = array_combine($arrname, $c);
//print_r($recommend);

$re = new Recommend();
print_r($re->getRecommendations($recommend,  $_SESSION['custname']));
?>