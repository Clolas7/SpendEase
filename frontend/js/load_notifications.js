document.addEventListener('DOMContentLoaded', () => {
    fetch('/backend/src/components/get_notifications.php')
        .then(response => response.json())
        .then(data => {
            const notificationsDiv = document.getElementById('notifications');
            data.forEach(notification => {
                const notificationElement = document.createElement('div');
                notificationElement.textContent = `${notification.date_sent}: ${notification.message}`;
                notificationsDiv.appendChild(notificationElement);
            });
        });
});
