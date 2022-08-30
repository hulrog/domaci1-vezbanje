<?php
class House{
    public $houseID;
    public $name;
    public $seat;
    public $region;

    public function __construct($houseID=null, $name=null, $seat=null, $region=null){
        $this->houseID = $houseID;
        $this->name = $name;
        $this->seat = $seat;
        $this->region = $region;

    }

    public static function getAll(mysqli $conn){

        $sql = "SELECT * FROM houses";
        return $conn->query($sql);

    }

    // public static function getById($personID, mysqli $conn){
    //     $sql = "SELECT * FROM `persons` WHERE `personID`=$personID";
        
    //     $myArray = array();
    //     $result = $conn->query($sql);

    //     if($result){
    //         while($row=$result->fetch_array()){
    //             $myArray[] = $row; //append the array, put the row to the end
    //         }
    //     }

    //     return $myArray;
    // }

    
    public static function deleteById($houseID, mysqli $conn){

        $sql = "DELETE FROM `houses` WHERE `houseID`=$houseID";
        return $conn->query($sql);

    }


    //apostrophes don't work
//     public static function add(House $house, mysqli $conn){

//         $sql = "INSERT INTO `houses` (`name`,`seat`,`region`) 
//         VALUES('$house->name', '$house->seat', '$house->region')";
       
//         return $conn->query($sql);

//    }

   public static function add(House $house, mysqli $conn){
    $seat = mysqli_real_escape_string($conn, $house->seat);//for the apostrophes King's Landing, Storm's End etc.

    $sql = "INSERT INTO `houses` (`name`,`seat`,`region`) 
    VALUES('$house->name', '$seat', '$house->region')";
   
    return $conn->query($sql);

    }

    // public function update(mysqli $conn){
    //     $query = "UPDATE prijave 
    //     SET predmet = '$this->predmet',
    //     katedra = '$this->katedra', 
    //     sala = '$this->sala', 
    //     datum = '$this->datum'";

    //     return $conn->query($query);
    // }


}

?>