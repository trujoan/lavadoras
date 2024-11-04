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
    <link rel="stylesheet" href="css\crearUsuarios.css"> 
</head>
<body>

    <header> 
        <nav class="navbar">
            <ul class="left-menu">
                <li>
                    <a href="#" class="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Capa_1" x="0px" y="0px"
                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"
                            width="512" height="512">
                            <g>
                                <path
                                    d="M480,224H32c-17.673,0-32,14.327-32,32s14.327,32,32,32h448c17.673,0,32-14.327,32-32S497.673,224,480,224z" />
                                <path
                                    d="M32,138.667h448c17.673,0,32-14.327,32-32s-14.327-32-32-32H32c-17.673,0-32,14.327-32,32S14.327,138.667,32,138.667z" />
                                <path
                                    d="M480,373.333H32c-17.673,0-32,14.327-32,32s14.327,32,32,32h448c17.673,0,32-14.327,32-32S497.673,373.333,480,373.333z" />
                            </g>
                        </svg>
                    </a>
                    <ul class="dropdown-content">
                        <li><a href="ofertas.html">Ofertas</a></li>
                        <li><a href="pqr.html">PQR</a></li>                        
                    </ul>
                </li>
            </ul>
            <h1>LavaFix_co</h1>
            <ul class="right-menu">
                <li>
                    <a href="login.html" class="icon-person">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
                        </svg>
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

<footer>
        <p>&copy; 2024 Lavadoras Premium. Todos los derechos reservados.</p>
        <p>Síguenos: 
            <a href="#" aria-label="WhatsApp">📱</a>
            <a href="#" aria-label="Facebook">📘</a>
            <a href="#" aria-label="Instagram">📸</a>
        </p>
        <p>📍 Carrera 2 #15-19, Bogotá</p>
    </footer>

</body>
</html>
