<?php
require 'vendor/autoload.php'; // Incluir la biblioteca de Stripe

// Establecer la clave secreta de Stripe
\Stripe\Stripe::setApiKey('tu_clave_secreta_de_stripe');

// Verificar si el formulario fue enviado correctamente
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['stripeToken']) && isset($_POST['amount'])) {
    $token = $_POST['stripeToken']; // El token que enviamos desde el frontend
    $amount = $_POST['amount'] * 100; // Convertir el monto a centavos (Stripe maneja los pagos en centavos)

    try {
        // Crear el cargo
        $charge = \Stripe\Charge::create([
            'amount' => $amount,
            'currency' => 'usd', // O la moneda que desees, por ejemplo, 'mxn' para pesos mexicanos
            'description' => 'Pago de servicio en LavaFix',
            'source' => $token,
        ]);

        // Si el pago fue exitoso, muestra un mensaje
        echo 'Pago realizado con éxito. Gracias por tu compra.';
    } catch (\Stripe\Exception\ApiErrorException $e) {
        // Si hubo un error al procesar el pago
        echo 'Error al procesar el pago: ' . $e->getMessage();
    }
} else {
    echo 'No se ha recibido la información correctamente.';
}
?>
