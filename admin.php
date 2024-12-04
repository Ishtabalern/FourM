<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        .nav {
            margin-bottom: 20px;
        }
        .nav a {
            margin-right: 10px;
            padding: 10px 15px;
            background-color: #e46f57;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .nav a:hover {
            background-color:#f14b2a;
        }
        .section {
            margin-top: 20px;
        }
        .logout {
            float: right;
            padding: 10px 15px;
            background-color: #d9534f;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <a href="logout.php" class="logout">Logout</a>
        <div class="nav">
            <a href="admin.php?section=sales">Sales Report</a>
            <a href="admin.php?section=stock">Stock Report</a>
            <a href="admin.php?section=update">Update Products</a>
            <a href="admin.php?section=analytics">Analytics</a>
        </div>
        <div class="section">
            <?php
            if (isset($_GET['section'])) {
                $section = $_GET['section'];
                switch ($section) {
                    case 'sales':
                        include 'sales_report.php';
                        break;
                    case 'stock':
                        include 'stock_report.php';
                        break;
                    case 'update':
                        include 'update_products.php';
                        break;
                    case 'analytics':
                        include 'analytics.php';
                        break;
                    default:
                        echo "<p>Please select a section.</p>";
                }
            } else {
                echo "<p>Welcome to the Admin Dashboard. Please select a section above.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
