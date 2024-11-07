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

// Verificar si el usuario ha iniciado sesión y si tiene el rol de "empleado" (por ejemplo, rol = 2)
if (!isset($_SESSION["username"]) || $_SESSION["role"] != "2") {
    // Si no está iniciada la sesión o el rol no es "2" (Empleado), redirigir al login
    header("Location: login.html");
    exit();  // Detener la ejecución del script
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleado - LavaFix_co</title>
    <link rel="stylesheet" href="css/empleado.css">
    <!-- Agregar Font Awesome para usar íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <h1>Panel de Empleado</h1>
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
            <section id="verify-user" class="card">
                <h2>Verificar Usuario</h2>
                <a href="php/verificarUsuario.php" class="btn">Verificar Usuario</a>
            </section>

            <section id="verify-order" class="card">
                <h2>Verificar Órden de Compra o Servicio</h2>
                <a href="php/verificarOrden.php" class="btn">Verificar</a>
            </section>

            <section id="changes-log" class="card">
                <h2>Historial de Cambios</h2>
                <a href="php/historialporEmpleado.php" class="btn">Ver Historial</a>
            </section>

            <section id="order-management" class="card">
                <h2>Ver Servicios de Cliente</h2>
                <a href="php/ordenesporCliente.php" class="btn">Ver Servicios</a>
            </section>

            <section id="service-status" class="card">
                <h2>Modificar Estado de Servicio</h2>
                <a href="php/modificarEstadoServicio.php" class="btn">Modificar Estado</a>
            </section>
        </div>
    </main>

</body>
</html>
