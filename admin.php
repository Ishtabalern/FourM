<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f7f7f7;
        }

        .sidebar {
            width: 200px;
            background-color: #222;
            padding-top: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            padding-bottom: 30px;
        }

        .sidebar img {
            width: 80%;
            margin: 0 auto 20px auto;
            display: block;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .sidebar h3 {
            color: white;
            font-size: 18px;
            margin-left: 30px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 40px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            width: 100%;
            text-align: left;
            font-size: 14px;
            transition: background-color 0.3s ease;
            border-left: 3px solid transparent;
            margin-bottom: 5px;
            box-sizing: border-box;
        }

        .sidebar a:hover {
            background-color: #ff5500;
            border-left: 3px solid #ffffff;
        }

        .logout {
            display: inline-block;
            position: absolute;
            top: 20px;
            right: 30px;
            padding: 8px 16px;
            background-color: #e53e3e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .logout:hover {
            background-color: #ff5500;
        }

        .content {
            margin-left: 220px;
            padding: 30px;
            width: calc(100% - 220px);
        }

        h2 {
            font-size: 24px;
            color: #333;
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
        }

        .section {
            margin-top: 20px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            font-size: 14px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ff5500;
            color: white;
        }

        td {
            background-color: #fff;
        }

        tr:nth-child(even) td {
            background-color: #f4f4f4;
        }

        tr:hover td {
            background-color: #e0e0e0;
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 6px 12px;
            margin: 0 5px;
            background-color: #ff5500;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 12px;
        }

        .pagination a:hover {
            background-color: rgb(208, 108, 58);
        }
        .sidebar img {
            width: 120px; 
            height: 120px; 
            margin: 0 auto 20px auto;
            display: block;
            border-radius: 50%; 
            border: 3px solid #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

       
    </style>
</head>
<body>
    <a href="logout.php" class="logout">Logout</a>
    <div class="sidebar">
        <img src="img/logo.jpg" alt="Logo">
        <h3>FourM - Admin</h3>
        <a href="admin.php?section=sales">Sales Report</a>
        <a href="admin.php?section=stock">Stock Report</a>
        <a href="admin.php?section=update">Update Products</a>
        <a href="admin.php?section=analytics">Analytics</a>
    </div>

    <div class="content">
        <h2>Admin Dashboard</h2>
        <div class="section">
            <?php
            if (isset($_GET['section'])) {
                $section = $_GET['section'];
                switch ($section) {
                    case 'sales':
                        echo "<h3 style='text-align: center;'>Sales Report</h3>"; 
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
