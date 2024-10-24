<?php
include 'conexiondb.php';
$data = json_decode(file_get_contents("php://input"), true);

$firstName = $data['first_name'];
$lastName = $data['last_name'];
$username = $data['username'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);
$role = '3'; // Rol predeterminado

$stmt = $conn->prepare("INSERT INTO Users (first_name, last_name, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $firstName, $lastName, $username, $email, $password, $role);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Usuario registrado exitosamente.']);
} else {
    echo json_encode(['error' => 'Error en la inserción: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
