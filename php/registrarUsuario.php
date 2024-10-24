<?php
include 'conexiondb.php';

// Obtener los datos del formulario
$firstName = $_POST["first-name"];
$lastName = $_POST["last-name"];
$username = $_POST["new-username"];
$email = $_POST["email"];
$password = $_POST["new-password"];

// Mostrar datos para depuración
echo $firstName;
echo $lastName;
echo $username;
echo $email;

// Hashear la contraseña
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$role = '3'; // Asignar un rol predeterminado

// Preparar la consulta
$sql = "INSERT INTO Users (first_name, last_name, username, email, password, role) VALUES ('$firstName', '$lastName', '$username', '$email', '$hashedPassword', '$role')";

// Intentar ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    echo "Usuario registrado exitosamente.";
} else {
    echo "Error en la inserción: " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>
