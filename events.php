<?php
session_start();
if (!isset($_SESSION['Username'])) {
    header("Location: login.php");
    exit();
}
$user1=$_SESSION['Username'];
$UserId = $_SESSION['Userid'] ?? null;
if (!isset($_SESSION['Username'])) {
    header("Location: login.php");
    exit();
}
else{
  echo "<script>console.log('Welcome $user1 and $UserId');</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Event viewer</title>
  <style>
    body {
      background-color: #f0f2f5;
      font-family: Arial, sans-serif;
      padding: 40px;
      margin: 0;
    }

    .scheduler-container,
    .events-container {
      background-color: #fff;
      width: 48%;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      box-sizing: border-box;
      float: left;
      margin-right: 4%;
    }

    .events-container {
      margin-right: 0;
    }

    .clear {
      clear: both;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="date"],
    input[type="time"],
    select {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    #submit {
      background-color: #4CAF50;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 6px;
      width: 100%;
      cursor: pointer;
      font-size: 16px;
    }

    #submit:hover {
      background-color: #45a049;
    }

    .event-item {
      border-left: 4px solid #3b82f6;
      background-color: #e9f0f7;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 6px;
    }

    .event-item label {
      font-weight: normal;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .event-item input[type="checkbox"] {
      margin-left: 10px;
      transform: scale(1.2);
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
    margin-bottom: 20px; 
    background-color: #4CAF50; 
    color: white; 
    border: none; 
    border-radius: 5px; 
    cursor: pointer;
    }
  </style>
</head>
<body>
  <div>
 <button onclick="window.location.href='mentordashboard.php'" >Back to Dashboard</button>
 </div>
  <div class="scheduler-container">
    <h2>Schedule an Event</h2>
   
    
    <form method="post" action="events.php">
      <div class="form-group">
      <label for="event-name">Event Name</label>
      <input type="text" id="event-name" placeholder="Enter event name" name="event-name" required>
    </div>

    <div class="form-group">
      <label for="day">Day of the Week</label>
      <select id="day"  name="day">
        <option>Monday</option>
        <option>Tuesday</option>
        <option>Wednesday</option>
        <option>Thursday</option>
        <option>Friday</option>
      </select>
    </div>

    <div class="form-group">
      <label for="time">Time</label>
      <input type="time" id="time" name="time" required>
    </div>

    <div class="form-group">
      <label for="months">Months</label>
      <input type="date" id="months" placeholder="Enter number of months" name="months" required>
    </div>

    <div class="form-group">
      <label for="mentor">Mentor</label>
      <input type="text" id="mentor" placeholder="Input mentor name" name="mentor" required>
    </div>

   <!--<button onclick="eventsheduler()">Schedule Event</button> -->
   <input type="submit" value= "Schedule Event" onclick="eventsheduler()" name="schedule_event" id="submit">
  </div>
  </form>


  <div class="events-container">
    <h2>Scheduled Events</h2>
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

  <div class="clear"></div>

  <?php
  
      
      if (isset($_POST['schedule_event'])) {
      $user1=$_SESSION['Username'];
      $UserId = $_SESSION['Userid'] ?? null;
      $eventName = $_POST['event-name'];
      $day = $_POST['day'];
      $time = $_POST['time'];
      $months = $_POST['months'];
      $mentor = $_POST['mentor'];
          if (empty($eventName) || empty($day) || empty($time) || empty($months) || empty($mentor)) {
            echo "<script>alert('Please fill in all fields.');</script>";
            exit;
          }

          else {
            addcontent($eventName, $day, $time, $months, $mentor, $UserId, $user1);
          };
      }
        function addcontent($eventName, $day, $time, $months, $mentor, $UserId, $user1) {
          $conn = mysqli_connect('localhost', 'root', '', 'mentorlink');

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Find match_id for the logged-in mentor (use $UseId as passed from session or elsewhere)
    $checker = "SELECT matches.id FROM matches 
                INNER JOIN users ON matches.mentor_id = users.Userid 
                WHERE users.UserName = '$user1';";

    $result = mysqli_query($conn, $checker);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $match_id = $row['id'];

            // Now insert session with correct match_id
            $sql = "INSERT INTO sessions (EventName, Day, Time, Date, MentorName, match_id) 
                    VALUES ('$eventName', '$day', '$time', '$months', '$mentor', '$match_id')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Event scheduled successfully!');</script>";
            } else {
                echo "<script>alert('Error scheduling event: " . mysqli_error($conn) . "');</script>";
            }
        }
    } else {
        echo "<script>alert('No match found for this mentor.');</script>";
    }

    mysqli_close($conn);
      }
  ?>

</body>
</html>
