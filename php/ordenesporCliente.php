<?php
$servername = "localhost";
$username = "root"; // Cambia esto según tu configuración
$password = "";     // Cambia esto según tu configuración
$dbname = "LavaFix";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$client_identifier = "";
$orders = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_identifier = $_POST['client_identifier'];

    // Obtener el ID del usuario según el username o correo
    $stmt = $conn->prepare("SELECT user_id FROM Users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $client_identifier, $client_identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];

        // Obtener las órdenes de compra del cliente
        $stmt = $conn->prepare("SELECT * FROM Orders WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    } else {
        $orders = [];
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Órdenes de Compra por Cliente</title>
    <link rel="stylesheet" href="..\css\ordenesporCliente.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<header>
        <nav class="navbar">
        <h1>Órdenes de Compra por Cliente</h1>
            <ul class="right-menu">
                <li>
                    <!-- Enlace para logout, utilizando el ícono de Font Awesome -->
                    <a href="../super_admin.html" class="icon-logout">
                        <i class="fas fa-sign-out-alt"></i> <!-- Ícono de logout -->
                    </a>
                </li>
            </ul>
        </nav>
    </header>
<body>
    <div class="container">
        
        <form method="post" action="">
            <label for="client_identifier">Ingrese Username o Correo Electrónico:</label>
            <input type="text" name="client_identifier" value="<?php echo htmlspecialchars($client_identifier); ?>" required>
            <button type="submit">Buscar</button>
        </form>

        <?php if (!empty($orders)): ?>
            <h2>Órdenes Realizadas:</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID de Orden</th>
                        <th>Fecha de Orden</th>
                        <th>Detalles de Orden</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_details']); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <p>No se encontraron órdenes para el cliente con username o correo "<?php echo htmlspecialchars($client_identifier); ?>".</p>
        <?php endif; ?>
    </div>
</body>
</html>
