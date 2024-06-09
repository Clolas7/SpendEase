document.addEventListener("DOMContentLoaded", function() {
    fetch('/backend/src/components/get_notifications.php')
        .then(response => response.json())
        .then(data => {
            const notificationsContainer = document.getElementById('notifications');
            data.notifications.forEach(notification => {
                const notificationElement = document.createElement('div');
                notificationElement.classList.add('notification');
                notificationElement.innerHTML = `
                    <p>${notification.message}</p>
                    <small>${new Date(notification.date_sent).toLocaleString()}</small>
                    <button onclick="markAsRead(${notification.id})">Mark as Read</button>
                    <button onclick="deleteNotification(${notification.id})">Delete</button>
                `;
                notificationsContainer.appendChild(notificationElement);
            });
        });
});

function markAsRead(id) {
    fetch('/backend/src/components/manage_notifications.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=mark_read&id=${id}`
    }).then(() => {
        location.reload();
    });
}

function deleteNotification(id) {
    fetch('/backend/src/components/manage_notifications.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=delete&id=${id}`
    }).then(() => {
        location.reload();
    });
}
