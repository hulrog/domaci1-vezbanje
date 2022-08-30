<?php
    require "config.php";
    require "model/house.php";

    session_start();

    if(!isset($_SESSION['user_id'])){
        header('Location: index.php');//kick the user back to the index page if his ID is not set in the session
        exit();
    }
    
    $result = House::getAll($conn); 

    if(!$result){
        echo "Error with the query.<br>";
        die();
    }



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/housesView.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/mainHouses.js"></script>
    <script> //javascript that retains the scroll position
        window.addEventListener('scroll',function() {
        localStorage.setItem('scrollPosition',window.scrollY);
        },false); 

        window.addEventListener('load',function() {
        if(localStorage.getItem('scrollPosition') !== null)
            window.scrollTo(0, localStorage.getItem('scrollPosition'));
        },false);  
    </script>
    <title>Houses</title>

</head>

<body>


<h1>A Song of Ice and Fire</h1>
<h2>Houses</h2> 

<table class=menu_buttons>
    <tr>
        <td><a href="home.php"> <button class="fancyButton"> View characters. </button></a> </td>
        <td><button class="fancyButton" onClick="document.getElementById('createHouseForm').scrollIntoView();"> Create house. </button> </td>
        <td><a href="housesView.php"> <button class="fancyButton"> Refresh. </button></a> </td>
    </tr>
</table>

<table class = "table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Seat</th>
            <th>Region</th>
            <th>Options</th>
            
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
            if($iterator % 2 ==0 ){
        ?>
        <tr class="evenRow">
        <?php 
            } else {
        ?>
        <tr class="oddRow">
        <?php
            }
        ?>
            <td> <?php echo $row['houseID']; ?> </td>
            <td> <?php echo $row['name']; ?> </td>
            <td> <?php echo $row['seat']; ?> </td>
            <td> <?php echo $row['region']; ?> </td>
            <td> 
                <a class="editButton" href="handler/updateHouses.php?houseID=<?php echo $row['houseID']; ?>">Edit</a>
                <a class="deleteButton" href="handler/deleteHouses.php?houseID=<?php echo $row['houseID']; ?>">X</a>
                <a class="editButton" href="members.php?houseID=<?php echo $row['houseID']; ?>">Members</a>  
            </td>
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

<form id="createHouseForm" method="post" action="handler/addHouses.php">
    <h3>Create a house</h3>
    <div id="name-region">
    <label>Name</label>
    <input type="text" name="name" autocomplete="off"/>

    <label> Region </label>
    <select name="region" id="region">
        <option value="Crownlands">Crownlands</option>
        <option value="Stormlands">Stormlands</option>
        <option value="Riverlands">Riverlands</option>
        <option value="The Reach">The Reach</option>
        <option value="Westerlands">Westerlands</option>
        <option value="The Vale">The Vale</option>
        <option value="The North">The North</option>
        <option value="Iron Islands">Iron Islands</option>
        <option value="Dorne">Dorne</option>
    </select>
    
    </div>
    
    <div id="seat-label-box">
        <label>Seat</label>
        <input type="text" name="seat" autocomplete="off"/>
    </div>
    <button id="btn-add" type="submit">CREATE</button>
</form>



</body>
</html>