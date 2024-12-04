<?php
include 'db.php';

// Hash the password
$hashed_password = password_hash('userpassword', PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password) VALUES ('user', '$hashed_password')";
if ($conn->query($sql) === TRUE) {
    echo "Admin user created successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
