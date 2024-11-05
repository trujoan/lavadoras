<?php
// Conexión a la base de datos
include 'conexiondb.php';
session_start();

// Suponiendo que ya tienes una sesión activa que almacena el ID del usuario
if (!isset($_SESSION['user_id'])) {
    // Redirige a la página de login si no hay sesión activa
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Obtener el ID del usuario desde la sesión

// Obtener el nombre del usuario desde la base de datos
$sql = "SELECT first_name, last_name FROM Users WHERE user_id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$full_name = $user['first_name'] . ' ' . $user['last_name'];

// Consultas de servicios, estado de compras y historial
// Consultas de servicios
$services_sql = "SELECT * FROM Services WHERE user_id = $user_id";
$services_result = $conn->query($services_sql);

// Estado de compras
$orders_sql = "SELECT * FROM Orders WHERE user_id = $user_id";
$orders_result = $conn->query($orders_sql);

// Historial de compras y servicios
$history_sql = "SELECT * FROM PurchaseHistory WHERE user_id = $user_id";
$history_result = $conn->query($history_sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Usuario</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <header>
        <h1>Bienvenido, <?php echo htmlspecialchars($full_name); ?></h1>
        <nav>
            <ul>
                <li><a href="#consultas">Consultas de Servicios</a></li>
                <li><a href="#estado">Estado de Compras</a></li>
                <li><a href="#historial">Historial de Compras</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="consultas">
            <h2>Consultas de Servicios</h2>
            <div id="servicios-list">
                <?php if ($services_result->num_rows > 0): ?>
                    <ul>
                        <?php while ($service = $services_result->fetch_assoc()): ?>
                            <li>
                                <strong>Tipo de Servicio:</strong> <?php echo htmlspecialchars($service['service_type']); ?><br>
                                <strong>Estado:</strong> <?php echo htmlspecialchars($service['status']); ?><br>
                                <strong>Fecha de Solicitud:</strong> <?php echo $service['request_date']; ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No tienes servicios solicitados.</p>
                <?php endif; ?>
            </div>
        </section>

        <section id="estado">
            <h2>Estado de Compras y Mantenimiento</h2>
            <div id="estado-compras">
                <?php if ($orders_result->num_rows > 0): ?>
                    <ul>
                        <?php while ($order = $orders_result->fetch_assoc()): ?>
                            <li>
                                <strong>Fecha de la Orden:</strong> <?php echo $order['order_date']; ?><br>
                                <strong>Estado:</strong> <?php echo htmlspecialchars($order['status']); ?><br>
                                <strong>Detalles:</strong> <?php echo htmlspecialchars($order['order_details']); ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No tienes compras registradas.</p>
                <?php endif; ?>
            </div>
        </section>

        <section id="historial">
            <h2>Historial de Compras y Servicios</h2>
            <div id="historial-list">
                <?php if ($history_result->num_rows > 0): ?>
                    <ul>
                        <?php while ($history = $history_result->fetch_assoc()): ?>
                            <li>
                                <strong>Fecha de Acción:</strong> <?php echo $history['action_date']; ?><br>
                                <strong>Tipo de Acción:</strong>
                                <?php
                                    if ($history['order_id']) {
                                        echo "Compra (ID: " . $history['order_id'] . ")";
                                    } else {
                                        echo "Servicio (ID: " . $history['service_id'] . ")";
                                    }
                                ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No tienes un historial de compras ni servicios.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 LavaFix_co. Todos los derechos reservados.</p>
    </footer>

    <script src="js/dashboard.js"></script>
</body>

</html>

<?php
// Cerrar la conexión
$conn->close();
?>
