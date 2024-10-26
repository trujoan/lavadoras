<?php
session_start(); // Iniciar la sesión

// Conexión a la base de datos
include 'conexiondb.php';

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar variables
$usuarios = [];
$user = null;

// Buscar usuarios
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchTerm'])) {
    $searchTerm = $conn->real_escape_string($_POST['searchTerm']);

    $sql = "SELECT * FROM Users WHERE username LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
    } else {
        echo "No se encontraron usuarios.";
    }
}

// Editar usuario
if (isset($_GET['id'])) {
    $user_id = $conn->real_escape_string($_GET['id']);

    // Consulta para obtener los datos del usuario
    $sql = "SELECT * FROM Users WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Usuario no encontrado.";
        exit;
    }

    // Actualizar datos del usuario
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $user) {
        $first_name = $conn->real_escape_string($_POST['first_name']);
        $last_name = $conn->real_escape_string($_POST['last_name']);
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $role = $conn->real_escape_string($_POST['role']);

        // Actualiza el usuario en la base de datos
        $update_sql = "UPDATE Users SET first_name='$first_name', last_name='$last_name', username='$username', email='$email', role='$role' WHERE user_id='$user_id'";

        if ($conn->query($update_sql) === TRUE) {
            $_SESSION['message'] = "Usuario actualizado correctamente."; // Guardar mensaje en sesión
            header("Location: super_admin.html"); // Redirigir a super_admin.html
            exit();
        } else {
            echo "Error actualizando el usuario: " . $conn->error;
        }
    }
}

// Mostrar mensaje si existe
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); // Limpiar mensaje después de mostrar

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuarios - LavaFix</title>
    <link rel="stylesheet" href="css/modificarUsuarios.css"> <!-- Incluir el CSS -->
</head>
<body>
    <header>
        <h1>Modificar Usuarios</h1>
    </header>

    <main>
        <form method="post" action="">
            <input type="text" name="searchTerm" placeholder="Buscar por username o correo" required>
            <button type="submit">Buscar</button>
        </form>

        <?php if ($message): ?>
            <p class="success-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <?php if (!empty($usuarios)): ?>
            <h2>Resultados de la búsqueda:</h2>
            <ul>
                <?php foreach ($usuarios as $usuario): ?>
                    <li>
                        <strong>Username:</strong> <?php echo htmlspecialchars($usuario['username']); ?> <br>
                        <strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?> <br>
                        <a href="?id=<?php echo $usuario['user_id']; ?>">Modificar</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ($user): ?>
            <h2>Editar Usuario</h2>
            <form method="post" action="">
                <input type="text" name="first_name" placeholder="Primer Nombre" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                <input type="text" name="last_name" placeholder="Apellido" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                <input type="text" name="username" placeholder="Nombre de Usuario" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                <input type="email" name="email" placeholder="Correo Electrónico" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                <select name="role" required>
                    <option value="1" <?php if ($user['role'] == '1') echo 'selected'; ?>>Admin</option>
                    <option value="2" <?php if ($user['role'] == '2') echo 'selected'; ?>>Empleado</option>
                    <option value="3" <?php if ($user['role'] == '3') echo 'selected'; ?>>Cliente</option>
                </select>
                <button type="submit">Actualizar Usuario</button>
            </form>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 Tiendas de Electrodomésticos. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
