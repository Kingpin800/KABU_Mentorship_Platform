<?php
session_start();
$Userid=$_SESSION['Userid'] ?? '';
$user=$_SESSION['Username'] ?? '';
if ($user == '') {
    header("Location: login.php");
    exit();
} 
?>
<?php
echo "<script>console.log('User: $user');</script>";
echo "<script>console.log('User ID: $Userid');</script>";
include('conn.php');

// Count queries
$mentor_count = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='mentor'")->fetch_assoc()['total'];
$mentee_count = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='mentee'")->fetch_assoc()['total'];
$event_count = $conn->query("SELECT COUNT(*) AS total FROM sessions")->fetch_assoc()['total'];
$sms_count = $conn->query("SELECT COUNT(*) AS total FROM messages")->fetch_assoc()['total'];

// List queries
$mentors = $conn->query("SELECT * FROM users WHERE role='mentor'");
$mentees = $conn->query("SELECT * FROM users WHERE role='mentee'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <style>
    body { 
      margin: 0;
      font-family: Arial, sans-serif; 
      background-color: #f5f5f5; 
    }
    .container { 
      display: flex; 
      min-height: 100vh; 
    }
    .sidebar { 
      width: 200px; 
      background-color: #2c3e50; 
      color: white; 
      padding: 20px; 
    }
    .sidebar h2 { 
      text-align: center; 
      margin-bottom: 20px; 
    }
    .nav { 
      list-style: none; 
      padding: 0; 
    }
    .nav li { 
      margin: 10px 0;
    }
    .nav a { 
      color: white; 
      text-decoration: none; 
      display: block; 
      padding: 8px; 
      border-radius: 4px; 
    }
    .nav a:hover { 
      background-color: #34495e; 
    }
    .main { 
      flex: 1; 
      padding: 20px; 
    }
    .header { 
      display: flex; 
      justify-content: space-between; 
      align-items: center; 
    }
    .search-add input { 
      padding: 5px; 
    }
    .search-add button { 
      padding: 6px 10px; 
      margin-left: 10px; 
    }
    .cards { 
      display: flex; 
      gap: 20px; 
      margin: 20px 0; 
    }
    .card { 
      background: white; 
      padding: 20px; 
      border-radius: 5px; 
      flex: 1; 
      box-shadow: 0 0 5px rgba(0,0,0,0.1); 
    }
    .section { 
      background: white; 
      padding: 20px; 
      border-radius: 5px; 
      box-shadow: 0 0 5px rgba(0,0,0,0.1); 
      margin-top: 20px; 
    }
    .section-header { 
      display: flex; 
      justify-content: space-between; 
      align-items: center; 
      margin-bottom: 20px; 
    }
    table { 
      width: 100%; 
      border-collapse: collapse; 
    }
    th, td { 
      padding: 12px; 
      border: 1px solid #ddd; 
      text-align: left; 
    }
    th { 
      background-color: #f0f0f0; 
    }
    button { 
      padding: 5px 10px; 
      border: none; 
      background-color: #3498db; 
      color: white; 
      border-radius: 4px; 
      cursor: pointer; 
    }
    button:hover { 
      opacity: 0.9; 
    }
     .nav a{
      margin: 20px;
      transition: transform 0.3s ease-in-out;
    }
    .nav a:hover {
      transform: scale(1.1);
      box-shadow: 0 0 10px rgba(0,0,0,0.4);
    }
    .card{
       transition: transform 0.3s ease-in-out;
    }
    .card:hover {
       transform: scale(1.1);
     box-shadow: 0 0 10px rgba(0,0,0,0.4);
    }

  </style>
</head>
<body>

<div class="container">
  <div class="sidebar">
    <h2>Admin Panel</h2>
    <ul class="nav">
  <li><a href="mentordashboard.php">Dashboard</a></li>
  <li><a href="events_admin.php">Events</a></li>
  <li><a href="notification_admin.php">Notifications</a></li>
  <li><a href="settings_admin.php?action=set_session">Settings</a></li>
  <li><a href="sms2_admin.php">Messages</a></li>
  <li><a href="login.php">LOG OUT</a></li>
    </ul>
  </div>

  <div class="main">
    <div class="header">
      <h1>Dashboard</h1>
      <div class="search-add">
        <a href="Registration_admin.php"><button>Add New</button></a>
      </div>
    </div>

    <div class="cards">
      <div class="card"><p>Total Mentors</p><h3><?php echo $mentor_count; ?></h3></div>
      <div class="card"><p>Total Mentees</p><h3><?php echo $mentee_count; ?></h3></div>
      <div class="card"><p>Events</p><h3><?php echo $event_count; ?></h3></div>
      <div class="card"><p>Notifications</p><h3><?php echo $sms_count; ?></h3></div>
    </div>

    <div class="section">
      <div class="section-header">
        <h2>Mentor's List</h2>
      </div>
      <table>
        <thead><tr><th>No.</th><th>Name</th><th>Email</th><th>Username</th></tr></thead>
        <tbody>
        <?php $i = 1; while ($row = $mentors->fetch_assoc()): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['UserName']; ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <div class="section">
      <div class="section-header">
        <h2>Mentees List</h2>
      </div>
      <table>
        <thead><tr><th>No.</th><th>Name</th><th>Email</th><th>Event</th><th>Mentor</th></tr></thead>
        <tbody>
        <?php
        $mentees = $conn->query("SELECT * FROM (users LEFT JOIN(sessions LEFT JOIN matches ON matches.id=sessions.match_id) ON matches.mentee_id=users.Userid) WHERE users.role='mentee';");
        $i = 1;
        while ($row = $mentees->fetch_assoc()):
          $mentor = $conn->query("SELECT * FROM (sessions INNER JOIN(matches INNER JOIN users ON matches.mentor_id=users.Userid) ON sessions.match_id=matches.id) ;")->fetch_assoc();
        ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['EventName']; ?></td>
            <td><?php echo $mentor['name'] ?? 'Unassigned'; ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

</body>
</html>
