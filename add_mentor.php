<?php
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    $sql = "INSERT INTO mentors (name, email, username) VALUES ('$name', '$email', '$username')";
    if ($conn->query($sql) === TRUE) {
        echo "Mentor added successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}
echo '<a href="admin_dashboard.php">Back to Dashboard</a>';
?>
