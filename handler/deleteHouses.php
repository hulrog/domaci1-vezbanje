<?php
require "../config.php";
require "../model/house.php";
require "../model/person.php";
if(isset($_GET['houseID'])){

    $houseID = $_GET['houseID'];

    $sqlMembers = "SELECT * FROM `persons` WHERE `house`='$houseID'";     
    $resultMembers = $conn->query($sqlMembers);

    if(($houseID >= 1 && $houseID <=9)||($houseID >= 25 && $houseID<=36)){

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/housesView.css">
    <title>Delete a house</title>
    <h2>You can not delete a main house!</h2>
    <a href="../housesView.php"> <button class="fancyButton"> Back to houses. </button></a> 
</head>
<body>
    
</body>
</html>

<?php
    } elseif ($resultMembers->num_rows>0) { //ako ima bilo kog clana, ne dozvoli brisanje
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/housesView.css">
    <title>Delete a house</title>
    <h2>You can not delete a house that has members!</h2>
    <p>
        (That house has <?php echo $resultMembers->num_rows ?> 
        <?php if($resultMembers->num_rows>1) echo 'members'; else echo 'member'; ?>)
    </p>
    <a href="../housesView.php"> <button class="fancyButton"> Back to houses. </button></a> 
</head>
<body>
    
</body>
</html>

<?php
    } else{
        $status = House::deleteById($houseID, $conn);
    
        if($status==TRUE){
            echo "Record deleted successfully.";
            header('Location: ../housesView.php');
                    
        }else{
            echo "Error: <br>" . $conn->error;
        }
    }
}

?>