<?php
    include "../config.php";
    require "../model/person.php";
    require "../model/house.php";

    if(isset($_POST['update']) && isset($_POST['name']) && !empty($_POST['name'])){
        $personID = $_POST['personID'];
        $name = $_POST['name'];
        $house = $_POST['house'];
        $title = $_POST['title'];
        $gender = $_POST['gender'];
        

        $sql = "UPDATE `persons` SET `name` = '$name', `house` = '$house', `title` = '$title', `gender` = '$gender'
        WHERE `personID` = '$personID'";

        $updateResult = $conn->query($sql);

        //will return TRUE if update is successful
        if($updateResult == TRUE){
            echo "Record Updated Successfully";
            header('Location: ../home.php');
        }else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    }else{
        
    }

    

    if(isset($_GET['id'])){
        $personID = $_GET['id'];

        $sql = "SELECT * FROM `persons` WHERE `personID`='$personID'";
        //use backticks (` `) for table and column names!

        $result = $conn->query($sql);
        $resultHouses = House::getAll($conn);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $personID = $row['personID'];
                $name = $row['name'];
                $house = $row['house'];
                $title = $row['title'];
                $gender = $row['gender'];
            }

            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../style/home.css">
                <title>Document</title>
            </head>
            <body>


            <form id="createCharForm" method="post" action="">
                <h3>Update a character</h3>
                <div id="fullname">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $name; ?>"/>
                <input type="hidden" name="personID" value = "<?php echo $personID; ?>">

                <label>House </label>
                
                <select name="house" id="house">
                    <?php
                    while($rowHouses = $resultHouses->fetch_assoc()){
                    ?>
                        <option value="<?php echo $rowHouses['houseID']?>" 
                        <?php if($house == $rowHouses['houseID']) echo "selected"?>> 
                            <?php echo $rowHouses['name'] ?>
                        </option>
                    <?php
                    }//ends the while for filling the combobox
                    ?>
                </select>
            </div>
                
            <div id="additionalInfo">
                
            <div id="title-label-box">
                <label>Title</label>
                <input type="text" name="title" value="<?php echo $title; ?>"/>
            </div>
                
            <div id="gender-rb">
                <label>Gender</label>
                <input type="radio" name="gender" value="Male" <?php if($gender=='Male'){ echo "checked"; } ?> >Male
                <input type="radio" name="gender" value="Female" <?php if($gender=='Female'){ echo "checked"; } ?>>Female
            </div>
                
            </div>

            <button id="btn-update" type="submit" name="update">UPDATE</button>
            </form>
            <a href="../home.php"> <button class="fancyButton"> Go back </button></a>
            

            </body>
        </html>
            

        <?php
        } else {
            //if the id value is not valid redirect back to the view page
            header('Location: ../home.php');

        }
    }

?>