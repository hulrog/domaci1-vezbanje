<?php
require "../config.php";
$sqlNames = "SELECT `name` FROM `persons`";
$resultNames = $conn->query($sqlNames);
$arrayNames[]="Aegon";
while($rowNames = $resultNames->fetch_assoc()){
    if(!in_array($rowNames['name'], $arrayNames)) //php funkcija in_array proverava da li postoji element u
        $arrayNames[]=$rowNames['name'];
}


$enteredName = $_GET["enteredName"]; //get preko ajaxa

$hint = "";

if ($enteredName !== "") {
    $enteredName = strtolower($enteredName);
    $len = strlen($enteredName);
    foreach($arrayNames as $suggestedName) {
        if (stristr($enteredName, substr($suggestedName, 0, $len))) {
            if ($hint === "") {
                $hint = $suggestedName;
            } else {
                $hint .= ", $suggestedName";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "That will be a new name!" : $hint;
?> 