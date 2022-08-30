<?php
require "../config.php";
require "../model/house.php";

//all fields should be set and not empty in the form
if(isset($_POST['name']) && !empty($_POST['name']) 
    && isset($_POST['seat']) && !empty($_POST['seat'])
    && isset($_POST['region'])){
    
    $house = new House(null, $_POST['name'], $_POST['seat'], $_POST['region']);   

    $status = House::add($house, $conn);

    if($status){
        echo 'Success';
        header('Location: ../housesView.php');
    }else{
        echo $status;
        echo 'Failed';
    }
}else{
    header('Location: ../housesView.php');
}
//connect to the create page through AJAX - js/mainHouses.js
?>