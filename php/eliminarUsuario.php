<?php
// Conexión a la base de datos
include 'conexiondb.php';

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$username_or_email = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email = $_POST['username_or_email'];
    $confirm = $_POST['confirm'] ?? '';

    if ($confirm === 'yes') {
        $stmt = $conn->prepare("DELETE FROM Users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username_or_email, $username_or_email);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $message = "Usuario eliminado con éxito.";
        } else {
            $message = "No se encontró un usuario con ese username o correo.";
        }
        $stmt->close();
    } else {
        $message = "Eliminación cancelada.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="..\css\eliminarUsuario.css">
    <!-- Agregar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <h1>Eliminar Usuario</h1>
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

    <main>
        <div class="container">
            <form method="post" action="">
                <label for="username_or_email">Ingrese Username o Correo:</label>
                <input type="text" name="username_or_email" value="<?php echo htmlspecialchars($username_or_email); ?>" required>
                <button type="submit">Buscar</button>
            </form>

            <?php if (!empty($message)): ?>
                <div class="confirmation">
                    <p><?php echo $message; ?></p>
                    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error) && $confirm !== 'yes'): ?>
                        <p>¿Está seguro de que desea eliminar el usuario "<?php echo htmlspecialchars($username_or_email); ?>"?</p>
                        <form method="post" action="">
                            <input type="hidden" name="username_or_email" value="<?php echo htmlspecialchars($username_or_email); ?>">
                            <button type="submit" name="confirm" value="yes">Sí, eliminar</button>
                            <button type="submit" name="confirm" value="no">No, cancelar</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>
