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

// Verificar si el usuario ha iniciado sesión y si tiene el rol de super admin
if (!isset($_SESSION["username"]) || $_SESSION["role"] != "1") {
    // Si no está iniciada la sesión o el rol no es "1" (Super Admin), redirigir al login
    header("Location: login.html");
    exit();  // Detener la ejecución del script
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - LavaFix_co</title>
    <link rel="stylesheet" href="css/super_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <h1>Panel de Super Admin</h1>
        <nav>
            <ul>
                <li>
                    <a href="logout.php"> <!-- Cerrar sesión -->
                        <i class="fas fa-sign-out-alt logout-icon"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    
    <main>
        <div class="card-container">
            <section id="create-user" class="card">
                <h2>Crear Usuario</h2>
                <a href="php/crearUsuarios.php" class="btn">Crear Usuario</a>
            </section>
            <section id="modify-user" class="card">
                <h2>Modificar Usuario</h2>
                <a href="php/modificarUsuario.php" class="btn">Modificar Usuario</a>
            </section>
            <section id="delete-user" class="card">
                <h2>Eliminar Usuario</h2>
                <a href="php/eliminarUsuario.php" class="btn">Eliminar Usuario</a>
            </section>
            <section id="changes-log" class="card">
                <h2>Historial de Cambios de Empleados</h2>
                <a href="php/historialporEmpleado.php" class="btn">Ver Historial</a>
            </section>
            <section id="order-management" class="card">
                <h2>Ver Órdenes de Compra de Clientes</h2>
                <a href="php/ordenesporCliente.php" class="btn">Ver Órdenes de Compra</a>
            </section>
        </div>
    </main>
</body>
</html>
