<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "lavafix";

//create conection
$conn = new mysqli($servername, $username, $password, $dbname);
//check conection
if(!$conn){
    die("conection failed: ".mysqli_connect_error());
}
//echo "conexion realizada"
?>