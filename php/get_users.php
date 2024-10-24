<?php
include 'conexiondb.php';

$sql = "SELECT user_id, first_name, last_name, username, email FROM Users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($users);

$conn->close();
?>
