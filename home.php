<?php
    require "config.php";
    require "model/person.php";
    require "model/house.php";

    session_start();

    if(!isset($_SESSION['user_id'])){
        header('Location: index.php');//kick the user back to the index page if his ID is not set in the session
        exit();
    }
    
    $result = Person::getAll($conn); 
    $resultHouses = House::getAll($conn);

    if(!$result){
        echo "Error with the query.<br>";
        die();
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/home.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <script> //javascript that retains the scroll position
        window.addEventListener('scroll',function() {
        localStorage.setItem('scrollPosition',window.scrollY);
        },false); 

        window.addEventListener('load',function() {
        if(localStorage.getItem('scrollPosition') !== null)
            window.scrollTo(0, localStorage.getItem('scrollPosition'));
        },false);  
    </script>
    <title>A Song of Ice & Fire</title>

</head>

<body>


<h1>A Song of Ice and Fire</h1>
<h2>Characters</h2> 

<table class=menu_buttons>
    <tr>
        <td><a href="housesView.php"> <button class="fancyButton"> View houses. </button></a> </td>
        <td><button class="fancyButton" onClick="document.getElementById('createCharForm').scrollIntoView();" > 
        Create character. </button> </td>
        <td><a href="home.php"> <button class="fancyButton"> Refresh. </button></a> </td>
    </tr>
    <tr>
        <td><button class="fancyButton" onclick="sortTable()"> Sort by name. </button> </td>
        <td><input type="text" id="search" onkeyup="search()" placeholder="Enter character name..."></td>
    </tr>

</table>

<table class = "table" id="charactersTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>House</th>
            <th>Title</th>
            <th>Gender</th>
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
            <td> <?php echo $row['ppersonID']; ?> </td>
            <td> <?php echo $row['pname']; ?> </td>
            <td> <?php echo $row['hname']; ?> </td>
            <td> <?php echo $row['ptitle']; ?> </td>
            <td> <?php echo $row['pgender']; ?> </td>
            <td> 
                <a class="editButton" href="handler/update.php?id=<?php echo $row['ppersonID']; ?>">Edit</a>
                <a class="deleteButton" href="handler/delete.php?id=<?php echo $row['ppersonID']; ?>">X</a>
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

<form id="createCharForm" method="post" action="handler/add.php">
    <h3>Create a character</h3>
    <div id="fullname">
    <label>Name</label>
    <input type="text" name="name" autocomplete="off" onkeyup="canonNames(this.value)"/>

    <label>House </label>
    
    <select name="houseID" id="houseID">
        <!-- <option value="1">Targaryen</option>
        <option value="2">Baratheon</option>
        <option value="3">Tully</option>
        <option value="4">Tyrell</option>
        <option value="5">Lannister</option>
        <option value="6">Arryn</option>
        <option value="7">Stark</option>
        <option value="8">Greyjoy</option>
        <option value="9">Martell</option> -->
        <?php
        while($rowHouses = $resultHouses->fetch_assoc()){
        ?>
            <option value="<?php echo $rowHouses['houseID']?>"> <?php echo $rowHouses['name'] ?></option>
        <?php
        }//ends the while for filling the combobox
        ?>
    </select>
    
    </div>
    
    <div id="additionalInfo">
    
    <div id="title-label-box">
        <label>Title</label>
        <input type="text" name="title" autocomplete="off"/>
    </div>
    
    <div id="gender-rb">
        <label>Gender</label>
        <input type="radio" name="gender" value="Male">Male
        <input type="radio" name="gender" value="Female">Female
    </div>
    
    </div>

    <button id="btn-add" type="submit">CREATE</button>

    <p>Canon names: <span id="suggestedName"></span></p>
</form>





</body>
</html>