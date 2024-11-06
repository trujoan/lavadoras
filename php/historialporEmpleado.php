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

$employee_identifier = "";
$changes = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_identifier = $_POST['employee_identifier'];

    // Obtener el ID del usuario según el username o correo
    $stmt = $conn->prepare("SELECT user_id FROM Users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $employee_identifier, $employee_identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];

        // Obtener el historial de cambios del empleado
        $stmt = $conn->prepare("SELECT * FROM ChangeLog WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $changes[] = $row;
        }
    } else {
        $changes = [];
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
    <title>Historial por Empleado</title>
    <link rel="stylesheet" href="..\css\historialporEmpleado.css">
    <!-- Agregar Font Awesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
         <nav class="navbar">

      
        <!-- Título del encabezado -->
        <h1>Historial de Cambios por Empleado</h1>

        <!-- Menú de navegación con el ícono de logout -->
        
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

    <div class="container">
        <form method="post" action="">
            <label for="employee_identifier">Ingrese Username o Correo Electrónico:</label>
            <input type="text" name="employee_identifier" value="<?php echo htmlspecialchars($employee_identifier); ?>" required>
            <button type="submit">Buscar</button>
        </form>

        <?php if (!empty($changes)): ?>
            <h2>Cambios Realizados:</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción del Cambio</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($changes as $change): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($change['change_id']); ?></td>
                            <td><?php echo htmlspecialchars($change['change_description']); ?></td>
                            <td><?php echo htmlspecialchars($change['change_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <p>No se encontraron cambios para el empleado con username o correo "<?php echo htmlspecialchars($employee_identifier); ?>".</p>
        <?php endif; ?>
    </div>
</body>
</html>

