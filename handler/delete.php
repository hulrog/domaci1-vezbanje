<?php
require "../config.php";
require "../model/person.php";
if(isset($_GET['id'])){
    
    $person_id = $_GET['id'];

    //$person =  Person::getById($person_id, $conn);
    //echo $person[0][0];//first field of the first fetched record - -its id
    
    $status = Person::deleteById($person_id, $conn);
    
    if($status==TRUE){
        echo "Record deleted successfully.";
        echo $sql;
        header('Location: ../home.php');
                
    }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}

?>