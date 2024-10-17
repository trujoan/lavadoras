document.addEventListener('DOMContentLoaded', () => {
    const userForm = document.getElementById('user-form');
    const usersList = document.getElementById('users');
    const ordersList = document.getElementById('orders');
    const changeLog = document.getElementById('change-log').querySelector('ul');

    const users = []; // Array para almacenar usuarios
    const orders = []; // Array para almacenar órdenes (puedes añadir datos de ejemplo aquí)
    const changes = []; // Array para almacenar cambios

    userForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        if (username && password) {
            users.push({ username, password });
            updateUserList();
            logChange(`Usuario creado: ${username}`);
            userForm.reset();
        }
    });

    function updateUserList() {
        usersList.innerHTML = '';
        users.forEach(user => {
            const li = document.createElement('li');
            li.textContent = user.username;
            const deleteBtn = document.createElement('button');
            deleteBtn.textContent = 'Eliminar';
            deleteBtn.onclick = () => {
                deleteUser(user.username);
            };
            li.appendChild(deleteBtn);
            usersList.appendChild(li);
        });
    }

    function deleteUser(username) {
        const index = users.findIndex(user => user.username === username);
        if (index !== -1) {
            users.splice(index, 1);
            updateUserList();
            logChange(`Usuario eliminado: ${username}`);
        }
    }

    function logChange(message) {
        changes.push(message);
        const li = document.createElement('li');
        li.textContent = message;
        changeLog.appendChild(li);
    }

    // Aquí puedes agregar la lógica para mostrar y editar órdenes
    // Por ejemplo, puedes cargar órdenes de una API o un array
});
