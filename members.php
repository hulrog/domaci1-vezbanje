<?php

    include "config.php";
    require "model/person.php";

    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location: index.php');//kick the user back to the index page if his ID is not set in the session
        exit();
    }


    if(isset($_GET['houseID'])){
    
        $houseID = $_GET['houseID'];

        

        $sql = "SELECT p.personID as ppersonID, p.name as pname, h.name as hname, p.title as ptitle, p.gender as pgender 
        FROM persons as p INNER JOIN houses as h
        ON p.house = h.houseID
        WHERE h.houseID = $houseID";        
        $result = $conn->query($sql);

        //getting the name of the house whose ID is sent through GET link
        $sql2 = "SELECT `name` 
        FROM houses
        WHERE houseID = $houseID";
        $houseNameResult = $conn->query($sql2);
        $houseName = $houseNameResult->fetch_assoc()['name'];

        $sql3 = "SELECT `seat` 
        FROM houses
        WHERE houseID = $houseID";
        $houseSeatResult = $conn->query($sql3);
        $houseSeat = $houseSeatResult->fetch_assoc()['seat'];

        
        if(!$result){
            echo "Error with the query.<br>";
            die();
        }
        

    
    } 

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/home.css">
    <title>A Song of Ice & Fire</title>

</head>

<body>


<h1>A Song of Ice and Fire</h1>
<div id="nameAndSigil">
<h2>Characters of House <?php echo $houseName ?> of <?php echo $houseSeat ?></h2>
<img src="sigils/<?php echo $houseID ?>.svg" style="display:
    <?php if(($houseID > 9 && $houseID < 25) || $houseID > 36) echo 'none;'; ?>">
</div>


<script>
    var houseID = "<?php echo $houseID; ?>";

    switch(houseID) {//in order of conquest
        case '1': //targaryen
            document.body.style.backgroundColor = "#0e1111"; //black
            document.body.style.color = "#99000d"; //crimson
        break;
        case '2': //baratheon
            document.body.style.backgroundColor="#f1c629"; //gold
            document.body.style.color = "black";
        break;
        case '3': //tully
            document.body.style.backgroundColor="#262146"; //river blue
            document.body.style.color = "#f77571"; //fish orange
        break;
        case '4': //tyrell
            document.body.style.backgroundColor="#8fbf16"; //light green
            document.body.style.color = "#eee057"; //flowery gold
        break;
        case '5': //lannister
            document.body.style.backgroundColor="#64000d"; //crimson
            document.body.style.color = "#eab64d"; //gold
        break;
        case '6': //arryn
            document.body.style.backgroundColor="#87ceeb"; //skyblue
            document.body.style.color = "white";
        break;
        case '7': //stark
            document.body.style.backgroundColor="#f3f6fb"; //snow white 
            document.body.style.color = "#4d495b "; //wolf grey
        break;
        case '8': //greyjoy
            document.body.style.backgroundColor="#0e1111"; //black
            document.body.style.color = "#f1c629"; //gold
        break;
        case '9': //martell
            document.body.style.backgroundColor="#c65102"; //dark orange
            document.body.style.color = "#f1c629"; //gold
        break;
        case '25': //bolton
            document.body.style.backgroundColor= "#F7CDDB"; //pink
            document.body.style.color = "#7D1E20"; //blood red
        break;
        case '26': //hightower
            document.body.style.backgroundColor="#918E85 "; //stone grey
            document.body.style.color = "#f3f6fb"; //snow white 
        break;
        case '27': //tarth
            document.body.style.backgroundColor="#f77571"; //soft red
            document.body.style.color = " #072A6C"; //deep blue
        break;
        case '28': //velaryon
            document.body.style.backgroundColor="#549F98"; //sea blue
            document.body.style.color = "#f3f6fb"; //snow white 
        break;
        case '29': //blackfyre
            document.body.style.backgroundColor="#99000d"; //crimson
            document.body.style.color = "#0e1111"; //black
        break;
        case '30': //manderly
            document.body.style.backgroundColor="#2A868A "; //sea foam blue
            document.body.style.color = "#f3f6fb"; //snow white 
        break;
        case '31': //tarly
            document.body.style.backgroundColor="#228B22"; //forest
            document.body.style.color = "#B22222"; //red
        break;
        case '32': //westerling
            document.body.style.backgroundColor="#F0E68C"; //sand
            document.body.style.color = "#f3f6fb"; //snow white 
        break;
        case '33': //mormont
            document.body.style.backgroundColor="#006400"; //dark green
            document.body.style.color = "#0e1111"; //black
        break;
        case '34': //clegane
            document.body.style.backgroundColor="#FFFF33"; //gold
            document.body.style.color = "#0e1111"; //black
        break;
        case '35': //florent
            document.body.style.backgroundColor="#f3f6fb"; //snow white
            document.body.style.color = "#c65102"; //dark orange
        break;
        case '36': //sunderland
            document.body.style.backgroundColor="#228B22"; //forest
            document.body.style.color = "#00008B"; //dark green
        break;

        default:
            
            
    } 

</script>



<table class = "table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>House</th>
            <th>Title</th>
            <th>Gender</th>
            
            
        </tr>   
    </thead>
    <tbody>
    <?php 
        //print out the rows only if there is something returned
        if($result->num_rows>0){
        $iterator = 0;
        while($row = $result->fetch_assoc()){

    ?>
        <?php
            if($iterator % 2 == 0 ){
        ?>
        <tr class="evenRow">
        <?php 
            } else {
        ?>
        <tr class="oddRow">
        <?php
            }
        ?>
            <td> <?php echo $row['ppersonID']; ?> </td>
            <td> <?php echo $row['pname']; ?> </td>
            <td> <?php echo $row['hname']; ?> </td>
            <td> <?php echo $row['ptitle']; ?> </td>
            <td> <?php echo $row['pgender']; ?> </td>

        </tr>

    <?php 
        $iterator++;
        } //ends the while
    ?>



    <?php
        } //ends the if for rows returned
    ?>
    

    </tbody>
</table>

<table class=menu_buttons>
    <tr>
        <td><a href="housesView.php"> <button class="fancyButton"> Back to houses. </button></a> </td>
    </tr>
</table>



</body>
</html>