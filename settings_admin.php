<?php
session_start();
$user=$_SESSION['Username'];
$UserId = $_SESSION['Userid'] ?? null;
if (!isset($_SESSION['Username'])) {
    header("Location: login.php");
    exit();
}
else{
  echo "<script>console.log('Welcome back, $user');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Settings</title>
  <style>
    body {
      background-color: #f0f2f5;
      font-family: Arial, sans-serif;
      padding: 20px;
      margin: 0;
    }

    .container {
      display: flex;
      justify-content: center;
      gap: 40px;
    }

    .column {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      box-sizing: border-box;
      margin-top: 20px;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 18px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      color: #555;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    #submitbutton {
      margin-top: 10px;
      background-color: #4CAF50;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 6px;
      width: 100%;
      cursor: pointer;
      font-size: 16px;
    }

    #submitbutton:hover {
      background-color: #45a049;
    }
    button{
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
<form action="settings.php" method="post">
  <div class="container">
    <!--Previous Details-->
    <div class="column">
      <h2>Previous Details</h2>

      <div class="form-group">
        <label for="old-username">Username</label>
        <input type="text" name="old-username" id="old-username" placeholder="Enter old username" required>
      </div>

      <div class="form-group">
        <label for="old-email">Email</label>
        <input type="email" name="old-email" id="old-email" placeholder="Enter old email" required>
      </div>

      <div class="form-group">
        <label for="old-password">Password</label>
        <input type="password" name="old-password" id="old-password" placeholder="Enter old password" required>
      </div>

    
    </div>

    <!--New Details-->
    <div class="column">
      <h2>New Details</h2>
      <div class="form-group">
        <label for="new-name">Full Name</label>
        <input type="text" id="new-name" name="new-name" placeholder="Enter new name" required>
      </div>

      <div class="form-group">
        <label for="new-username">Username</label>
        <input type="text" id="new-username" name="new-username" placeholder="Enter new username" required>
      </div>

      <div class="form-group">
        <label for="new-email">Email</label>
        <input type="email" id="new-email" name="new-email" placeholder="Enter new email" required>
      </div>

      <div class="form-group">
        <label for="new-password">Password</label>
        <input type="password" id="new-password" name="new-password" placeholder="Enter new password" required>
      </div>

      <div class="form-group">
        <label for="new-role">Role</label>
        <select id="new-role" name="new-role" required>
          <option value="">--Select Role--</option>
          <option value="mentor">Mentor</option>
          <option value="mentee">Mentee</option>
        </select>
      
      </div>

     <!-- <button>Save Changes</button> -->
      <div class="form-group">
        <input type="submit" name="submit" value="Update Details" id="submitbutton">
    </div>
  </div>
</form>


<?php
$user=$_SESSION['Username'];
$UserId = $_SESSION['Userid'] ?? null;
  if(isset($_POST['submit'])) {
   $oldUsername = $_POST['old-username'];
  $oldEmail = $_POST['old-email'];
  $oldPassword = $_POST['old-password'];
  $name = $_POST['new-name'];
  $username = $_POST['new-username'];
  $email = $_POST['new-email'];
  $password = $_POST['new-password'];
  $role = $_POST['new-role'];

  $conn = mysqli_connect("localhost", "root", "", "mentorlink");
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }
  $sql = "SELECT * FROM users WHERE UserName='$oldUsername' AND password='$oldPassword'";
  $result = mysqli_query($conn, $sql);
         if (mysqli_num_rows($result) > 0) {
         echo "<script>alert('Old details verified successfully!');</script>";
               while($row= mysqli_fetch_assoc($result)) {
               $no = $UserId;
               echo "<script>alert('ID: $no');</script>";
               $updateSql = "UPDATE users SET Name='$name', UserName='$username', email='$email', password='$password', role='$role' WHERE Userid='$no'";
                 
               if (mysqli_query($conn, $updateSql)) {
            echo "<script>alert('Details updated successfully!');</script>";
                  header("Location: login.php");
                  exit();
                   } 
                   else {
            echo "<script>alert('Error updating details: " . mysqli_error($conn) . ")</script>";
                    }
                }
              
          
          }
          else {
      echo "<script>alert('Old details do not match!');</script>";
        }
      }

   

  ?>
</body>
</html>
