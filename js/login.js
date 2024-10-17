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

document.getElementById('register-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const firstName = document.getElementById('first-name').value;
    const lastName = document.getElementById('last-name').value;
    const username = document.getElementById('new-username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    const errorMessage = document.getElementById('error-message-register');

    if (firstName === '' || lastName === '' || username === '' || email === '' || password === '' || confirmPassword === '') {
        errorMessage.textContent = 'Por favor, completa todos los campos';
        errorMessage.style.display = 'block';
    } else if (password !== confirmPassword) {
        errorMessage.textContent = 'Las contraseñas no coinciden';
        errorMessage.style.display = 'block';
    } else {
        errorMessage.style.display = 'none';
        alert('Registro exitoso');
    }
});
