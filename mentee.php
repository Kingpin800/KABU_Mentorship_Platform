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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mentee Dashboard</title>
  <link rel="stylesheet" href="dashboard.css" />
<style>
    .nav a{
      margin: 30px;
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
      <h2>Mentee Panel</h2>
      <ul class="nav">
        <ul class="nav">
  <li><a href="mentee.php">Dashboard</a></li>
  <li><a href="notification_mentee.php">Notifications</a></li>
  <li><a href="settings_mentee.php">Settings</a></li>
  <li><a href="sms2_mentee.php">Messages</a></li>
  <li><a href="login.php">LOGOUT</a></li>
</ul>
 </ul>
    </div>

    <div class="main">
      <div class="header">
        <?php
        echo "<h1>Welcome, $userName</h1>";
      ?>
      </div>

      <div class="cards">
        <div class="card">
          <p>Total Mentors</p>
          <?php
            $conn=mysqli_connect("localhost","root","","mentorlink");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            };
            $sql = "SELECT COUNT(*) as total FROM users WHERE role='mentor'";
            $result = mysqli_query($conn, $sql);
            if($result2=mysqli_fetch_assoc($result)){
              $row=$result2['total'];
              echo "<h3>".$row ."</h3>";
            }
          ?>
        </div>
       
        <div class="card">
          <p>Notifications</p>
          <?php
            $conn=mysqli_connect("localhost","root","","mentorlink");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            };
            $sql = "SELECT COUNT(*) as total FROM sessions";
            $result = mysqli_query($conn, $sql);
            if($result2=mysqli_fetch_assoc($result)){
              $row=$result2['total'];
              echo "<h3>".$row ."</h3>";
            };
            ?>
        </div>
        <!--<div class="card">
          <p>Ongoing</p>
          <h3></h3>
        </div> -->
         <div class="card">
          <p>sms</p>
          <?php
            $conn=mysqli_connect("localhost","root","","mentorlink");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            };
            $sql = "SELECT COUNT(*) as total FROM messages WHERE receiver_id=$UseId";
            $result = mysqli_query($conn, $sql);
            if($result2=mysqli_fetch_assoc($result)){
              $row=$result2['total'];
              echo "<h3>".$row ."</h3>";
            }
          ?>
        </div>
      </div>

      <div class="section">
        <div class="section-header">
          <h2>Mentors List</h2>
          
        </div>

        <table>
          <thead>
            <tr>
              <th>No.</th>
              <th>Name</th>
              <th>Email</th>
              
              <th>Event</th>
              
              
            </tr>
          </thead>
          <tbody>
            <tr>
        <!--      <td>1</td>
              <td></td>
              <td></td>
              
<td>
  <div class="progress">
    <div class="progress-bar" data-id="1" style="width: 0%"></div>
  </div>
</td>
<td>
  <select class="event-select" data-id="1" onchange="handleEventChange(this)">
    <option value="">Select Event</option>
    <option value="Event A">Event A</option>
    <option value="Event B">Event B</option>
    <option value="Event C">Event C</option>
  </select>
</td>

<td><span class="badge status" data-id="1">Pending</span></td>

              
              <td>  <button>View</button>
                <button class="danger">Remove</button>
              </td>
          -->
              <?php
                 $conn=mysqli_connect("localhost","root","","mentorlink");
                 if (!$conn) {
                     die("Connection failed: " . mysqli_connect_error());
                 };
                 $sql = "SELECT * FROM matches INNER JOIN users ON matches.mentor_id=users.Userid WHERE matches.mentee_id='$UseId';";
                 $sql2 = "SELECT * FROM (sessions INNER JOIN(matches INNER JOIN users ON matches.mentor_id=users.Userid) ON sessions.match_id=matches.id) ;";
                 $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0) {
                      $no = 1; 
                      while ($row = mysqli_fetch_assoc($result)) {
                          $name = $row['UserName'];
                          $email = $row['email'];
                          echo "<tr>";
                          echo "<td>".$no."</td>";
                          echo "<td>".$name."</td>";
                          echo "<td>".$email."</td>";
                         

                          echo "<td>";
                            
                             $result2 = mysqli_query($conn, $sql2);
                             if (mysqli_num_rows($result) > 0) {
                              echo "<select>"; 
                              echo "<option value=''>Select Event</option>";
                              while ($row2 = mysqli_fetch_assoc($result2)) {
                                $EventName = $row2['EventName'];
                                $MentorName = $row2['MentorName'];
                                echo "<option value='".$EventName."'>".$EventName." by ".$MentorName."</option>";
                                            
                              }
                              echo "</select>"; 
                            }
                          echo "</td>";
                          
                         
                            
                          echo "</tr>";
                          $no++;
                          
                      }
                  } else {
                      echo "<tr><td colspan='5'>No mentors found.</td></tr>";
                  }
                
                
                          
                
              ?>
            </tr>
            <!-- Add more rows as needed -->
          </tbody>
        </table>
      </div>

    </div>
  </div>

  <script src="dashboard.js"></script>
</body>
</html>
