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
            font-family: Arial, sans-serif;
            background-image: url(img/landing.jpg);
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 100px;
        }
        h1 {
            text-align: center;
        }
        .login-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-form input, .login-form button {
            padding: 10px;
            margin: 10px 0;
            width: 300px;
        }
        .login-form button {
            background-color: #ef8963;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-form button:hover {
            background-color: #e46f57;
        }
        .error {
            color: red;
            text-align: center;
        }
        .back-button{
            padding: 10px;
            width: 100px;
            margin: 10px 0;
            text-align: center;
            color: #fff;
            background-color: #f76d3b;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .back-button:hover{
            background-color: #e46f57;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
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
