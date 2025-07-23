<?php
session_start();
if (!isset($_SESSION['Username'])) {
    header("Location: login.php");
    exit();
}

$userName= $_SESSION['Username'];
if (empty($userName)) {
    header("Location: login.php");
    exit();
}
if (isset($_SESSION['Userid'])) {

    $UseId = $_SESSION['Userid'];
} else {
    $UseId = null; // or handle the case where id is not set
}
if (empty($UseId)) {
    header("Location: login.php");
    exit();
}
echo "<script>console.log('Welcome back, $userName');</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Notification Center</title>
  <style>
    body {
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
      
    }

    .notification-center {
      max-width: 800px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .row {
      white-space: normal;
      font-size: 0; 
    }

    .section {
      display: inline-block;
      width: 48%;
      vertical-align: top;
      margin: 0 1%;
      font-size: 14px;
    }

    h2 {
      margin-top: 0;
      color: #333;
    }

    .notification {
      background-color: #e9f0f7;
      padding: 12px;
      margin-bottom: 10px;
      border-left: 4px solid #3b82f6;
      border-radius: 4px;
      white-space: normal;
      word-wrap: break-word;
    }

    .event-notification {
      background-color: #fcefe8;
      border-left-color: #f97316;
    }
    button{
    text-align: left;
    padding: 10px; 
    background-color: #4CAF50; 
    color: white; 
    border: none; 
    border-radius: 5px; 
    cursor: pointer;
    }
  </style>
</head>
<body>
<button onclick="window.location.href='admin_dashboard.php'" >Back to Dashboard</button>
  <div class="notification-center">
    <div class="row">
      
      <div class="section">
        <h2>Event Notifications</h2>
        <?php
    $conn = mysqli_connect('localhost', 'root', '', 'mentorlink');
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM sessions";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="notification event-notification">';
        echo '<label>' . $row['EventName'] . ' on ' . $row['Day'] . ' at ' . $row['Time'];
        echo '<input type="checkbox"><br>';
        echo '</label>';
        echo '<small>Mentor: ' . $row['MentorName'] . '</small>';
        echo '</div>';
      }
    } else {
      echo '<p>No events scheduled yet.</p>';
    }
    ?>
      </div>

      
      <div class="section">
        <h2>General Notifications</h2>
        <div class="notification">Update</div>
        <div class="notification">Profile updated.</div>
      </div>
    </div>
  </div>

</body>
</html>
