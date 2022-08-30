<?php
    include "../config.php";
    require "../model/house.php";

    if( isset($_POST['update']) && isset($_POST['name']) && !empty($_POST['name'])
        && isset($_POST['seat']) && !empty($_POST['seat']) ){
        $houseID = $_POST['houseID'];
        $name = $_POST['name'];
        $seat = $_POST['seat'];
        $region = $_POST['region'];

        $seat = mysqli_real_escape_string($conn, $seat);

        $sql = "UPDATE `houses` SET `name` = '$name', `seat` = '$seat', `region` = '$region'
        WHERE `houseID` = '$houseID'";

        $updateResult = $conn->query($sql);

        //will return TRUE if update is successful
        if($updateResult == TRUE){
            echo "Record Updated Successfully";
            header('Location: ../housesView.php');
        }else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    }

    

    if(isset($_GET['houseID'])){
        $houseID = $_GET['houseID'];

        $sql = "SELECT * FROM `houses` WHERE `houseID`='$houseID'";
        //use backticks (` `) for table and column names!

        $result = $conn->query($sql);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $houseID = $row['houseID'];
                $name = $row['name'];
                $seat = $row['seat'];
                $region = $row['region'];
            }

            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../style/housesView.css">
                <title>House edit</title>
            </head>
            <body>

            <form id="createHouseForm" method="post" action="">
                <h3>Edit a house</h3>
                <div id="name-region">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $name?>"/>
                <input type="hidden" name="houseID" value = "<?php echo $houseID; ?>">

                <label> Region </label>
                <select name="region" id="region">
                    <option value="Crownlands" <?php if($region=="Crownlands") echo "selected" ?>>Crownlands</option>
                    <option value="Stormlands" <?php if($region=="Stormlands") echo "selected" ?>>Stormlands</option>
                    <option value="Riverlands" <?php if($region=="Riverlands") echo "selected" ?>>Riverlands</option>
                    <option value="The Reach" <?php if($region=="The Reach") echo "selected" ?>>The Reach</option>
                    <option value="Westerlands" <?php if($region=="Westerlands") echo "selected" ?>>Westerlands</option>
                    <option value="The Vale" <?php if($region=="The Vale") echo "selected" ?>>The Vale</option>
                    <option value="The North" <?php if($region=="The North") echo "selected" ?>>The North</option>
                    <option value="Iron Islands" <?php if($region=="Iron Islands") echo "selected" ?>>Iron Islands</option>
                    <option value="Dorne" <?php if($region=="Dorne") echo "selected" ?>>Dorne</option>
                </select>
            
                </div>
    
                <div id="seat-label-box">
                <label>Seat</label>
                <input type="text" name="seat" value="<?php echo $seat ?>"/>
                </div>

                <button id="btn-update" type="submit" name="update">UPDATE</button>
            </form>
            

            </body>
        </html>
            

        <?php
        } else {
            
            header('Location: ../home.php');

        }
    }

?>