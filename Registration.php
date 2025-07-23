
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="registration.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/af8ea0c35a.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container" style="margin: 30px 500px">
        <form action="Registration.php" method="post">
            <i class="fa fa-user" aria-hidden="true"></i>
            <label class="values">Name: </label><br>
            <input class="values" type="text" name="Name" placeholder="Name" id="Name" required><br>

            <i class="fa fa-id-card" aria-hidden="true"></i>
            <label class="values">IDno: </label><br>
            <input type="text" class="values" name="IDno" placeholder="ID"  id="IDno" required><br>

            <i class="fa fa-mobile" aria-hidden="true"></i>
            <label class="values">Phone No: </label><br>
            <input type="text" class="values" name="PhoneNo" placeholder="Tel No"  id="PhoneNo" required><br>

            <i class="fa fa-envelope" aria-hidden="true"></i>
            <label class="values">Email: </label><br>
            <input type="Email" class="values" name="Email" placeholder="Email"  id="Email" required><br>

            <i class="fa fa-tasks" aria-hidden="true"></i>
            <label class="values">Program: </label><br>
            <input type="text" class="values" name="Program" placeholder="Program"  id="Program" required><br>

            <label class="values">Role: </label><br>
            <select class="values" name="Role" id="Role" style="width:45%; padding: 5px; border-radius: 10px;" required>
                <option value="mentor">Mentor</option>
                <option value="mentee">Mentee</option>
            </select><br>

<!--
            <i class="fa fa-spinner" aria-hidden="true"></i>
            <label class="values">Role: </label><br>
            <input type="text" class="values" name="Role" placeholder="Role"  id="Role"><br>
-->

            <i class="fa fa-user-plus" aria-hidden="true"></i>
            <label class="values">UserName: </label><br>
            <input type="text" class="values" name="UserName" placeholder="UserName"  id="UserName" required><br>

            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
            <label class="values">Password: </label><br>
            <input type="password" class="values" name="Password" placeholder="Password"  id="Password" required><br>
            
            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
            <label class="values">Repeat-Password: </label><br>
            <input type="password" class="values" name="Repeat-Password" placeholder="Repeat-Password"  id="Repeat-Password" required><br>
            
            <input type="submit" name="Submit" value="Submit" id="Submit" style="margin-top: 5px">
        </form>
    </div>


    

    <?php
    if(isset($_POST['Submit'])) {
        $conn=mysqli_connect("localhost","root","","mentorlink");
        if (!$conn) { 
            die("Connection failed: " . mysqli_connect_error());
        }

        $name = $_POST['Name'];
        $idno = $_POST['IDno'];
        $phoneNo = $_POST['PhoneNo'];
        $email = $_POST['Email'];
        $program = $_POST['Program'];
        $role = $_POST['Role'];
        $username = $_POST['UserName'];
        $password = $_POST['Password'];
        $repeatPassword = $_POST['Repeat-Password'];

        if ($password !== $repeatPassword) {
            echo "<script>alert('Passwords do not match!');</script>";
        } 
        
        else {
            $sql = "INSERT INTO users (name, IDno, PhoneNo, email, program, role, username, password) 
                    VALUES ('$name', '$idno', '$phoneNo', '$email', '$program', '$role', '$username', '$password');";
            $result= mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('Registration successful!');</script>";
                mysqli_close($conn);
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        }

    }
    ?>
    <?php
      $conn=mysqli_connect("localhost","root","","mentorlink");
        if (!$conn) { 
            die("Connection failed: " . mysqli_connect_error());
        }
        $program = $_POST['Program'];
        $username = $_POST['UserName'];
        $sql = "SELECT * FROM users WHERE program='$program' AND role='mentor'";
        $myid="SELECT Userid FROM users WHERE UserName='$username' AND role='mentee';";
        $result = mysqli_query($conn, $sql);
        $result2 = mysqli_query($conn, $myid);
        if ((mysqli_num_rows($result)) > 0 && (mysqli_num_rows($result2)) > 0) {
            $row= mysqli_fetch_assoc($result);
            $row2= mysqli_fetch_assoc($result2);
            $mentee_id = $row2['Userid'];
            $mentor_id = $row['Userid'];
            $match_sql = "INSERT INTO matches (mentor_id, mentee_id) VALUES ('$mentor_id', '$mentee_id')";
            if (mysqli_query($conn, $match_sql)) {
                echo "<script>alert('Match created successfully!');</script>";
            } else {
                echo "<script>alert('Error creating match: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('No mentor found for this program or invalid mentee username! or you are a mentor!');</script>";
        }
        mysqli_close($conn);
        
    ?>
           
    </body>
    </html>