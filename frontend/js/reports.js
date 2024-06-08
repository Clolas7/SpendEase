document.addEventListener('DOMContentLoaded', () => {
    fetch('/backend/src/components/get_report_data.php')
        .then(response => response.json())
        .then(data => {
            const expensesData = data.expenses.map(item => item.total_amount);
            const expensesLabels = data.expenses.map(item => `Category ${item.category_id}`);

            const incomesData = data.incomes.map(item => item.total_amount);
            const incomesLabels = data.incomes.map(item => item.source);

            const ctxExpenses = document.getElementById('expensesChart').getContext('2d');
            new Chart(ctxExpenses, {
                type: 'bar',
                data: {
                    labels: expensesLabels,
                    datasets: [{
                        label: 'Expenses',
                        data: expensesData,
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

            const ctxIncomes = document.getElementById('incomesChart').getContext('2d');
            new Chart(ctxIncomes, {
                type: 'bar',
                data: {
                    labels: incomesLabels,
                    datasets: [{
                        label: 'Incomes',
                        data: incomesData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
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
