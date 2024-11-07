<?php
session_start();  // Iniciar la sesión

// Establecer el tiempo máximo de inactividad en segundos (60 segundos = 1 minuto)
$tiempo_maximo_inactividad = 60;

// Verificar si la sesión está activa y si el tiempo de inactividad es mayor que el límite
if (isset($_SESSION["last_activity"])) {
    $tiempo_inactividad = time() - $_SESSION["last_activity"];  // Calcula la inactividad en segundos

    if ($tiempo_inactividad > $tiempo_maximo_inactividad) {
        // Si ha pasado más de 1 minuto (60 segundos), destruye la sesión
        session_unset();
        session_destroy();
        header("Location: login.html");  // Redirige al usuario al login
        exit();
    }
}

// Actualiza el tiempo de la última actividad en la sesión
$_SESSION["last_activity"] = time();

// Verificar si el usuario ha iniciado sesión y si tiene el rol de "cliente" (por ejemplo, rol = 3)
if (!isset($_SESSION["username"]) || $_SESSION["role"] != "3") {
    // Si no está iniciada la sesión o el rol no es "3" (Cliente), redirigir al login
    header("Location: login.html");
    exit();  // Detener la ejecución del script
}

// Obtener el nombre del usuario desde la sesión
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "Usuario";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente - LavaFix_co</title>
    <link rel="stylesheet" href="css/cliente.css">
    <!-- Agregar Font Awesome para usar íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
            <h1>Bienvenido, <?php echo htmlspecialchars($username); ?>!</h1>
        <nav>
            <ul>
                <!-- Enlace para cerrar sesión con ícono -->
                <li>
                    <a href="logout.php"> <!-- Cerrar sesión -->
                        <i class="fas fa-sign-out-alt logout-icon"></i> <!-- Ícono de log out -->
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="card-container">
            <section id="modify-user" class="card">
                <h2>Actualizar Usuario</h2>
                <a href="php/modificarUsuario.php" class="btn">Actualizar Usuario</a>
            </section>

            <section id="order-management" class="card">
                <h2>Ver Órdenes de Servicios</h2>
                <a href="php/ordenesporCliente.php" class="btn">Ver Servicios</a>
            </section>
        </div>
    </main>

</body>
</html>
