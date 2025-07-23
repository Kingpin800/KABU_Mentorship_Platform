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
<?php
 if (isset($_GET['action']) && $_GET['action'] === 'set_session') {
    $_SESSION['username'] = 'Moses';
    echo "Session for username is set!";
    header("Location: mentordashboard.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mentor's Dashboard</title>
  <link rel="stylesheet" href="dashboard.css" />
<style>
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
      <h2>Mentor Dashboard</h2>
      <ul class="nav">
        <ul class="nav">
  <li><a href="mentordashboard.php">Dashboard</a></li>
  <li><a href="events.php">Events</a></li>
  <li><a href="notification.php">Notifications</a></li>
  <li><a href="settings.php?action=set_session">Settings</a></li>
  <li><a href="sms2.php">Messages</a></li>
  <li><a href="login.php">LOG OUT</a></li>
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
          <p>Total Mentees</p>
          <h3 id="Total"></h3>
          <?php
            $conn=mysqli_connect("localhost","root","","mentorlink");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            };
            $sql = "SELECT COUNT(*) as total FROM users WHERE role='mentee'";
            $result = mysqli_query($conn, $sql);
            if($result2=mysqli_fetch_assoc($result)){
              $row=$result2['total'];
              echo "<h3>".$row ."</h3>";
            }
          ?>
        </div>
        <div class="card">
          <p>Events</p>
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
      <!--  <div class="card">
          <p>Ongoing</p>
          <h3 id="Ongoing"></h3>
        </div> -->
         <div class="card">
          <p>Messages</p>
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
          <h2>Mentees List</h2>
        </div>

        <table>
          <thead>
            <tr>
              <th>No.</th>
              <th>Name</th>
              <th>Email</th>
              <th>Progress</th>
              <th>Event</th>
            </tr>
          </thead>
          <tbody>
<!-- <tr>
              <td>1</td>
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
            </tr> 
-->
            <tr>
              <?php
                 $conn=mysqli_connect("localhost","root","","mentorlink");
                 if (!$conn) {
                     die("Connection failed: " . mysqli_connect_error());
                 };
                 $sql = "SELECT * FROM matches INNER JOIN users ON matches.mentee_id=users.Userid WHERE matches.mentor_id='$UseId';";
                 $sql2 = "SELECT * FROM (sessions INNER JOIN(matches INNER JOIN users ON matches.mentee_id=users.Userid) ON sessions.match_id=matches.id) ;";
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
                          echo "<td>
                            <div class='progress'>
                              <div class='progress-bar' data-id='Progress1'".$no."' style='width: 100%'></div>
                            </div>
                          </td>";

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
                          echo "<script>
                          if ((document.getElementById('Progress1').style.width) == '100%') {
                            document.getelementbyId('status').innerHTML = 'Completed';
                          } else {
                          document.getelementbyId('status').innerHTML = 'pending';
                          }
                          </script>";
                          
                            
                          echo "</tr>";
                          $no++;
                          
                      }
                  } else {
                      echo "<tr><td colspan='7'>No mentees found.</td></tr>";
                  }
                
                
                          
                
              ?>
            </tr>  
            <!-- Add more rows as needed -->
          </tbody>
        </table>
      </div>

    </div>
  </div>

<script>
  function addNew() {
  alert("Add New clicked!");
   }

 function addMentee() {
  if(confirm("Are you sure you want to remove the mentee?")==true) {
   
  alert("Mentee removed successfully!");
} else {
    alert("Action cancelled.");
  }

  <?php
    
  ?>
 }
 function addNew() {
  alert("Add New clicked!");
 }

 function updateStatus(id) {
  const progressBar = document.querySelector(`.progress-bar[data-id="${id}"]`);
  const badge = document.querySelector(`.badge.status[data-id="${id}"]`);
  if (!progressBar || !badge) return;

  // Extract the numeric width value, remove the '%' sign, and convert to number
  const width = parseInt(progressBar.style.width);

  if (width === 100) {
    badge.textContent = "Completed";
    badge.classList.remove("pending");
    badge.classList.add("complete");
  } else {
    badge.textContent = "Pending";
    badge.classList.remove("complete");
    badge.classList.add("pending");
  }
 }

 // Example: call updateStatus for all rows (if multiple)
 document.querySelectorAll('.progress-bar').forEach(bar => {
  const id = bar.getAttribute('data-id');
  updateStatus(id);
 });
</script>

</body>
</html>
