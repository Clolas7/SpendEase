document.addEventListener("DOMContentLoaded", function() {
    fetch('/backend/src/components/get_report_details.php')
        .then(response => response.json())
        .then(data => {
            const reportDetailsContainer = document.getElementById('report-details');
            data.forEach(report => {
                const reportElement = document.createElement('div');
                reportElement.classList.add('report');
                reportElement.innerHTML = `
                    <p>${report.date}: ${report.amount} - ${report.description}</p>
                `;
                reportDetailsContainer.appendChild(reportElement);
            });
        });
});
