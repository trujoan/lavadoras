document.getElementById('payment-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const cardNumber = document.getElementById('card-number').value;
    const expirationDate = document.getElementById('card-expiration').value;
    const cvc = document.getElementById('card-cvc').value;
    const amount = document.getElementById('amount').value;

    // Validación simple de los campos (puedes agregar más lógica aquí)
    if (!cardNumber || !expirationDate || !cvc || !amount) {
        document.getElementById('error-message').textContent = "Por favor completa todos los campos.";
        return;
    }

    // Aquí puedes hacer una llamada a la API de pago o realizar el procesamiento del pago.
    // Ejemplo de un mockup de procesamiento
    console.log("Procesando pago...");
    setTimeout(() => {
        // Simulación de respuesta
        const success = true; // Cambia esto a false para simular un error

        if (success) {
            alert("Pago realizado con éxito.");
            // Redireccionar a otra página o realizar otra acción
            window.location.href = 'success.html'; // Cambia a la página de éxito
        } else {
            document.getElementById('error-message').textContent = "Error en el procesamiento del pago. Inténtalo de nuevo.";
        }
    }, 2000); // Simula un tiempo de procesamiento
});
