<?php
include 'conexiondb.php';
$data = json_decode(file_get_contents("php://input"), true);

$userId = $data['user_id'];
$firstName = $data['first_name'];
$lastName = $data['last_name'];
$username = $data['username'];
$email = $data['email'];

$stmt = $conn->prepare("UPDATE Users SET first_name = ?, last_name = ?, username = ?, email = ? WHERE user_id = ?");
$stmt->bind_param("ssssi", $firstName, $lastName, $username, $email, $userId);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Usuario actualizado exitosamente.']);
} else {
    echo json_encode(['error' => 'Error en la actualización: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
