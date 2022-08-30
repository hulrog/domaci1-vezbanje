<?php
require "../config.php";
require "../model/person.php";

//all fields should be set in the form
if(isset($_POST['name']) && isset($_POST['houseID']) && 
isset($_POST['title']) && isset($_POST['gender'])){

    
    $person = new Person(null, $_POST['name'], $_POST['houseID'], $_POST['title'], $_POST['gender']);   

    $status = Person::add($person, $conn);

    if($status){
        echo 'Success';
        header('Location: ../home.php');
    }else{
        echo $status;
        echo 'Failed';
    }
}else{
    header("Location: ../home.php");
}
//connect to the create page through AJAX - js/main.js
?>