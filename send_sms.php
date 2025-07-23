<?php
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipient = $_POST['recipient'];
    $message = $_POST['message'];

    $sql = "INSERT INTO sms (recipient, message) VALUES ('$recipient', '$message')";
    if ($conn->query($sql) === TRUE) {
        echo "Message sent.";
    } else {
        echo "Error: " . $conn->error;
    }
}
echo '<a href="admin_dashboard.php">Back to Dashboard</a>';
?>
