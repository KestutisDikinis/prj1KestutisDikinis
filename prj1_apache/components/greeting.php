<?php
session_start();
//$currentHour = date('H') + 1;
$currentHour = date('H');
$greeting = "";
$name = "";
$user = getUserById($_SESSION["UserID"]);

if(isset($_SESSION["UserID"])){

 if($currentHour >= 12 && $currentHour <= 18){
        $greeting = "<h1>Good Afternoon, </h1>" . "<h2><i>".$user['username']. "</i></h2>";
    }
 if($currentHour >= 19 && $currentHour < 24){
     $greeting = "<h1>Good Evening, </h1>" . "<i><h2>".$user['username']. "</h2></i>";
 }
 if($currentHour >= 3 && $currentHour < 12){
    $greeting = "<h1> Good Morning, </h1>" . "<i><h2>".$user['username']. "</h2></i>";
 }
}
echo $greeting;
?>
