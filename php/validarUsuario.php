<?php

include 'conexiondb.php';

$username = $_POST["username"];
$password = $_POST["password"];

//echo $username;
//echo $password;

$sql ="SELECT * FROM Users WHERE username = '$username' AND password ='$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_assoc($result)){
        echo "Nombre : " .$row["first_name"]. "- Apellido : " .$row["last_name"]. "- Tipo : " .$row["role"]. "<br>";
        $tipoUsuario = $row["role"];
        echo $tipoUsuario;
        switch ($tipoUsuario){
            case "1": header("location: ../super_admin.html");
            break;
            case "2": header("location: ../empleado-dashboard.html");
            break;
            case "3": header("location: ../dashboard.html");
            break;
        }
    }
}else{
    echo "0 results";
}
?>