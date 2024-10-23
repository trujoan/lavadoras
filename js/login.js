document.getElementById('register-link').addEventListener('click', function(event) {
    event.preventDefault();
    const container = document.getElementById('container');
    container.classList.add('active');

    // Ocultar el formulario de inicio de sesión
    document.querySelector('.login-container').classList.add('hidden');
    // Mostrar el formulario de registro
    document.querySelector('.register-container').classList.remove('hidden');
});

document.getElementById('login-link').addEventListener('click', function(event) {
    event.preventDefault();
    const container = document.getElementById('container');
    container.classList.remove('active');

    // Mostrar el formulario de inicio de sesión
    document.querySelector('.login-container').classList.remove('hidden');
    // Ocultar el formulario de registro
    document.querySelector('.register-container').classList.add('hidden');
});

// Inicialmente ocultar el formulario de registro
document.querySelector('.register-container').classList.add('hidden');

// Manejar el envío del formulario de registro
document.getElementById('register-form').addEventListener('submit', async function(event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    const formData = new FormData(this); // Obtener los datos del formulario

    try {
        const response = await fetch('php/registrarUsuario.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.text(); // Obtener la respuesta del servidor
        console.log(result); // Mostrar la respuesta en la consola

        // Puedes agregar más lógica aquí para manejar la respuesta
        alert('Registro exitoso');
    } catch (error) {
        console.error('Error en la solicitud:', error);
        alert('Error al registrar. Por favor, intenta de nuevo.');
    }
});

// Manejar el envío del formulario de inicio de sesión
document.getElementById('login-form').addEventListener('submit', async function(event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    const formData = new FormData(this); // Obtener los datos del formulario

    try {
        const response = await fetch('php/validarUsuario.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.text(); // Obtener la respuesta del servidor
        console.log(result); // Mostrar la respuesta en la consola

        // Aquí puedes agregar lógica para redirigir según la respuesta
    } catch (error) {
        console.error('Error en la solicitud:', error);
        alert('Error al iniciar sesión. Por favor, intenta de nuevo.');
    }
});
