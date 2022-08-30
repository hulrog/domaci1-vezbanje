<?php

class User{

    public $id;
    public $username;
    public $password;

    public function __construct($id=null, $username=null, $password=null){

        $this->id= $id;
        $this->username = $username;
        $this->password = $password;

    }

    public static function logInUser($user, mysqli $conn){

        $sql = "SELECT * FROM `users` 
        WHERE `username`='$user->username' AND `password`='$user->password'";

        return $conn->query($sql); //returns true

    }

}

?>