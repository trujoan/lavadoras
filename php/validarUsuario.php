<?php
session_start();  // Iniciar la sesión

include 'conexiondb.php';

$username = $_POST["username"];
$password = $_POST["password"];

// Sanitizar las entradas para evitar inyección SQL
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

// Consulta para verificar las credenciales
$sql = "SELECT * FROM Users WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Si se encuentra el usuario, recuperar la información
    while ($row = mysqli_fetch_assoc($result)) {
        // Guardar los datos del usuario en variables de sesión
        $_SESSION["username"] = $row["username"];
        $_SESSION["first_name"] = $row["first_name"];
        $_SESSION["last_name"] = $row["last_name"];
        $_SESSION["role"] = $row["role"];  // El rol también se almacena en la sesión

        // Mostrar la información del usuario
        echo "Nombre: " . $row["first_name"] . " - Apellido: " . $row["last_name"] . " - Tipo: " . $row["role"] . "<br>";
        
        // Redirigir según el tipo de usuario
        switch ($row["role"]) {
            case "1": 
                header("Location: ../super_admin.php");
                exit();
            case "2": 
                header("Location: ../empleado.php");
                exit();
            case "3": 
                header("Location: ../cliente.php");
                exit();
            default:
                echo "Rol no reconocido.";
        }
    }
} else {
    echo "Usuario o contraseña incorrectos.";
}
?>
