<?php
include 'conexiondb.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT user_id, first_name, last_name, username, email FROM Users WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$user = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($user);

$stmt->close();
$conn->close();
?>
