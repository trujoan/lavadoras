<?php
// Conexión a la base de datos
include 'conexiondb.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar variables
$firstName = $lastName = $username = $email = $password = $role = "";
$errors = [];

// Procesar el formulario al enviarlo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validar campos
    if (empty($firstName) || empty($lastName) || empty($username) || empty($email) || empty($password) || empty($role)) {
        $errors[] = "Todos los campos son obligatorios.";
    } else {
        // Verificar si el nombre de usuario o el email ya existen
        $sql = "SELECT * FROM Users WHERE username='$username' OR email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $errors[] = "El nombre de usuario o el correo electrónico ya están en uso.";
        } else {
            // Hashear la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario
            $stmt = $conn->prepare("INSERT INTO Users (first_name, last_name, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $firstName, $lastName, $username, $email, $hashedPassword, $role);

            if ($stmt->execute()) {
                echo "<p>Usuario creado exitosamente.</p>";
            } else {
                $errors[] = "Error al crear el usuario: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="..\css\crearUsuarios.css"> 
    <!-- Agregar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<header> 
    <nav class="navbar">
        <h1>Crear Usuario</h1>
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
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="first_name" placeholder="Primer Nombre" required>
        <input type="text" name="last_name" placeholder="Apellido" required>
        <input type="text" name="username" placeholder="Nombre de Usuario" required>
        <input type="email" name="email" placeholder="Correo Electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <select name="role" required>
            <option value="">Selecciona un Rol</option>
            <option value="1">Admin</option>
            <option value="2">Empleado</option>
            <option value="3">Cliente</option>
        </select>
        <input type="submit" value="Crear Usuario">
    </form>
</main>



</body>
</html>
