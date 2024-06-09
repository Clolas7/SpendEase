document.addEventListener('DOMContentLoaded', () => {
    const usersList = document.getElementById('users-list');
    const addUserForm = document.getElementById('add-user-form');

    function loadUsers() {
        fetch('/backend/src/components/get_users.php')
            .then(response => response.json())
            .then(users => {
                usersList.innerHTML = '';
                users.forEach(user => {
                    const userItem = document.createElement('div');
                    userItem.textContent = user.username;
                    usersList.appendChild(userItem);
                });
            });
    }

    addUserForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(addUserForm);
        fetch('/backend/src/components/add_user.php', {
            method: 'POST',
            body: formData
        }).then(() => {
            loadUsers();
            addUserForm.reset();
        });
    });

    loadUsers();
});
