<?php

$host = "localhost";
$db = "itehdomaci1";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_errno){

    exit("Connection error occured:". $conn->connect_error.", with the code: ".$conn->connect->err);

}

?>