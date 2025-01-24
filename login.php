<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.html");
            }
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .login-form input {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            outline: none;
            transition: border 0.3s;
        }

        .login-form input:focus {
            border: 1px solid #ff7e5f;
        }

        .login-form button {
            padding: 12px;
            background: #ff7e5f;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .login-form button:hover {
            background: #ff5733;
        }

        .error {
            text-align: center;
            color: #ff4d4d;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 10px;
        }

        .back-button {
            text-align: center;
            text-decoration: none;
            display: block;
            padding: 10px;
            background: #ddd;
            color: #333;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .back-button:hover {
            background: #bbb;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            .login-form input, .login-form button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Four-M Login</h1>
        <?php if (isset($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form class="login-form" method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <a href="index.html" class="back-button">Back</a>
        </form>
    </div>
</body>
</html>
