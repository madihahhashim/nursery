<?php

require_once("recommendation.php");
require_once("array.php");


$re = new Recommend();
print_r($re->getRecommendations($rating, "madi"));

?>