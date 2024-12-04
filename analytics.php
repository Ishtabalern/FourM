<?php
include 'db.php';

// Fetch sales data for the graph
$sales_data = [];
$sql = "SELECT DATE(date) as date, SUM(total) as total_sales FROM sales GROUP BY DATE(date)";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $sales_data[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        h1 {
            text-align: center;
        }
        .logout {
            text-align: right;
        }
        .logout button {
            background-color: #e46f57;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout button:hover {
            background-color: #c55a42;
        }
        .chart-container {
            width: 100%;
            height: 400px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sales Analytics</h2>
        <div class="chart-container">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const salesData = <?php echo json_encode($sales_data); ?>;
            const labels = salesData.map(data => data.date);
            const sales = salesData.map(data => data.total_sales);

            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Sales (₱)',
                        data: sales,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total Sales (₱)'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
