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
    <title>Admin Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 85%;
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2.2em;
            font-weight: 600;
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .logout {
            text-align: right;
            margin-top: -20px;
        }
        .logout button {
            background-color: #ff5500;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }
        .logout button:hover {
            background-color: #ff5500;
        }
        .chart-container {
            margin-top: 40px;
        }
        canvas {
            width: 100% !important;
            height: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sales Analytics</h1>
        <div class="logout">
            <button onclick="window.location.href='logout.php'">Logout</button>
        </div>
        <div class="chart-container">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
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
                        borderColor: '#4bc0c0',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date',
                                font: {
                                    size: 14,
                                    weight: '600'
                                }
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total Sales (₱)',
                                font: {
                                    size: 14,
                                    weight: '600'
                                }
                            },
                            ticks: {
                                font: {
                                    size: 12
                                },
                                beginAtZero: true
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
