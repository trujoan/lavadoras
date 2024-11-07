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

    // Buscar si el usuario o correo existe
    $stmt = $conn->prepare("SELECT username, email, created_at FROM Users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // El usuario existe, obtener los datos
        $user = $result->fetch_assoc();
        $message = "Usuario encontrado con ese username o correo.";
        $created_at = $user['created_at'];

        // Formatear la fecha de ingreso (suponiendo que `created_at` es un campo datetime)
        $formatted_date = date("d-m-Y H:i:s", strtotime($created_at));
        $message .= " Fecha de ingreso: " . $formatted_date;
    } else {
        // El usuario no existe
        $message = "No se encontró un usuario con ese username o correo.";
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
    <title>Verificar Usuario</title>
    <link rel="stylesheet" href="..\css\eliminarUsuario.css">
    <!-- Agregar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <h1>Verificar Usuario</h1>
            <ul class="right-menu">
                <li>
                    <!-- Enlace para logout, utilizando el ícono de Font Awesome -->
                    <a href="../empleado.php" class="icon-logout">
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
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>
