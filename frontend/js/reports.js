document.addEventListener('DOMContentLoaded', () => {
    const ctxExpenses = document.getElementById('expensesChart').getContext('2d');
    const ctxIncomes = document.getElementById('incomesChart').getContext('2d');

    fetch('../../backend/src/components/get_expenses.php')
        .then(response => response.json())
        .then(data => {
            new Chart(ctxExpenses, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Expenses',
                        data: data.amounts,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

    fetch('../../backend/src/components/get_incomes.php')
        .then(response => response.json())
        .then(data => {
            new Chart(ctxIncomes, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Incomes',
                        data: data.amounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
});
