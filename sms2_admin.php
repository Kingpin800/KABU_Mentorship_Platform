<?php
session_start();
if (!isset($_SESSION['Username'])) {
    header("Location: login.php");
    exit();
}
$user=$_SESSION['Username'];
$UserId = $_SESSION['Userid'] ?? null;
if (!isset($_SESSION['Username'])) {
    header("Location: login.php");
    exit();
}
else{
  
}
echo "<script>console.log('Welcome back, $user');</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sms</title>
  <style>
    body {
      background-image: url('sms.jpeg');
      background-size: cover;
      margin: 0;
      padding: 50px;
      text-align: center;
    }

    .message-container {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 8px black;
      width: 350px;
      text-align: left;
    }

    .received-messages {
      background-color: #f9f9f9;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 8px gray;
      width: 350px;
      text-align: left;
    }

    .form-group {
      margin-bottom: 15px;
    }

    input[type="text"] {
      width: 200px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .input-area {
      white-space: normal;
    }

    .input-area input[type="text"] {
      display: inline-block;
      width: 220px;
      margin-right: 10px;
    }

    .input-area input[type="submit"] {
      display: inline-block;
      margin-top: 10px;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 20px;
      cursor: pointer;
    }

    .input-area input[type="submit"]:hover {
      background-color: #45a049;
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
  <table align="center" cellspacing="30">
    <tr>
  <td>
        <div class="received-messages">
          <h3>Messages</h3>
         <!-- <p><strong>From:</strong> <br></p> -->
          <?php
            $conn = mysqli_connect("localhost", "root", "", "mentorlink");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "SELECT * FROM  messages INNER JOIN users WHERE sender_id=Userid AND receiver_id=$UserId;";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<p>From <strong>" . $row['UserName'] . ":</strong> " . $row['content'] . "</p>";
                }
              }
          ?>
        </div>
      </td>
      <td>
        <form action="sms2.php" method="post">
        <div class="message-container">
          <h3>Send Message</h3>
          <div class="form-group">
            <input type="text" name="recipient" id="recipient" placeholder="Send to..." required>
          </div>

          <div class="input-area">
            <input type="text" name="Message" id="message" placeholder="Type a message..." required><br>
            <input type="submit" value="Send" name="send" id="send">
          </div>

        </div>
            </form>
            <?php
            if (isset($_POST['send'])) {
               
                $recipient = $_POST['recipient'];
                $message = $_POST['Message'];
                $sender_id = $UserId;

                $recipient_sql = "SELECT Userid FROM users WHERE UserName='$recipient'";
                $recipient_result = mysqli_query($conn, $recipient_sql);
                if ($recipient_row = mysqli_fetch_assoc($recipient_result)) {
                    $receiver_id = $recipient_row['Userid'];

                    $insert_sql = "INSERT INTO messages (sender_id, receiver_id, content) 
                                   VALUES ('$sender_id', '$receiver_id', '$message')";
                    if (mysqli_query($conn, $insert_sql)) {
                        echo "<script>alert('Message sent successfully!');</script>";
                    } else {
                        echo "<script>alert('Error sending message: " . mysqli_error($conn) . "');</script>";
                    }
                } else {
                    echo "<script>alert('Recipient not found!');</script>";
                }
            }
            mysqli_close($conn);
            ?>
      </td>

      
    </tr>
  </table>

</body>
</html>
