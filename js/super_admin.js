document.addEventListener('DOMContentLoaded', () => {
    fetchUsers();

    document.getElementById('user-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const userId = document.getElementById('user-id').value;
        if (userId) {
            updateUser(userId);
        } else {
            createUser();
        }
    });
});

function fetchUsers() {
    fetch('get_users.php')
        .then(response => response.json())
        .then(data => {
            const userList = document.getElementById('users');
            userList.innerHTML = '';
            data.forEach(user => {
                const li = document.createElement('li');
                li.textContent = `${user.first_name} ${user.last_name} - ${user.username}`;
                li.appendChild(createEditButton(user.user_id));
                li.appendChild(createDeleteButton(user.user_id));
                userList.appendChild(li);
            });
        })
        .catch(error => console.error('Error fetching users:', error));
}

function createEditButton(userId) {
    const button = document.createElement('button');
    button.textContent = 'Editar';
    button.onclick = () => editUser(userId);
    return button;
}

function createDeleteButton(userId) {
    const button = document.createElement('button');
    button.textContent = 'Eliminar';
    button.onclick = () => deleteUser(userId);
    return button;
}

function createUser() {
    const data = {
        first_name: document.getElementById('first-name').value,
        last_name: document.getElementById('last-name').value,
        username: document.getElementById('new-username').value,
        email: document.getElementById('email').value,
        password: document.getElementById('new-password').value,
    };

    fetch('register_user.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        fetchUsers();
        document.getElementById('user-form').reset();
    })
    .catch(error => console.error('Error creating user:', error));
}

function editUser(userId) {
    fetch(`get_user.php?id=${userId}`)
        .then(response => response.json())
        .then(user => {
            document.getElementById('user-id').value = user.user_id;
            document.getElementById('first-name').value = user.first_name;
            document.getElementById('last-name').value = user.last_name;
            document.getElementById('new-username').value = user.username;
            document.getElementById('email').value = user.email;
            // No mostramos la contraseña por razones de seguridad
        })
        .catch(error => console.error('Error fetching user:', error));
}

function updateUser(userId) {
    const data = {
        user_id: userId,
        first_name: document.getElementById('first-name').value,
        last_name: document.getElementById('last-name').value,
        username: document.getElementById('new-username').value,
        email: document.getElementById('email').value,
        // Aquí puedes decidir si actualizar o no la contraseña
        // password: document.getElementById('new-password').value,
    };

    fetch('update_user.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        fetchUsers();
        document.getElementById('user-form').reset();
    })
    .catch(error => console.error('Error updating user:', error));
}

function deleteUser(userId) {
    if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        fetch(`delete_user.php?id=${userId}`, { method: 'DELETE' })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            fetchUsers();
        })
        .catch(error => console.error('Error deleting user:', error));
    }
}
