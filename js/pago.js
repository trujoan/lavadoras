// Claves de Stripe (tú las proporcionas desde tu cuenta de Stripe)
const stripe = Stripe('tu_clave_publica_de_stripe');
const elements = stripe.elements();
const card = elements.create('card');
card.mount('#card-element');

// Manejar el envío del formulario
const form = document.getElementById('payment-form');
form.addEventListener('submit', async (event) => {
    event.preventDefault(); // Evitar el envío por defecto del formulario

    const { token, error } = await stripe.createToken(card);

    if (error) {
        document.getElementById('error-message').innerText = error.message;
    } else {
        // Si no hay error, agregamos el token al formulario y lo enviamos
        const hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        form.submit();
    }
});
