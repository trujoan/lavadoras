<?php
session_start();  // Iniciar la sesión

// Destruir todos los datos de la sesión
session_unset();  // Elimina todas las variables de sesión
session_destroy();  // Destruye la sesión actual

// Redirigir al usuario a la página de login
header("Location: login.html");
exit();  // Asegurarse de que no se ejecute más código
?>
