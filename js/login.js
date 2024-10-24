document.getElementById('register-link').addEventListener('click', function(event) {
    event.preventDefault();
    const container = document.getElementById('container');
    container.classList.add('show-register');

    // Ocultar el formulario de inicio de sesión
    document.querySelector('.login-container').classList.add('hidden');
    // Mostrar el formulario de registro
    document.querySelector('.register-container').classList.remove('hidden');
});

document.getElementById('login-link').addEventListener('click', function(event) {
    event.preventDefault();
    const container = document.getElementById('container');
    container.classList.remove('show-register');

    // Mostrar el formulario de inicio de sesión
    document.querySelector('.login-container').classList.remove('hidden');
    // Ocultar el formulario de registro
    document.querySelector('.register-container').classList.add('hidden');
});

// Inicialmente ocultar el formulario de registro
document.querySelector('.register-container').classList.add('hidden');
